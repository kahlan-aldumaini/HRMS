<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Enum\FingerprintMovement;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\HelperControler;
use App\Models\Bransh;
use App\Models\Employee;
use App\Models\Fingerprint;
use App\Models\GroupEmployees;
use App\Models\GroupOfSets;
use App\Models\JobData;
use App\Models\Sanction;
use App\Models\Shift;
use App\Models\User;
use App\Models\Vacation;
use App\Models\VacationEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MigrationController extends Controller
{
    public function index()
    {
        [$filters, $hasFilter] = HelperControler::getFiltersFromRequest();
        $group = null;
        if (isset($filters['group']) and $hasFilter) {
            $group = GroupOfSets::withTrashed()->find($filters['group']);
        }
        $fingerprints = Fingerprint::with([
            'employee',
            'employee.user',
            'shift',
            'shift.group'
        ])->orderByDesc('updated_at')
            ->whereIn('employee_id', HelperControler::getCurrentEmployee())
            ->when($group, fn ($q, $r) => $q->whereRelation('shift', 'group_of_sets_id', $r->id))
            ->whereRelation('shift', 'day', Carbon::today()->dayName)
            ->get()
            ->map(fn ($fingerprint) => [
                'id' => $fingerprint->id,
                'user_name' => $fingerprint->employee->name,
                'group_name' => GroupOfSets::withTrashed()
                    ->whereRelation('shifts', 'id', $fingerprint?->shift?->id)
                    ->first()?->name,
                'day' => $fingerprint->shift?->day,
                'shift_name' => $fingerprint?->shift?->name,
                'enter_time' => $fingerprint->login != null ?
                    HelperControler::ampm2arabic($fingerprint->login) :
                    'لم تسجل بصمة الدخول',
                'exit_time' => $fingerprint->exit != null ?
                    HelperControler::ampm2arabic($fingerprint->exit) :
                    'لم يتم الخروج بعد',
                'device_number' => $fingerprint->device_number
            ]);

        return inertia()->render('Dashboard/Migration/Index', [
            'fingerprints' => $fingerprints,
        ]);
    }

    public function getEmp()
    {
        $time = Carbon::now();
        $emps = collect();
        Shift::whereTime('secondary_exit', '>=', $time)
            ->whereTime('primary_exit', '<=', $time)
            ->each(function ($shift) use ($emps) {
                $group = GroupOfSets::withTrashed()->find($shift->group_of_sets_id);
                $group->employees()->with('user')->doesntHave('fingerprints')->each(function ($emp) use ($emps) {
                    if (!$emps->where(fn ($q) => $q['id'] == $emp->id)->count()) {
                        $emps->add([
                            'id' => $emp->id,
                            'name' => $emp->user->name
                        ]);
                    }
                });
            });

        return $emps->toJson();
    }

    public function storeNewFingerprint(Request $request)
    {
        $request->validate([
            'employee' => 'nullable|exists:employees,id',
            'movement' => 'required|in:' . join(
                ',',
                array_map(
                    fn ($arg) => $arg->value,
                    FingerprintMovement::cases()
                )
            ),
            'login' => 'required',
            'exit' => 'required|after:login',
            'type' => 'required|in:employee,all',
            'shift_id' => 'required|exists:shifts,id',
        ], [], [
            'employee' => 'الموظف',
            'movement' => 'الحركة',
            'login' => 'تاريخ الدخول',
            'exit' => 'تاريخ الخروج',
            'type' => 'النوع',
            'shift_id' => 'الوردية',
        ]);

        $movement = $request->get('movement');
        $login = $request->get('login');
        $exit = $request->get('exit');
        $type = $request->get('type');
        $shift = Shift::with('group')
            ->find($request->get('shift_id'));
        // get employee
        $groupEmps =  GroupEmployees::query()
            //->where('start', '>=', $login)
            //->where('end', '<=', $exit)
            ->whereIn('employee_id', HelperControler::getCurrentEmployee())
            ->where('group_of_sets_id', $shift->group_of_sets_id);

        $user = User::query()->find(Auth::id());
        if ($type == 'all') {
            $employee = Employee::with('fingerprints')
                ->whereIn('id', $groupEmps->pluck('employee_id'))
                ->get();
        } else {
            if ($request->get('employee') == null and $user->hasRole('employee')) {
                $employee = Employee::with('fingerprints')
                    ->whereRelation('user', 'id', Auth::id())
                    ->get();
            } else {
                $employee = Employee::with('fingerprints')
                    ->where('id', $request->get('employee'))
                    ->get();
            }
        }

        if (
            $movement == FingerprintMovement::ENTRY_TAG_ASSIGNMENT->value ||
            $movement == FingerprintMovement::EXIT_TAG_ASSIGNMENT->value
        ) {
            $days = Fingerprint::withTrashed()
                ->whereDate('created_at', '>=', $login)
                ->whereDate('created_at', '<=', $exit)
                ->whereIn('employee_id', $employee->pluck('id'))
                ->get()
                ->map(function ($fingerprint) use ($movement) {
                    $shift = Shift::find($fingerprint->shift_id);
                    $fingerprint->sanctions()->update([
                        'isDone' => true
                    ]);

                    if ($movement == FingerprintMovement::ENTRY_TAG_ASSIGNMENT->value) {
                        $fingerprint->update([
                            'login' => $shift->primary_enter,
                            'movement' => FingerprintMovement::ENTRY_TAG_ASSIGNMENT->value
                        ]);
                        return [
                            'hours' => str($fingerprint->login)->substr(0, 2)->value(),
                            'minutes' => str($fingerprint->login)->substr(3, 2)->value()
                        ];
                    }
                    $fingerprint->update([
                        'exit' => $shift->primary_exit,
                        'movement' => FingerprintMovement::EXIT_TAG_ASSIGNMENT->value
                    ]);
                    return [
                        'hours' => str($fingerprint->exit)->substr(0, 2)->value(),
                        'minutes' => str($fingerprint->exit)->substr(3, 2)->value()
                    ];
                });

            $hours = $days->sum(fn ($day) => intval($day['hours']));
            $minutes = $days->sum(fn ($day) => intval($day['minutes']));

            $vaction = Vacation::query()->firstOrCreate(['name' => 'سنويه'], [
                'balance' => 30,
                'name' => 'سنويه'
            ]);
            if ($hours / 24 >= 1)
                $vaction->employees()->syncWithPivotValues($employee->pluck('id'), [
                    'last_balance' => $hours / 24,
                    'start' => $login,
                    'end' => $exit,
                    'shift_id' => $request->get('shift_id'),
                    'approved' => !$user->hasRole('employee')
                ]);
        } else if (
            $movement == FingerprintMovement::CALCULATION_OF_ENTRY_FINGERPRINT->value ||
            $movement == FingerprintMovement::CALCULATION_OF_EXIT_FINGERPRINT->value
        ) {

            $finger = Fingerprint::withTrashed()
                ->where('created_at', '>=', $login)
                ->where('created_at', '<=', $exit)
                ->where('shift_id', $shift->id)
                ->whereIn('employee_id', $employee->pluck('id'));

            Sanction::withTrashed()
                ->whereIn('fingerprint_id', $finger->pluck('id'))->update([
                    'isDone' => true,
                    'deleted_at' => Carbon::now()
                ]);

            if ($finger->exists()) {
                if ($movement == FingerprintMovement::CALCULATION_OF_ENTRY_FINGERPRINT->value)
                    $finger->update([
                        'login' => $shift->primary_enter,
                        'movement' =>  FingerprintMovement::CALCULATION_OF_ENTRY_FINGERPRINT->value
                    ]);
                else {
                    $finger->update([
                        'exit' => $shift->primary_exit,
                        'movement' =>  FingerprintMovement::CALCULATION_OF_EXIT_FINGERPRINT->value
                    ]);
                }
            };
        } else {
            $employee->each(function ($emp) use ($movement) {
                $salary = $emp->salary()->first();
                $total = 0;
                if ($salary) {
                    $total = intval($salary->primary / Carbon::now()->daysInMonth);
                }
                if ($movement == FingerprintMovement::PUNISHMENT_DAY_DISCOUNT->value) {
                    Sanction::query()->create(
                        [
                            'name' => FingerprintMovement::PUNISHMENT_DAY_DISCOUNT->value,
                            'value' => $total,
                            'employee_id' => $emp->id,
                            'isDone' => false,
                        ]
                    );
                } else  if ($movement == FingerprintMovement::PUNISHMENT_2_DAY_DISCOUNT->value) {
                    Sanction::query()->create(
                        [
                            'name' => FingerprintMovement::PUNISHMENT_2_DAY_DISCOUNT->value,
                            'value' => $total * 2,
                            'employee_id' => $emp->id,
                            'isDone' => false,
                        ]
                    );
                } else {
                    Sanction::query()->create(
                        [
                            'name' => FingerprintMovement::PUNISHMENT_3_DAY_DISCOUNT->value,
                            'value' => $total * 3,
                            'employee_id' => $emp->id,
                            'isDone' => false,
                        ]
                    );
                }
            });
        }

        return back();
    }

    public function getAllEmps()
    {
        return Employee::with([
            'user',
            'units:id,name,department_id',
            'groups:id,name',
            'jobData:id,name,employee_id',
            'serviceData:id,age_of_retirement,employee_id'
        ])->whereIn('id', HelperControler::getCurrentEmployee())
            ->get()
            ->map(function ($emp) {
                $emp->bransh = Bransh::with(['management:id,name,bransh_id', 'management.bransh:id,name'])
                    ->whereIn('id', $emp->units->pluck('department_id'))->first();
                $emp->state = Carbon::now()
                    ->diffInYears(Carbon::parse($emp->birthdate)) <= intval($emp->serviceData()->orderByDesc('updated_at')->first()?->age_of_retirement) ? 'ثابت' : 'متقاعد';
                JobData::where('employee_id', $emp->id)->get(['id', 'name']);
                $emp->doesnetHaveGroup = GroupEmployees::query()
                    ->where('employee_id', $emp->id)
                    ->count() <= 0;
                unset($emp->groups);
                $emp->groups  = $emp->groups()->withTrashed()->get();
                return $emp;
            })->toJson();
    }

    public function show(Employee $employee)
    {
        $data = [
            'الاسم' => $employee->name,
            'التلفون' => $employee->phone,
            'الجمس' => $employee->sex,
            'الحالة الاجتماعية' => $employee->marital_state,
            'ناريخ الميلاد' => $employee->birthdate,
            'رقم الموظف' => '#' . $employee->employee_number,
            'مكان الاقامة' => $employee->place_of_residence
        ];
        if ($employee->user) {
            $user = [
                'الايميل' => $employee->user->email,
                'اسم المستخدم' => $employee->user->user_name,
            ];

            foreach ($user as $key => $value) {
                $data[$key] = $value;
            }
        }
        if ($employee->fingerprints) $data['عدد البصمات'] = $employee->fingerprints()->count() . ' ' . 'بصمة';
        if ($employee->sanctions) $data['عدد الجزاءات'] = $employee->sanctions()->count() . ' ' . 'جزاء';
        if ($employee->groups()->withTrashed()->exists()) $data['المجموعة'] = $employee->groups()->withTrashed()->first()->name;
        if ($employee->salary) {
            $identity = [
                'الراتب الاساسي' => $employee->salary()->first()?->primary . ' ريال',
                'الراتب الشامل' =>  $employee->salary()->first()?->compehnsive . ' ريال',
                'بدء زيادة الراتب' =>    $employee->salary()->first()?->start,
                'نهاية زيادة الراتب' =>      $employee->salary()->first()?->end,
                'اسم البنك' =>   $employee->salary()->first()?->bank_name,
                'رقم الحساب' =>   $employee->salary()->first()?->account_number,
            ];
            foreach ($identity as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}

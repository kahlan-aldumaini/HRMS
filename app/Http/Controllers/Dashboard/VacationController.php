<?php

namespace App\Http\Controllers\Dashboard;

use App\Enum\PeriodState;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\HelperControler;
use App\Models\Employee;
use App\Models\Fingerprint;
use App\Models\GroupEmployees;
use App\Models\GroupOfSets;
use App\Models\Period;
use App\Models\Shift;
use App\Models\User;
use App\Models\Vacation;
use App\Models\VacationEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    public function index()
    {
        [$filter, $hasFilter] = HelperControler::getFiltersFromRequest();
        $taskEmps = VacationEmployee::withTrashed();

        if ($hasFilter) {
            $taskEmps
                ->when($filter['from_date'], fn ($q, $r) => $q->whereDate('start', '>=', $r))
                ->when($filter['to_date'], fn ($q, $r) => $q->whereDate('end', '<=', $r))
                ->when($filter['group'], fn ($q, $r) => $q->whereIn('employee_id', GroupEmployees::where('group_of_sets_id', $r)->pluck('employee_id')));
        }

        return inertia()->render('Dashboard/Vacation/Index', [
            'fingerprints' => $taskEmps
                ->whereIn('employee_id', HelperControler::getCurrentEmployee())
                ->get()
                ->map(function ($vacation) {
                    $emp = Employee::find($vacation->employee_id);
                    $vact = Vacation::find($vacation->vacation_id);
                    return [
                        'id' => $vacation->id,
                        'user_name' => $emp->user->name,
                        'code' => $emp->employee_number,
                        'type' =>  $vact?->name,
                        'state' => $vacation->trashed() ? 'غير مرحلة' : 'مرحلة',
                        'start' => Carbon::parse($vacation?->start)->format('Y-m-d'),
                        'end' => Carbon::parse($vacation?->end)->format('Y-m-d'),
                        'approved'  => $vacation->approved
                    ];
                }),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee' => ($request->type == 'employee' ? 'required' : 'nullable') . '|exists:employees,id',
            'shift_id' => 'required|exists:shifts,id',
            'login' => 'required|date',
            'exit' => 'required|date|after_or_equal:login',
            'type' => 'required|in:group,employee,all',
            'group' => ($request->type == 'group' ? 'required' : 'nullable') . '|exists:group_of_sets,id',
            'vaction' => 'required|exists:vacations,id'
        ], [
            'login.after_or_equal' => 'يجب ان يكون تاريخ النهاية بعد تاريخ اليوم',
        ], [
            'employee_id' => 'الموظف',
            'shift_id' => 'الوردية',
            'login' => 'تاريخ البداية',
            'exit' => 'تاريخ النهاية',
            'type' => 'النوع',
            'group' => 'المجموعة',
            'vaction' => 'الاجازة'
        ]);

        $login = $request->login;
        $exit = $request->exit;
        if (
            !Period::query()
                ->whereDate('start', '<=', $login)
                ->whereDate('end', '>=', $exit)
                ->where('state', PeriodState::OPEN->value)
                ->exists()
        ) {
            return back()->withErrors([
                'message' => 'لقد انتهت الفتره'
            ]);
        }
        $days = Carbon::parse($exit)->diffInDays($login);
        $shift = Shift::query()->find($request->shift_id);

        if ($request->type == 'group') {
            GroupOfSets::find($request->group)?->employees()
                ->each(function ($emp) use ($request, $days, $login, $exit, $shift) {
                    $this->addFingerprintForVacation($login, $exit, $shift, $emp);
                    VacationEmployee::create([
                        'employee_id' => $emp->id,
                        'vacation_id' => $request->vaction,
                        'last_balance' => $days,
                        'start' => $login,
                        'end' => $exit,
                        'shift_id' => $request->shift_id
                    ]);
                });
        } elseif ($request->type == 'employee') {
            $employee = $request->employee;

            Employee::where('id', $employee)
                ->each(function ($emp) use ($request, $days, $login, $exit, $shift) {
                    $this->addFingerprintForVacation($login, $exit, $shift, $emp);
                    VacationEmployee::updateOrCreate([
                        'start' => $login,
                        'end' => $exit
                    ], [
                        'employee_id' => $emp->id,
                        'vacation_id' => $request->vaction,
                        'last_balance' => $days,
                        'start' => $login,
                        'end' => $exit,
                        'shift_id' => $request->shift_id,
                        'approved' => !User::find(Auth::id())->hasRole('employee') ? 1 : 0
                    ]);
                });
        } else {
            $employees = Employee::all()
                ->each(
                    function ($emp) use ($request, $login, $exit, $days, $shift) {
                        $this->addFingerprintForVacation($login, $exit, $shift, $emp);
                        $emp->vacations()
                            ->attach($request->vaction, [
                                'last_balance' => $days,
                                'start' => $login,
                                'end' => $exit,
                                'shift_id' => $request->shift_id
                            ]);
                    }
                );
        }

        return back();
    }

    private function addFingerprintForVacation(string $login, string $exit, $shift, $employee)
    {
        $now = Carbon::now();
        if ($now->greaterThanOrEqualTo(Carbon::parse($login))) {
            while (true) {
                if ($now->lessThanOrEqualTo(Carbon::parse($login))) break;
                Fingerprint::query()->updateOrCreate([
                    'shift_id' => $shift->id,
                    'created_at' => $now,
                    'employee_id' => $employee->id
                ], [
                    'login' => $shift->primary_enter,
                    'exit' => $shift->primary_exit,
                    'device_number' => 0,
                    'shift_id' => $shift->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'movement' => "اجازة",
                    'employee_id' => $employee->id
                ]);
                $now = $now->subDay();
            }
        }
    }

    public function getVacationsForEmps(Employee $employee)
    {
        $vacationEmployees = VacationEmployee::where('employee_id', $employee->id)->get();
        $vacation = Vacation::all()->map(function ($vacation) use ($vacationEmployees) {
            if ($vacationEmployees->contains('vacation_id', $vacation->id))
                $vacation->balance = intval($vacation->balance) - intval($vacationEmployees->where('vacation_id', $vacation->id)->first()->last_balance);

            return [
                'id' => $vacation->id,
                'name' => "$vacation->name - $vacation->balance",
            ];
        });
        return $vacation;
    }

    public function getVacations()
    {
        $tasks = Vacation::all()->map(function ($tasks) {
            return [
                'id' => $tasks->id,
                'name' => "$tasks->name - $tasks->balance",
            ];
        });
        return $tasks;
    }

    public function getShift(Request $request)
    {
        if ($request->type == 'all')
            return Shift::all()->map(function ($shift) {
                $shift->name .= ' ليوم ' . $shift->day;
                return $shift;
            })->toJson();
        else  if ($request->type == 'group') {
            return Shift::query()
                ->where('group_of_sets_id', $request->id)
                ->get()
                ->map(function ($shift) {
                    $shift->name .= ' ليوم ' . $shift->day;
                    return $shift;
                })->toJson();
        } else {
            if (User::find(Auth::id())->hasRole('employee')) {
                return Shift::query()
                    ->whereIn(
                        'group_of_sets_id',
                        GroupEmployees::withTrashed()->where('employee_id', Auth::user()->employee->id)
                            ->pluck('group_of_sets_id')
                    )
                    ->get()
                    ->map(function ($shift) {
                        $shift->name .= ' ليوم ' . $shift->day;
                        return $shift;
                    })->toJson();
            } else
                return Shift::query()
                    ->whereIn('group_of_sets_id', GroupEmployees::where('employee_id', $request->id)->pluck('group_of_sets_id'))
                    ->get()
                    ->map(function ($shift) {
                        $shift->name .= ' ليوم ' . $shift->day;
                        return $shift;
                    })->toJson();
        }
    }

    public function show($vacation)
    {
        $vacation = VacationEmployee::withTrashed()->find($vacation);
        $vacationModel = Vacation::find($vacation->vacation_id);
        $employee = Employee::find($vacation->employee_id);
        $usage = VacationEmployee::withTrashed()
            ->where('employee_id', $vacation->employee_id)
            ->where('vacation_id', $vacation->vacation_id)
            ->sum('last_balance');
        $data = [
            'نوع الاجازه' => $vacationModel->name,
            "اسم الموظف" => $employee->name,
            'تاريخ البداية' => $vacation->start,
            'تاريخ النهاية' => $vacation->end,
            "المستخدمة" => $usage . ' يوم',
            "المتبقية" => (intval($vacationModel->balance) - intval($usage)) . ' يوم',
            "ساعات الاجازه" => Carbon::parse($vacation->start)->diffInHours(Carbon::parse($vacation->end)) . ' ساعة'
        ];

        if ($vacation->shift_id != null) {
            $shift = Shift::with('group')->find($vacation->shift_id);
            $data['المجموعة'] = GroupOfSets::withTrashed()->find($shift->group_of_sets_id)?->name;
            $data['فترة الدوام'] = $shift?->name;
        }

        return response()->json($data);
    }

    public function approved(VacationEmployee $id)
    {
        $id->update([
            'approved' => true
        ]);
        return back();
    }
}

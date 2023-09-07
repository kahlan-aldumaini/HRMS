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
use App\Models\Task;
use App\Models\TaskEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private function addFingerprintForTask(string $login, string $exit, $shift, $employee)
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
                    'movement' => "تكليف",
                    'employee_id' => $employee->id
                ]);
                $now = $now->subDay();
            }
        }
    }
    public function index()
    {
        [$filter, $hasFilter] = HelperControler::getFiltersFromRequest();
        $taskEmps = TaskEmployee::query();

        if ($hasFilter) {
            $taskEmps
                ->when($filter['from_date'], fn ($q, $r) => $q->whereDate('start', '>=', $r))
                ->when($filter['to_date'], fn ($q, $r) => $q->whereDate('end', '<=', $r))
                ->when($filter['group'], fn ($q, $r) => $q->whereIn('employee_id', GroupEmployees::where('group_of_sets_id', $r)->pluck('employee_id')));
        }


        $taskEmps =  $taskEmps->whereIn('employee_id', HelperControler::getCurrentEmployee())
            ->get()->map(function ($task) {
                $emp = Employee::find($task->employee_id);
                $taskModel = Task::find($task->task_id);
                return [
                    'id' => $task->id,
                    'user_name' => $emp->user->name,
                    'code' => $emp->employee_number,
                    'type' => $taskModel?->name,
                    'start' => $task->start ?? '---',
                    'end' => $task->end ?? '---',
                    'state' => $emp?->deleted_at == null ? 'غير مرحلة' : 'مرحلة'
                ];
            });


        return inertia()->render('Dashboard/Tasks/Index', [
            'fingerprints' => $taskEmps,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee' => 'nullable|exists:employees,id',
            'shift_id' => 'required|exists:shifts,id',
            'login' => 'required|date',
            'exit' => 'required|date|after_or_equal:login',
            'type' => 'required|in:group,employee,all',
            'group' => 'nullable|exists:group_of_sets,id',
            'vaction' => 'required|exists:tasks,id'
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

        $task = Task::find($request->vaction);
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


        $days = Carbon::parse($login)->diffInDays(Carbon::parse($exit));
        $shift = Shift::query()->find($request->shift_id);

        if ($request->type == 'group') {
            $shift->group->employees()
                ->each(function ($emp) use ($request, $days, $login, $exit, $shift) {
                    $this->addFingerprintForTask($login, $exit, $shift, $emp);
                    $emp->tasks()
                        ->attach($request->vaction, [
                            'last_balance' => $days,
                            'start' => $login,
                            'end' => $exit,
                            'shift_id' => $request->shift_id
                        ]);
                });
        } elseif ($request->type == 'employee') {
            Employee::where('id', $request->employee)
                ->each(function ($emp) use ($request, $days, $login, $exit, $shift) {
                    $this->addFingerprintForTask($login, $exit, $shift, $emp);
                    $emp->tasks()
                        ->attach($request->vaction, [
                            'last_balance' => $days,
                            'start' => $login,
                            'end' => $exit,
                            'shift_id' => $request->shift_id
                        ]);
                });
        } else {
            Employee::all()->each(function ($emp) use ($request, $days, $login, $exit, $shift) {
                $this->addFingerprintForTask($login, $exit, $shift, $emp);
                $emp->tasks()
                    ->attach($request->vaction, [
                        'last_balance' => $days,
                        'start' => $login,
                        'end' => $exit,
                        'shift_id' => $request->shift_id
                    ]);
            });;
        }

        return back();
    }

    public function getTasksForEmps(Employee $employee)
    {
        $taskEmployees = TaskEmployee::where('employee_id', $employee->id)->get();
        $task = Task::all()->map(function ($task) use ($taskEmployees) {
            if ($taskEmployees->contains('task_id', $task->id))
                $task->balance = intval($task->balance) - intval($taskEmployees->where('task_id', $task->id)->first()->last_balance);

            return [
                'id' => $task->id,
                'name' => "$task->name - $task->balance",
            ];
        });
        return $task;
    }

    public function getTasks()
    {
        return Task::all()->map(function ($tasks) {
            return [
                'id' => $tasks->id,
                'name' => "$tasks->name - $tasks->balance",
            ];
        });
    }

    public function show($task)
    {
        $task = TaskEmployee::withTrashed()->find($task);
        $taskModel = Task::find($task->task_id);
        $employee = Employee::find($task->employee_id);
        $usage = TaskEmployee::withTrashed()->where('employee_id', $task->employee_id)
            ->where('task_id', $task->task_id)->sum('last_balance');
        $data = [
            'نوع التكاليف' => $taskModel->name,
            "اسم الموظف" => $employee->name,
            'تاريخ البداية' => $task->start,
            'تاريخ النهاية' => $task->end,
            " المستخدمة" => $usage . ' يوم',
            " المتبقية" => (intval($taskModel->balance) - intval($usage)) . ' يوم',
            "ساعات التكاليف" => Carbon::parse($task->start)->diffInHours(Carbon::parse($task->end)) . ' ساعة'
        ];

        if ($task->shift_id != null) {
            $shift = Shift::with('group')->find($task->shift_id);
            $data['المجموعة'] = GroupOfSets::withTrashed()->find($shift->group_of_sets_id)?->name;
            $data['فترة الدوام'] = $shift?->name;
        }
        return response()->json($data);
    }
}

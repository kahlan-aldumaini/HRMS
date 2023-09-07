<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\HelperControler;
use App\Models\Bransh;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeUnit;
use App\Models\GroupEmployees;
use App\Models\GroupOfSets;
use App\Models\Management;
use App\Models\Shift;
use App\Models\Unit;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        [$filter, $hasFilter] = HelperControler::getFiltersFromRequest();
        $currentShifts = Shift::with(['group', 'group.employees']);
        if ($hasFilter) {
            if (isset($filter['day']))
                $currentShifts->when(
                    $filter['day'],
                    fn ($query, $rule) => $query->where('day', '=', $rule)
                );
            // else $currentShifts->where('day', Carbon::now()->dayName);
        }
        // else $currentShifts->where('day', Carbon::now()->dayName);

        $currentShifts = $currentShifts->get()
            ->map(function ($shift) use ($filter, $hasFilter) {
                $group =  GroupOfSets::withTrashed();
                if ($hasFilter) {
                    $group->when($filter['group'], fn ($query, $rule) => $query->where('id', '=', $rule));
                }
                return $group
                    ?->find($shift->group_of_sets_id)
                    ?->employees()
                    ->get()
                    ->map(function ($emp) use ($shift, $filter, $hasFilter) {
                        if (!in_array($emp->id, HelperControler::getCurrentEmployee())) return null;
                        if ($hasFilter and isset($filter['bransh'])) {
                            $management = Management::query()->where('bransh_id', $filter['bransh']);
                            $departments = Department::query()->whereIn('management_id', $management->pluck('id'));
                            $unit = Unit::query()->whereIn('department_id', $departments->pluck('id'));
                            $emps = EmployeeUnit::query()->whereIn('unit_id', $unit->pluck('id'));
                            if (!in_array($emp->id, $emps->pluck('employee_id')->toArray())) return null;
                        }
                        $fingerprints = $shift->fingerprints();

                        if (isset($filter['from_date']))
                            $fingerprints->when($filter['from_date'], fn ($q, $r) => $q->where('created_at', '>=', $r));
                        if (isset($filter['to_date']))
                            $fingerprints->when($filter['to_date'], fn ($q, $r) => $q->where('created_at', '<=', $r));

                        $data = [];
                        if ($fingerprints->exists()) {
                            foreach ($fingerprints->orderBy('created_at')->get() as $fingerprint) {
                                $state = '';
                                $late = '0 دقيقة';
                                if (!$fingerprint) {
                                    $state = 'غائب';
                                } else if (
                                    $emp->fingerprints()
                                    ->where('login', '>=', $shift->secondary_enter)
                                    ->whereDate('created_at', Carbon::today())
                                    ->exists()
                                ) {
                                    $diffInMinut = Carbon::parse($fingerprint->login)->diffInMinutes(Carbon::parse($shift->secondary_enter));
                                    $hours = floor($diffInMinut / 60);
                                    $minutes = $diffInMinut % 60;
                                    $late = $hours . ' ساعة<br/> ' . $minutes . 'دقيقة';
                                    $state = 'متأخر';
                                } else {
                                    $state = 'حاضر';
                                }
                                $data[] = [
                                    'emp_number' => $emp->employee_number,

                                    'emp_name' => $emp->name,

                                    'emp_groups' => GroupOfSets::withTrashed()
                                        ->find($shift->group_of_sets_id)?->name ?? '---',

                                    'emp_current_shift_name' => $shift->name,

                                    'emp_current_shift_day' => $shift->day,

                                    'emp_current_shift_date' => $fingerprint?->created_at ? Carbon::parse($fingerprint?->created_at)->format('Y-m-d') : 'غير مسخل',

                                    'emp_current_shift_login' => $fingerprint?->login ? HelperControler::ampm2arabic($fingerprint?->login) : 'غير مسخل',

                                    'emp_current_shift_exit' => $fingerprint?->exit ? HelperControler::ampm2arabic($fingerprint?->exit) : 'غير مسخل',

                                    'emp_current_shift_state' => $state,

                                    'emp_current_shift_late' => $late,

                                    'emp_last_move' =>  $fingerprint?->movement ?? '---'

                                ];
                            }
                            return collect($data);
                        } else {
                            $fingerprint = null;
                            $state = '';
                            $late = '0 دقيقة';
                            if (!$fingerprint) {
                                $state = 'غائب';
                            } else if (
                                $emp->fingerprints()
                                ->whereTime('login', '<=', $shift->secondary_enter)->whereTime('exit', '>=', $shift->secondary_exit)
                                // ->whereDate('created_at', Carbon::today())
                                ->count() > 0
                            ) {
                                $diffInMinut = Carbon::parse($fingerprint->login)->diffInMinutes(Carbon::parse($shift->secondary_enter));
                                $hours = floor($diffInMinut / 60);
                                $minutes = $diffInMinut % 60;
                                $late = $hours . ' ساعة<br/> ' . $minutes . ' دقيقة';
                                $state = 'متأخر';
                            } else {
                                $state = 'حاضر';
                            }
                            return [
                                'emp_number' => $emp->employee_number,

                                'emp_name' => $emp->name,

                                'emp_groups' => GroupOfSets::withTrashed()
                                    ->find($shift->group_of_sets_id)?->name ?? '---',

                                'emp_current_shift_name' => $shift->name,

                                'emp_current_shift_day' => $shift->day,

                                'emp_current_shift_date' => $fingerprint?->created_at ? Carbon::parse($fingerprint?->created_at)->format('Y-m-d') : 'غير مسجل',

                                'emp_current_shift_login' => $fingerprint?->login ? HelperControler::ampm2arabic($fingerprint?->login) : 'غير مسجل',

                                'emp_current_shift_exit' => $fingerprint?->exit ? HelperControler::ampm2arabic($fingerprint?->exit) : 'غير مسجل',

                                'emp_current_shift_state' => $state,

                                'emp_current_shift_late' => $late,

                                'emp_last_move' =>  $fingerprint?->movement ?? '---'

                            ];
                        }
                    });
            })->collapse()->whereNotNull();
        $data = [];
        $currentShifts->each(function ($v, $k) use (&$data) {
            if (!is_string($k)) {
                foreach ($v as $item)
                    $data[] = $item;
            } else {
                $data[] = $v->toArray();
            }
        });
        $props = [
            'reports' => $data
        ];
        if ($hasFilter) {
            $props = [
                'reports' => $data,
                'filter' => $filter
            ];
        }
        return inertia()->render(
            'Dashboard/Report/Index',
            $props
        );
    }
}

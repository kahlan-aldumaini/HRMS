<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\HelperControler;
use App\Models\Bransh;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeUnit;
use App\Models\Fingerprint;
use App\Models\GroupOfSets;
use App\Models\Sanction;
use App\Models\Shift;
use App\Models\TaskEmployee;
use App\Models\Unit;
use App\Models\User;
use App\Models\VacationEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $employees = HelperControler::getCurrentEmployee();
        $props = [
            'emp_count' => Employee::query()->whereIn('id', $employees)->count(),
            'user_count' => User::query()->whereDoesntHave('employee')->count(),
            'group_count' => GroupOfSets::withTrashed()->count(),
            'shift_count' => Shift::count(),
            'end_emp_count' => Employee::query()->whereIn('id', $employees)
                ->whereRelation('serviceData', 'service_expirateion_date', '<', Carbon::now()->format('Y-m-d'))
                ->count(),
            'vactions' => $this->getVections(),
            'sanction' => $this->getSanctions(),
            'bransh' => $this->getBransh(),
        ];

        return inertia()->render('Dashboard/Home/Index', $props);
    }

    private function getVections()
    {
        $months = [
            "يناير",
            "فبراير",
            "مارس",
            "أبريل",
            "مايو",
            "يونيو",
            "يوليو",
            "أغسطس",
            "سبتمبر",
            "أكتوبر",
            "نوفمبر",
            "ديسمبر"
        ];
        $year = Carbon::now()->year;
        $employees = HelperControler::getCurrentEmployee();
        $vections = [];
        $task = [];
        for ($i = 1; $i <= 12; $i++) {
            $vections[] = VacationEmployee::query()
                ->whereMonth('created_at', $i)
                ->whereIn('employee_id', $employees)
                ->whereYear('created_at', $year)
                ->count();
            $task[] = TaskEmployee::query()
                ->whereMonth('created_at',  $i)
                ->whereIn('employee_id', $employees)
                ->whereYear('created_at', $year)
                ->count();
        }

        $options = [
            'char' => [
                'id' => 'الاجازات'
            ],
            "xaxis" => [
                'categories' => $months
            ],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
        $series = [
            [
                "name" => 'الاجازات',
                'data' => $vections
            ],
            [
                "name" => 'التكاليف',
                'data' => $task
            ],
        ];

        return ['options' => $options, 'series' => $series];
    }

    private function getSanctions()
    {
        $days = [];
        $sanctions = [];
        $employees = HelperControler::getCurrentEmployee();
        $fingerprints = Fingerprint::whereIn('employee_id', $employees)->pluck('id');
        $sanctionNames = Sanction::query()->groupBy('name')->pluck('name')->toArray();
        for ($i = 1; $i <= Carbon::now()->endOfMonth()->day; $i++) {
            $days[] = $i;
            foreach ($sanctionNames as $sanction)
                $sanctions[$sanction][] = Sanction::query()
                    ->where('name', $sanction)
                    ->whereIn('fingerprint_id', $fingerprints)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereDay('created_at', $i)
                    ->count();
        }


        $options = [
            'char' => [
                'id' => 'الاجازات'
            ],
            "xaxis" => [
                'categories' => $days
            ],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
        $series = [];
        foreach ($sanctions as $key => $value) {
            $series[] = [
                'name' => $key,
                'data' => $value
            ];
        }

        return ['options' => $options, 'series' => $series];
    }

    private function getBransh()
    {
        $branshEmps = [];
        $branshes = Bransh::all();
        foreach ($branshes as $bransh) {
            $managements = $bransh->management;
            $manages = [];
            foreach ($managements as $key => $value) {
                $departments = Department::where('management_id', $value->id);
                $units = Unit::whereIn('department_id', $departments->pluck('id'));
                $manages[] = EmployeeUnit::whereIn('unit_id', $units->pluck('id'))->count();
            }
            if ($manages == []) continue;
            $branshEmps[] = [
                'name' => $value->name,
                'data' => $manages
            ];
        }


        $options = [
            'char' => [
                'id' => 'الاجازات'
            ],
            "xaxis" => [
                'categories' => $branshes->pluck('name')->toArray()
            ],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];

        $series[] = [
            // 'name' => $key,
            'data' => $branshEmps
        ];

        // dd($branshEmps);
        return ['options' => $options, 'series' => $branshEmps];
    }
}

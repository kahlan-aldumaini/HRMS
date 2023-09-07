<?php

namespace App\Http\Controllers\Utilities;

use App\Http\Controllers\Controller;
use App\Models\Bransh;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeUnit;
use App\Models\Management;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Type\IsString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HelperControler extends Controller
{
    public function getBranshes()
    {
        return Bransh::all()->toJson();
    }

    public function getManagements($bransh)
    {
        if ($bransh == 0) {
            return Management::all()->toJson();
        }
        return Bransh::find($bransh)->management()->get()->toJson();
    }

    public function getDepartments($management)
    {
        if ($management == 0) {
            return Department::all()->toJson();
        }
        return Management::find($management)?->departments()->get()->toJson();
    }

    public function getUnits($department)
    {
        if ($department == 0) {
            return Unit::all()->toJson();
        }
        return Department::find($department)->units()->get()->toJson();
    }

    public function storeManagement(Request $request, $id = null)
    {
        if (gettype($request->bransh) == 'string') {
            $request->validate([
                'bransh' => 'required|unique:branshes,name'
            ]);

            Bransh::query()->updateOrCreate(['id' => $id], [
                'name' => $request->get('bransh')
            ]);
        } else if (gettype($request->management) == 'string') {
            $request->validate([
                'bransh' => 'required|exists:branshes,id',
                'management' => 'required'
            ]);

            Management::query()->updateOrCreate(['id' => $id], [
                'name' => $request->get('management'),
                'bransh_id' => $request->bransh
            ]);
        } else  if (gettype($request->department) == 'string') {
            $request->validate([
                'bransh' => 'required|exists:branshes,id',
                'management' => 'required|exists:management,id',
                'department' => 'required'
            ]);

            Department::query()->updateOrCreate(['id' => $id], [
                'name' => $request->get('department'),
                'management_id' => $request->get('management')
            ]);
        } else  if (gettype($request->unit) == 'string') {
            $request->validate([
                'bransh' => 'required|exists:branshes,id',
                'management' => 'required|exists:management,id',
                'department' => 'required|exists:departments,id',
                'unit' => 'required'
            ]);

            Unit::query()->updateOrCreate(['id' => $id], [
                'name' => $request->get('unit'),
                'department_id' => $request->get('department')
            ]);
        }
        return back();
    }

    public static function dateFormatStore(string $date): string
    {
        return Carbon::parse($date)->format('m/d/Y');
    }

    public function destroyManagement($id, $type)
    {
        if ($type == 1) {
            $bransh = Bransh::find($id);
            $bransh->management()->each(function ($management) {
                $management?->departments()->each(function ($department) {
                    $department->units()->delete();
                });
                $management->departments()->delete();
            });
            $bransh->management()->delete();
            $bransh->delete();
        } else if ($type == 2) {
            $management = Management::find($id);
            $management->departments()->each(function ($department) {
                $department->units()->delete();
            });
            $management->departments()->delete();
            $management->delete();
        } else if ($type == 3) {
            $department = Department::find($id);
            $department->units()->delete();
            $department->delete();
        } else {
            $unit = Unit::find($id);
            $unit->delete();
        }

        return back();
    }

    public static function dayFromEN2AR(string $day): string
    {
        if (in_array(str($day)->lower(), ['sat', 'san', 'mon',  'tue', 'wed', 'thu', 'fri']))
            return match (str($day)->lower()) {
                'sat' => 'السبت',
                'san' => 'الأحد',
                'mon' => 'الاثنين',
                'tue' => 'الثلاثاء',
                'wed' => 'الأربعاء',
                'thu' => 'الخميس',
                'fri' => 'الجمعة',
            };
        return $day;
    }

    public static function ampm2arabic($date)
    {
        $time = Carbon::parse($date);
        $minute =  $time->minute;
        if ($minute < 10) {
            $minute = '0' . $minute;
        }
        if ($time->hour > 12) {
            $hour =  $time->hour % 12;
            if ($hour < 10) {
                $hour = '0' . $hour;
            }
            return $hour . ':' . $minute . ' ' . 'م';
        } else {
            $hour =  $time->hour;
            if ($hour < 10) {
                $hour = '0' . $hour;
            }
            return $hour . ':' . $minute . ' ' . 'ص';
        }
    }
    public function setBranshSession(int $id)
    {
        request()->session()->put('bransh', strval($id));
        return back();
    }

    public static function getCurrentBransh(): string
    {
        return session()->get('bransh') ?? '1';
    }

    public static function getCurrentUnits()
    {
        $units = [];
        $bransh = Bransh::find(self::getCurrentBransh());
        $bransh?->management()->each(function ($management) use (&$units) {
            $management?->departments()->each(function ($department) use (&$units) {
                $department?->units()->each(function ($unit) use (&$units) {
                    array_push($units, $unit->id);
                });
            });
        });

        if (count($units) > 0)
            return $units;
        else return Unit::all('id')->toArray();
    }

    public static function getCurrentEmployee()
    {
        $user = null;
        if (Auth::check()) {
            $user = User::with('employee')->find(Auth::id());
            if ($user->hasRole('employee')) {
                return [$user?->employee?->id];
            } else if ($user->hasRole('manager')) {
                return EmployeeUnit::query()
                    ->whereIn('unit_id', EmployeeUnit::query()
                        ->where('employee_id', $user->employee->id)
                        ->pluck('unit_id'))
                    ->pluck('employee_id')->toArray();
            }
        }
        return  EmployeeUnit::whereIn('unit_id', self::getCurrentUnits())->pluck('employee_id')->toArray();
    }

    public static function getFiltersFromRequest()
    {
        $filter = [];
        $hasFilter = request()->has('type') and request('type') == 'filter';
        if ($hasFilter) {
            $filter = request()->validate([
                'day' => 'nullable|string',
                'group' => 'nullable|exists:group_of_sets,id',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date|after:from_date',
                'bransh' => 'nullable|exists:branshes,id'
            ]);
        }

        return [$filter, $hasFilter];
    }
}

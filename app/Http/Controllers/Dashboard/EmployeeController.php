<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewEmployee;
use App\Models\CareerCategory;
use App\Models\CareerDegree;
use App\Models\Department;
use App\Models\Employee;
use App\Models\GroupEmployees;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        return inertia()->render('Dashboard/Employee/Index');
    }

    public function store(NewEmployee $request)
    {
        if (!$request->boolean('done')) {
            return back();
        }

        try {
            DB::beginTransaction();
            $data = $request->validated();

            $password = Hash::make($data['employee_number']);
            $user = User::query()->updateOrCreate(['id' => User::query()->whereRelation('employee', 'id', $data['id'])->first()?->id], [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
                'user_name' => $data['employee_number'],
                'tmp_password' => User::query()
                    ->whereRelation('employee', 'id', $data['id'])
                    ->exists() ? null : $password,
            ]);

            $user->roles()->sync(Role::where('display_name', $data['career_name'])->pluck('id'));


            $employee = $user->employee()->updateOrCreate(['id' => $data['id']], [
                'name' => $data['name'],
                'phone' => $data['phone_number'],
                'sex' => $data['sex'],
                'marital_state' => $data['marital_status'],
                'birthdate' => $data['birth_date'],
                'employee_number' => $data['employee_number'],
                'place_of_residence' => $data['place_of_residence'],
            ]);

            $employee->identities()->updateOrCreate(['employee_id' => $employee?->id], [
                'export_date' => $data['identity_export_date'],
                'export_place' => $data['identity_place'],
                'type' => $data['type_of_identity'],
                'number' => $data['identity_number'],
                'nationality' => $data['nationality'],
            ]);

            $employee->groups()->syncWithPivotValues(
                [$data['group']],
                [
                    'start' => $data['group_from'],
                    'end' => $data['group_to'],
                ]
            );

            $employee->serviceData()->updateOrCreate(['employee_id' => $employee?->id], [
                'hiring' => $data['date_of_hiring'],
                'in_work_years' => $data['in_work_date'],
                'out_work_years' => $data['out_work_date'],
                'age_of_retirement' => $data['retirement_age'],
                'service_expirateion_date' => $data['service_expirateion_date']
            ]);

            $employee->jobData()->updateOrCreate(['employee_id' => $employee?->id], [
                'name' => $data['career_name'],
                'degree' => $data['career_degree'],
                'type' => $data['career_type'],
                'bransh' => $data['career_category']
            ]);

            $employee->qualifications()->updateOrCreate(['employee_id' => $employee?->id], [
                'qualification' => $data['qualification'],
                'type' => $data['qualification_type'],
                'end' => $data['qualification_to_date'],
                'start' => $data['qualification_from_date']
            ]);

            $employee->workPermit()->updateOrCreate(['employee_id' => $employee?->id], [
                'name' => $data['work_permit'],
                'start' => $data['permit_from'],
                'end' => $data['permit_to'],
            ]);

            $employee->salary()->updateOrCreate(['employee_id' => $employee?->id], [
                'primary' => $data['salary_primary'],
                'compehnsive' => $data['salary_all'],
                'start' => $data['salary_start'],
                'end' => $data['salary_end'],
                'account_number' => $data['salary_account_number'],
                'bank_name' => $data['salary_bank_name'],
            ]);

            $employee->units()->sync([$data['unit']]);
            DB::commit();
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withErrors($e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        $unit = $employee->units()->orderByPivot('created_at', 'desc')->first();
        $unit = Unit::with([
            'bransh',
            'bransh.management',
            'bransh.management.bransh',
        ])->findOrFail($unit->id);
        return response()->json([
            'id' => $employee->id,
            'name' => $employee->name,
            'nationality' => $employee->identities()->first()?->nationality,
            'unit' => $unit?->id,
            'bransh' => Department::find($unit->department_id)->name,
            'managment' => Department::find($unit->department_id)->management->name,
            'department' => Department::find($unit->department_id)->management->bransh->name,
            'phone_number' => $employee->phone,
            'sex' => $employee->sex,
            'birth_date' => $employee->birthdate,
            'marital_status' => $employee->marital_state,
            'employee_number' => $employee->employee_number,
            'email' => $employee->user->email,
            'place_of_residence' => $employee->place_of_residence,
            'type_of_identity' => $employee->identities()->first()?->type,
            'identity_number' => $employee->identities()->first()?->number,
            'identity_export_date' => $employee->identities()->first()?->export_date,
            'identity_place' => $employee->identities()->first()?->export_place,
            'qualification' => $employee->qualifications()->first()?->qualification,
            'qualification_type' => $employee->qualifications()->first()?->type,
            'qualification_from_date' =>  $employee->qualifications()->first()?->start,
            'qualification_to_date' =>  $employee->qualifications()->first()?->end,
            'group' => $employee->groups()->withTrashed()->first()?->id,
            'group_from' => $employee->groups()->withTrashed()->first()?->pivot->start,
            'group_to' => $employee->groups()->withTrashed()->first()?->pivot->end,
            'career_name' => $employee->jobData()->first()?->name,
            'career_degree' => $employee->jobData()->first()?->degree,
            'career_type' => $employee->jobData()->first()?->type,
            'career_category' => $employee->jobData()->first()?->bransh,
            'date_of_hiring' => $employee->serviceData()->first()?->hiring,
            'work_permit' => $employee->workPermit()->first()?->name,
            'permit_from' => $employee->workPermit()->first()?->start,
            'permit_to' => $employee->workPermit()->first()?->end,
            'retirement_age' => $employee->serviceData()->first()?->age_of_retirement,
            'service_expirateion_date' => $employee->serviceData()->first()?->service_expirateion_date,
            'in_work_date' => $employee->serviceData()->first()?->in_work_years,
            'out_work_date' => $employee->serviceData()->first()?->out_work_years,

            'salary_all' => $employee->salary()->orderByDesc('created_at')->first()?->compehnsive,
            'salary_primary' => $employee->salary()->orderByDesc('created_at')->first()?->primary,
            'salary_bank_name' => $employee->salary()->orderByDesc('created_at')->first()?->bank_name,
            'salary_start' => $employee->salary()->orderByDesc('created_at')->first()?->start,
            'salary_end' => $employee->salary()->orderByDesc('created_at')->first()?->end,
            'salary_account_number' => $employee->salary()->orderByDesc('created_at')->first()?->account_number,

            'done' => false,
        ]);
    }

    public function destroy(Employee $employee)
    {
        $employee->jobData()->delete();
        $employee->units()->detach();
        $employee->groups()->withTrashed()->detach();
        $employee->identities()->delete();
        $employee->serviceData()->delete();
        $employee->vacations()->detach();
        $employee->delete();
        return back();
    }

    public function getCareerNames()
    {
        return Role::all(['id', 'display_name as name']);
    }

    public function getCareerDegree()
    {
        return CareerDegree::all(['id', 'name']);
    }

    public function getCareerCategory()
    {
        return CareerCategory::all(['id', 'name']);
    }

    public function addToGroup(Request $request, Employee $employee)
    {
        $request->validate([
            'group_of_sets_id' => 'required|exists:group_of_sets,id',
            'start' => 'required|date|after_or_equal:today',
            'end' => 'required|date|after_or_equal:start'
        ], [], [
            'group_of_sets_id' => 'المجموعة',
            'start' => 'تاريخ البداية',
            'end' => 'تاريخ النهاية',
        ]);
        GroupEmployees::where('employee_id', $employee->id)->delete();
        $employee->groups()
            ->attach(
                $request->group_of_sets_id,
                $request->only(['start', 'end'])
            );

        return back();
    }
}

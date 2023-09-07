<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NewEmployee extends FormRequest
{
    protected $stopOnFirstFailure = false;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'id' => 'nullable|exists:employees,id',
            "name" => 'required|string|max:255',
            "nationality" => 'required|string|max:255',
            "unit" => 'required|exists:units,id',
            "bransh" => 'required',
            "managment" => 'required',
            "department" => 'required',
            "phone_number" => 'required',
            "sex" => 'required|in:ذكر,انثى',
            "birth_date" => 'required|before:' . Carbon::now()->subYears(18)->format('m/d/Y'),
            "marital_status" => 'required',
            "employee_number" => 'required|numeric',
            "email" => 'required|email',
            "place_of_residence" => 'required',
            "type_of_identity" => 'required',
            "identity_number" => 'required',
            "identity_export_date" => 'required',
            "identity_place" => 'required',
            "qualification" => 'required',
            "qualification_type" => 'required',
            "qualification_from_date" => 'required',
            "qualification_to_date" => 'required',
            "group" => 'required',
            "group_from" => 'required',
            "group_to" => 'required',
            "career_name" => 'required',
            "career_degree" => 'required',
            "career_type" => 'required',
            "career_category" => 'required',
            "date_of_hiring" => 'required',
            "work_permit" => 'required',
            "permit_from" => 'required',
            "permit_to" => 'required',
            "retirement_age" => 'required',
            "service_expirateion_date" => 'required',
            "in_work_date" => 'required',
            "out_work_date" => 'required',

            'salary_all' => 'required',
            'salary_primary' => 'required',
            'salary_bank_name' => 'required',
            'salary_account_number' => 'required',
            'salary_start' => 'required',
            'salary_end' => 'required',

            'done' => 'required|boolean'
        ];
    }
}

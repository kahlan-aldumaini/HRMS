<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['primary', 'compehnsive', 'start', 'end', 'account_number', 'bank_name', 'employee_id'];

    public function salaryDetails()
    {
        return $this->hasMany(SalaryDetails::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

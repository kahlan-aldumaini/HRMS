<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'salary_id'];

    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }
}

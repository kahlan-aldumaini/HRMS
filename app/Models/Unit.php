<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'department_id'];

    public function bransh()
    {
        return $this->belongsTo(Department::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_units');
    }
}

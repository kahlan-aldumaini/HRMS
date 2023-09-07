<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['balance', 'name'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'task_employees')
            ->withPivot(['last_balance', 'start', 'end', 'shift_id'])
            ->withTimestamps();
    }
}

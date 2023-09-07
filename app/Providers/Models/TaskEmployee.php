<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskEmployee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'start',
        'end',
        'shift_id',
        'employee_id',
        'task_id',
        'last_balance',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}

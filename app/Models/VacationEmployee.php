<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationEmployee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'vacation_id',
        'last_balance',
        'start',
        'end',
        'shift_id',
        'approved',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}

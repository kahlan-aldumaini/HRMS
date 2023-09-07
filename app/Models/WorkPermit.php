<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPermit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'start', 'end'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

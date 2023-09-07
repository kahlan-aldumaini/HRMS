<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sanction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'value', 'isDone', 'employee_id', 'fingerprint_id'];

    public function fingerprint()
    {
        return $this->belongsTo(Fingerprint::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fingerprint extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['definition', 'login', 'exit', 'device_number', 'shift_id', 'deleted_at', 'movement', 'created_at', 'updated_at', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function movements()
    {
        return $this->belongsToMany(FingerprintMovement::class, 'fingerprint_movement_relations')
            ->withTimestamps();
    }

    public function sanctions()
    {
        return $this->hasMany(Sanction::class);
    }
}

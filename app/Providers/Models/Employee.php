<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'phone',
        'sex',
        'name',
        'marital_state',
        'birthdate',
        'employee_number',
        'name',
        'place_of_residence'
    ];

    // protected $casts = [
    //     'sex' => Sex::class,
    //     'marital_state' => MaritalState::class
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fingerprints()
    {
        return $this->hasMany(Fingerprint::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class);
    }

    public function identities()
    {
        return $this->hasOne(Identity::class);
    }

    public function groups()
    {
        return $this->belongsToMany(GroupOfSets::class, 'group_employees')
            ->withPivot(['start', 'end'])
            ->withTimestamps();
    }

    public function sanctions()
    {
        return $this->hasMany(Sanction::class);
    }

    public function salary()
    {
        return $this->hasMany(Salary::class);
    }

    public function serviceData()
    {
        return $this->hasMany(ServiceData::class);
    }

    public function jobData()
    {
        return $this->hasMany(JobData::class);
    }

    public function qualifications()
    {
        return $this->hasOne(Qualification::class);
    }

    public function administratieStructures()
    {
        return $this->belongsToMany(AdministratieStructure::class, 'administratie_structures_employees');
    }

    public function workPermit()
    {
        return $this->hasMany(WorkPermit::class);
    }

    public function vacations()
    {
        return $this->belongsToMany(Vacation::class, 'vacation_employees')
            ->withPivot(['last_balance', 'start', 'end', 'shift_id', 'approved'])
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_employees')
            ->withPivot(['last_balance', 'start', 'end', 'shift_id'])
            ->withTimestamps();
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'employee_units')->withTimestamps();
    }
}

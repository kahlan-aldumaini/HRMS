<?php

namespace App\Models;

use App\Enum\Days\Days;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'primary_enter',
        'primary_exit',
        'secondary_enter',
        'secondary_exit',
        'day',
        'group_of_sets_id'
    ];

    // protected $casts = [
    //     'day' => Days::class
    // ];

    public function group()
    {
        return $this->belongsTo(GroupOfSets::class);
    }

    public function fingerprints()
    {
        return $this->hasMany(Fingerprint::class);
    }

    public function vacationEmployees()
    {
        return $this->hasMany(VacationEmployee::class);
    }

    public function taskEmployees()
    {
        return $this->hasMany(TaskEmployee::class);
    }
}

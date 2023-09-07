<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GroupOfSets extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name'];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'group_employees')
            ->withPivot(['start', 'end'])
            ->withTimestamps();
    }
}

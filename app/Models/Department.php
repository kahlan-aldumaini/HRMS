<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['name', 'management_id'];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }
}

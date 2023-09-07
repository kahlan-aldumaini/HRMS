<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Management extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'bransh_id'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function bransh()
    {
        return $this->belongsTo(Bransh::class);
    }
}

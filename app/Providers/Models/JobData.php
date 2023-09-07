<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'degree', 'type', 'bransh', 'deleted_at'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

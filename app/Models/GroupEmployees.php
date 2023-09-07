<?php

namespace App\Models;

use App\Http\Controllers\Utilities\HelperControler;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupEmployees extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['start', 'end', 'group_of_sets_id', 'employee_id'];

    protected function start(): Attribute
    {
        return Attribute::make(
            get: fn ($v) => HelperControler::dateFormatStore($v)
        );
    }
}

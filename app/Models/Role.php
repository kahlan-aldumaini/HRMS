<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];

    public function child()
    {
        return $this->belongsTo(self::class);
    }

    public function parent()
    {
        return $this->hasMany(self::class);
    }
}

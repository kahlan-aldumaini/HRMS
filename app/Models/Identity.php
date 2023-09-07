<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    protected $fillable = [
        'export_date',
        'export_place',
        'type',
        'number',
        'nationality'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

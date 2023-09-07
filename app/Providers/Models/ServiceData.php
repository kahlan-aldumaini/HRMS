<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceData extends Model
{
    use HasFactory;
    protected $fillable = ['hiring', 'in_work_years', 'out_work_years', 'age_of_retirement', 'service_expirateion_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

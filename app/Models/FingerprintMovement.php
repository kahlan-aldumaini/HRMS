<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintMovement extends Model
{
    use HasFactory;

    protected $fillable = ['movement'];

    public function fingerprints()
    {
        return $this->belongsToMany(Fingerprint::class, 'fingerprint_movement_relations')
            ->withTimestamps();
    }

    public function sanctions()
    {
        return $this->hasOne(Sanction::class);
    }
}

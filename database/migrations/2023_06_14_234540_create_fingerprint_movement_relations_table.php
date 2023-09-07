<?php

use App\Models\Fingerprint;
use App\Models\FingerprintMovement;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fingerprint_movement_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fingerprint::class)->constrained();
            $table->foreignIdFor(FingerprintMovement::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fingerprint_movement_relations');
    }
};

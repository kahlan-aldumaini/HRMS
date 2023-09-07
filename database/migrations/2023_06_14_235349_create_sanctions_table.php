<?php

use App\Models\Employee;
use App\Models\Fingerprint;
use App\Models\FingerprintMovement;
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
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->boolean('isDone');
            $table->softDeletes();
            $table->foreignIdFor(Fingerprint::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Employee::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanctions');
    }
};

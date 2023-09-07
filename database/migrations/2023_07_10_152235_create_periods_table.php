<?php

use App\Enum\PeriodState;
use Carbon\Carbon;
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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->integer('month')->from(1);
            $table->integer('year')->from(Carbon::now()->year);
            $table->date('start');
            $table->date('end');
            $table->enum('state', array_map(fn ($q) => $q->value, PeriodState::cases()));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};

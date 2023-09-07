<?php

use App\Models\Employee;
use App\Models\Shift;
use App\Models\Vacation;
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
        Schema::create('vacation_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->constrained();
            $table->foreignIdFor(Vacation::class)->constrained();
            $table->foreignIdFor(Shift::class)->nullable()->constrained();
            $table->integer('last_balance');
            $table->date('start');
            $table->date('end');
            $table->boolean('approved')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacation_employees');
    }
};

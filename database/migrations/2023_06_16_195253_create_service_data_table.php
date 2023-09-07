<?php

use App\Models\Employee;
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
        Schema::create('service_data', function (Blueprint $table) {
            $table->id();
            $table->date('hiring');
            $table->integer('in_work_years');
            $table->integer('out_work_years');
            $table->integer('age_of_retirement');
            $table->date('service_expirateion_date');
            $table->foreignIdFor(Employee::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_data');
    }
};

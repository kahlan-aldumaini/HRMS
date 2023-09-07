<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branches;
use App\Models\Bransh;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Fingerprint;
use App\Models\GroupEmployees;
use App\Models\GroupOfSets;
use App\Models\Management;
use App\Models\Period;
use App\Models\Role;
use App\Models\Shift;
use App\Models\Task;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $admin = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'user_name' => 'test',
            'email' => 'test@example.com',
        ]);

        // rolse
        Role::query()->create([
            'name' => 'manager',
            'display_name' => 'المدير'
        ]);

        Role::query()->create([
            'name' => 'employee',
            'display_name' => 'الموظف'
        ]);

        $adminRole = Role::query()->create([
            'name' => 'admin',
            'display_name' => 'ادمن'
        ]);

        $admin->roles()->attach($adminRole->id);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => Department::first()->id,
        ]);

        // Create users for each department with different roles
        Department::all()->each(function ($department) {
            // Create supervisor
            User::create([
                'name' => "Supervisor {$department->name}",
                'email' => "supervisor.{$department->name}@example.com",
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'department_id' => $department->id,
            ]);

            // Create officer
            User::create([
                'name' => "Officer {$department->name}",
                'email' => "officer.{$department->name}@example.com",
                'password' => Hash::make('password'),
                'role' => 'officer',
                'department_id' => $department->id,
            ]);

            // Create junior officer
            User::create([
                'name' => "Junior Officer {$department->name}",
                'email' => "junior.{$department->name}@example.com",
                'password' => Hash::make('password'),
                'role' => 'junior_officer',
                'department_id' => $department->id,
            ]);
        });
    }
}

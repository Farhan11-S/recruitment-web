<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'HRD User',
            'email' => 'hrd@mail.com',
            'password' => bcrypt('password'),
            'role' => 'hrd',
        ]);
        User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@mail.com',
            'password' => bcrypt('password'),
            'role' => 'candidate',
        ]);
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@mail.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);
    }
}

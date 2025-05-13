<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You may want to adjust the table and column names as per your schema
        User::updateOrCreate(
            ['email' => 'admin@yopmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@yopmail.com',
                'password' => Hash::make('password'), // Change this password after first login
                'role' => 'admin',
            ]
        );
    }
}

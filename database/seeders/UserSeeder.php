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
        User::create(
            // default user
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],

            // default admin
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}

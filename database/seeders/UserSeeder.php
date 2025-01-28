<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    // Default user and admin details
    private const DEFAULT_USER = [
        'name' => 'User',
        'username' => 'user',
        'email' => 'user@gmail.com',
        'password' => 'password', // Use a more secure default password
        'role' => 'user',
    ];

    private const DEFAULT_ADMIN = [
        'name' => 'Admin',
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => 'password', // Use a more secure default password
        'role' => 'admin',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            if (!User::where('email', self::DEFAULT_USER['email'])->exists()) {
                User::create([
                    'name' => self::DEFAULT_USER['name'],
                    'username' => self::DEFAULT_USER['username'],
                    'email' => self::DEFAULT_USER['email'],
                    'password' => Hash::make(self::DEFAULT_USER['password']), // Hash the password
                    'role' => self::DEFAULT_USER['role'],
                ]);
            }

            // Create default admin if it doesn't exist
            if (!User::where('email', self::DEFAULT_ADMIN['email'])->exists()) {
                User::create([
                    'name' => self::DEFAULT_ADMIN['name'],
                    'username' => self::DEFAULT_ADMIN['username'],
                    'email' => self::DEFAULT_ADMIN['email'],
                    'password' => Hash::make(self::DEFAULT_ADMIN['password']), // Hash the password
                    'role' => self::DEFAULT_ADMIN['role'],
                ]);
            }
        });
    }
}

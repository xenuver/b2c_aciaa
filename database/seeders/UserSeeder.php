<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            $users = [
                [
                    'name' => 'Administrator',
                    'email' => 'admin@fashionista.com',
                    'role' => 'admin',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sarah Customer',
                    'email' => 'sarah@example.com',
                    'role' => 'customer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Gev',
                    'email' => 'cacasecret21@gmail.com',
                    'role' => 'customer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Admin',
                    'email' => 'aciaa917@gmail.com',
                    'role' => 'admin',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Caca',
                    'email' => 'alderickonnica30@gmail.com',
                    'role' => 'customer',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];

            User::insert($users);
        }
    }
}

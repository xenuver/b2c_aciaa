<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call native seeders
        $this->call([
            UserSeeder::class,
            LocationSeeder::class,
            AciaaProductSeeder::class,
            VoucherSeeder::class,
        ]);

        // Keep testing user setup if not already exists (commented out for production to avoid Faker error)
        /*
        if (\App\Models\User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
        */
    }
}

<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->count(1)->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        
        User::factory()->count(1)->create([
            'email' => 'user@user.com',
            'password' => Hash::make('user'),
            'role' => 'user',
        ]);

        User::factory()->count(1)->create([
            'email' => 'manager@manager.com',
            'password' => Hash::make('manager'),
            'role' => 'manager',
        ]);

        $this->call([
            CategorySeeder::class,
            TourSeeder::class,
            UserSeeder::class,
            ReservationSeeder::class,
            ReviewSeeder::class
        ]);
    }
}

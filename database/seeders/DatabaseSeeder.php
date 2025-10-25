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
        $this->call([
            RoleSeeder::class,
            StationSeeder::class,
            SeatClassSeeder::class,
            TrainSeeder::class,
        ]);

        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@railway.gov.bd',
            'password' => bcrypt('admin123'),
            'role_id' => 1, // admin
            'phone' => '01700000001',
            'email_verified_at' => now(),
        ]);

        // Create test passenger
        User::create([
            'name' => 'John Passenger',
            'email' => 'passenger@test.com',
            'password' => bcrypt('password'),
            'role_id' => 2, // passenger
            'phone' => '01712345678',
            'email_verified_at' => now(),
        ]);

        // Create station master
        User::create([
            'name' => 'Station Master Dhaka',
            'email' => 'stationmaster@railway.gov.bd',
            'password' => bcrypt('station123'),
            'role_id' => 3, // station_master
            'phone' => '01700000003',
            'email_verified_at' => now(),
        ]);

        // Create ticket seller
        User::create([
            'name' => 'Ticket Seller Counter 3',
            'email' => 'seller@railway.gov.bd',
            'password' => bcrypt('seller123'),
            'role_id' => 4, // ticket_seller
            'phone' => '01700000004',
            'email_verified_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Platform 1',
                'description' => 'Main Express Platform',
                'status' => 'available',
                'type' => 'passenger',
                'capacity' => 12,
                'current_train' => null,
                'next_arrival' => Date::now()->addHours(5),
                'last_maintenance' => Date::now()->subDays(5),
                'maintenance_notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Platform 2',
                'description' => 'Local Train Platform',
                'status' => 'occupied',
                'type' => 'passenger',
                'capacity' => 10,
                'current_train' => 'Mohanagar Godhuli (#703)',
                'next_arrival' => null,
                'last_maintenance' => Date::now()->subDays(10),
                'maintenance_notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Platform 3',
                'description' => 'Freight Platform',
                'status' => 'maintenance',
                'type' => 'freight',
                'capacity' => 0,
                'current_train' => null,
                'next_arrival' => null,
                'last_maintenance' => Date::now()->subHours(18),
                'maintenance_notes' => 'Track Repair - 75% complete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Platform 4',
                'description' => 'Intercity Platform',
                'status' => 'available',
                'type' => 'passenger',
                'capacity' => 8,
                'current_train' => null,
                'next_arrival' => Date::now()->addHours(22),
                'last_maintenance' => Date::now()->subHours(2),
                'maintenance_notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('platforms')->insert($platforms);
    }
}
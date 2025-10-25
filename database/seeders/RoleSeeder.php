<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'admin',
                'permissions_json' => json_encode([
                    'manage_trains', 'manage_stations', 'manage_routes', 
                    'manage_schedules', 'manage_users', 'view_reports'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'passenger',
                'permissions_json' => json_encode([
                    'book_tickets', 'view_bookings', 'cancel_bookings'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'station_master',
                'permissions_json' => json_encode([
                    'manage_station_operations', 'view_train_status', 'update_delays'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'ticket_seller',
                'permissions_json' => json_encode([
                    'counter_booking', 'print_tickets', 'cash_payments'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
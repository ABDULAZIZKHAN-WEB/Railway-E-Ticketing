<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class TrainScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample stations if they don't exist
        $stations = [
            [
                'station_code' => 'DHK',
                'station_name' => 'Dhaka',
                'station_name_bn' => 'ঢাকা',
                'division' => 'Dhaka',
                'district' => 'Dhaka',
                'latitude' => '23.72875000',
                'longitude' => '90.40889000',
                'facilities_json' => json_encode(['Waiting Room', 'Food Court', 'ATM']),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'CTG',
                'station_name' => 'Chittagong',
                'station_name_bn' => 'চট্টগ্রাম',
                'division' => 'Chittagong',
                'district' => 'Chittagong',
                'latitude' => '22.34179000',
                'longitude' => '91.83639000',
                'facilities_json' => json_encode(['Waiting Room', 'Medical Aid', 'ATM']),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($stations as $station) {
            if (!DB::table('stations')->where('station_code', $station['station_code'])->exists()) {
                DB::table('stations')->insert($station);
            }
        }

        // Get station IDs
        $dhakaId = DB::table('stations')->where('station_code', 'DHK')->first()->id;
        $chittagongId = DB::table('stations')->where('station_code', 'CTG')->first()->id;

        // Create sample routes if they don't exist
        $routes = [
            [
                'route_name' => 'Dhaka-Chittagong',
                'start_station_id' => $dhakaId,
                'end_station_id' => $chittagongId,
                'total_distance_km' => 280.00,
                'estimated_duration_minutes' => 360,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'route_name' => 'Chittagong-Dhaka',
                'start_station_id' => $chittagongId,
                'end_station_id' => $dhakaId,
                'total_distance_km' => 280.00,
                'estimated_duration_minutes' => 360,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($routes as $route) {
            if (!DB::table('routes')->where('route_name', $route['route_name'])->exists()) {
                DB::table('routes')->insert($route);
            }
        }

        // Get route IDs
        $dhkCtgId = DB::table('routes')->where('route_name', 'Dhaka-Chittagong')->first()->id;
        $ctgDhkId = DB::table('routes')->where('route_name', 'Chittagong-Dhaka')->first()->id;

        // Get train IDs
        $trains = DB::table('trains')->limit(2)->get();
        if ($trains->count() < 2) {
            // Create sample trains if needed
            $sampleTrains = [
                [
                    'train_number' => '701',
                    'train_name' => 'Suborno Express',
                    'train_name_bn' => 'সুবর্ণ এক্সপ্রেস',
                    'train_type' => 'Express',
                    'total_coaches' => 12,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'train_number' => '703',
                    'train_name' => 'Mohanagar Godhuli',
                    'train_name_bn' => 'মহানগর গোধুলি',
                    'train_type' => 'Express',
                    'total_coaches' => 10,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($sampleTrains as $train) {
                if (!DB::table('trains')->where('train_number', $train['train_number'])->exists()) {
                    DB::table('trains')->insert($train);
                }
            }

            $trains = DB::table('trains')->limit(2)->get();
        }

        $trainIds = $trains->pluck('id')->toArray();

        // Create sample train schedules
        $schedules = [
            [
                'train_id' => $trainIds[0],
                'route_id' => $dhkCtgId,
                'departure_time' => '07:30:00',
                'arrival_time' => '13:30:00',
                'running_days_json' => json_encode([0, 1, 2, 3, 4, 5, 6]), // All days
                'effective_from' => Date::now()->subDays(30),
                'effective_to' => Date::now()->addDays(30),
                'status' => 'on_time',
                'delay_minutes' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_id' => $trainIds[1],
                'route_id' => $ctgDhkId,
                'departure_time' => '15:30:00',
                'arrival_time' => '21:30:00',
                'running_days_json' => json_encode([0, 1, 2, 3, 4, 5, 6]), // All days
                'effective_from' => Date::now()->subDays(30),
                'effective_to' => Date::now()->addDays(30),
                'status' => 'delayed',
                'delay_minutes' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($schedules as $schedule) {
            if (!DB::table('train_schedules')->where([
                'train_id' => $schedule['train_id'],
                'route_id' => $schedule['route_id'],
                'departure_time' => $schedule['departure_time']
            ])->exists()) {
                DB::table('train_schedules')->insert($schedule);
            }
        }
    }
}
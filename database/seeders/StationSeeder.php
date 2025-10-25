<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            [
                'station_code' => 'DHAKA',
                'station_name' => 'Dhaka',
                'station_name_bn' => 'ঢাকা',
                'division' => 'Dhaka',
                'district' => 'Dhaka',
                'latitude' => 23.7104,
                'longitude' => 90.4074,
                'facilities_json' => json_encode(['waiting_room', 'restaurant', 'atm', 'parking']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'CTG',
                'station_name' => 'Chittagong',
                'station_name_bn' => 'চট্টগ্রাম',
                'division' => 'Chittagong',
                'district' => 'Chittagong',
                'latitude' => 22.3569,
                'longitude' => 91.7832,
                'facilities_json' => json_encode(['waiting_room', 'restaurant', 'atm']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'SYL',
                'station_name' => 'Sylhet',
                'station_name_bn' => 'সিলেট',
                'division' => 'Sylhet',
                'district' => 'Sylhet',
                'latitude' => 24.8949,
                'longitude' => 91.8687,
                'facilities_json' => json_encode(['waiting_room', 'restaurant']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'RAJ',
                'station_name' => 'Rajshahi',
                'station_name_bn' => 'রাজশাহী',
                'division' => 'Rajshahi',
                'district' => 'Rajshahi',
                'latitude' => 24.3745,
                'longitude' => 88.6042,
                'facilities_json' => json_encode(['waiting_room', 'atm']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'KHL',
                'station_name' => 'Khulna',
                'station_name_bn' => 'খুলনা',
                'division' => 'Khulna',
                'district' => 'Khulna',
                'latitude' => 22.8456,
                'longitude' => 89.5403,
                'facilities_json' => json_encode(['waiting_room', 'restaurant']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'COM',
                'station_name' => 'Comilla',
                'station_name_bn' => 'কুমিল্লা',
                'division' => 'Chittagong',
                'district' => 'Comilla',
                'latitude' => 23.4607,
                'longitude' => 91.1809,
                'facilities_json' => json_encode(['waiting_room']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'station_code' => 'MYM',
                'station_name' => 'Mymensingh',
                'station_name_bn' => 'ময়মনসিংহ',
                'division' => 'Mymensingh',
                'district' => 'Mymensingh',
                'latitude' => 24.7471,
                'longitude' => 90.4203,
                'facilities_json' => json_encode(['waiting_room', 'atm']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('stations')->insert($stations);
    }
}
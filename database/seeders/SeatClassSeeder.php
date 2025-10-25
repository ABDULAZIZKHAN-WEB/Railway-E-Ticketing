<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatClassSeeder extends Seeder
{
    public function run(): void
    {
        $seatClasses = [
            [
                'class_code' => 'AC_B',
                'class_name' => 'AC Berth',
                'class_name_bn' => 'এসি বার্থ',
                'base_price_per_km' => 2.50,
                'amenities_json' => json_encode(['air_conditioning', 'bedding', 'meals']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_code' => 'AC_S',
                'class_name' => 'AC Seat',
                'class_name_bn' => 'এসি সিট',
                'base_price_per_km' => 2.00,
                'amenities_json' => json_encode(['air_conditioning', 'comfortable_seats']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_code' => 'SNIGDHA',
                'class_name' => 'Snigdha',
                'class_name_bn' => 'স্নিগ্ধা',
                'base_price_per_km' => 1.50,
                'amenities_json' => json_encode(['comfortable_seats', 'snacks']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_code' => 'S_CHAIR',
                'class_name' => 'Shovan Chair',
                'class_name_bn' => 'শোভন চেয়ার',
                'base_price_per_km' => 1.20,
                'amenities_json' => json_encode(['comfortable_seats']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_code' => 'SHOVON',
                'class_name' => 'Shovon',
                'class_name_bn' => 'শোভন',
                'base_price_per_km' => 1.00,
                'amenities_json' => json_encode(['basic_seats']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_code' => 'F_BERTH',
                'class_name' => 'First Berth',
                'class_name_bn' => 'ফার্স্ট বার্থ',
                'base_price_per_km' => 1.80,
                'amenities_json' => json_encode(['berth', 'bedding']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('seat_classes')->insert($seatClasses);
    }
}
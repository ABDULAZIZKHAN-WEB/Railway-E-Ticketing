<?php

namespace Database\Seeders;

use App\Models\SeatClass;
use Illuminate\Database\Seeder;

class SeatClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seatClasses = [
            [
                'class_code' => 'AC_B',
                'class_name' => 'AC Berth',
                'class_name_bn' => 'এসি বার্থ',
                'base_price_per_km' => 12.50,
                'amenities_json' => json_encode(['AC', 'Berth', 'Blanket', 'Pillow', 'Food']),
            ],
            [
                'class_code' => 'AC_S',
                'class_name' => 'AC Seat',
                'class_name_bn' => 'এসি সিট',
                'base_price_per_km' => 8.75,
                'amenities_json' => json_encode(['AC', 'Seat', 'Blanket', 'Reading Light']),
            ],
            [
                'class_code' => 'SNIGDHA',
                'class_name' => 'Snigdha',
                'class_name_bn' => 'স্নিগ্ধা',
                'base_price_per_km' => 6.50,
                'amenities_json' => json_encode(['Cushioned Seat', 'Reading Light', 'Charging Point']),
            ],
            [
                'class_code' => 'S_CHAIR',
                'class_name' => 'Shovon Chair',
                'class_name_bn' => 'সভন চেয়ার',
                'base_price_per_km' => 4.25,
                'amenities_json' => json_encode(['Cushioned Seat', 'Fan']),
            ],
            [
                'class_code' => 'SHOVON',
                'class_name' => 'Shovon',
                'class_name_bn' => 'সভন',
                'base_price_per_km' => 2.75,
                'amenities_json' => json_encode(['Seat', 'Fan']),
            ],
            [
                'class_code' => 'F_BERTH',
                'class_name' => 'Fareast Berth',
                'class_name_bn' => 'ফেয়ারইস্ট বার্থ',
                'base_price_per_km' => 10.25,
                'amenities_json' => json_encode(['AC', 'Berth', 'Blanket', 'Pillow', 'Food', 'Entertainment']),
            ],
        ];

        foreach ($seatClasses as $seatClass) {
            SeatClass::updateOrCreate(
                ['class_code' => $seatClass['class_code']],
                $seatClass
            );
        }
    }
}
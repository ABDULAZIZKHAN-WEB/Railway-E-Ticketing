<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainSeeder extends Seeder
{
    public function run(): void
    {
        $trains = [
            [
                'train_number' => '701',
                'train_name' => 'Suborno Express',
                'train_name_bn' => 'সুবর্ণ এক্সপ্রেস',
                'train_type' => 'express',
                'total_coaches' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '703',
                'train_name' => 'Mohanagar Godhuli',
                'train_name_bn' => 'মহানগর গোধূলি',
                'train_type' => 'express',
                'total_coaches' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '705',
                'train_name' => 'Turna Nishita',
                'train_name_bn' => 'তূর্ণা নিশীথা',
                'train_type' => 'express',
                'total_coaches' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '707',
                'train_name' => 'Parabat Express',
                'train_name_bn' => 'পার্বত্য এক্সপ্রেস',
                'train_type' => 'express',
                'total_coaches' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '709',
                'train_name' => 'Chittra Express',
                'train_name_bn' => 'চিত্রা এক্সপ্রেস',
                'train_type' => 'express',
                'total_coaches' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '711',
                'train_name' => 'Silk City Express',
                'train_name_bn' => 'সিল্ক সিটি এক্সপ্রেস',
                'train_type' => 'express',
                'total_coaches' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '713',
                'train_name' => 'Sundarban Express',
                'train_name_bn' => 'সুন্দরবন এক্সপ্রেস',
                'train_type' => 'express',
                'total_coaches' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_number' => '715',
                'train_name' => 'Kapotaksha Express',
                'train_name_bn' => 'কপোতাক্ষ এক্সপ্রেস',
                'train_type' => 'express',
                'total_coaches' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('trains')->insert($trains);
    }
}
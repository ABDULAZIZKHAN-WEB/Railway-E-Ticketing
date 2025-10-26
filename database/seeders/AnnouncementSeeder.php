<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'type' => 'Train Arrival',
                'train_number' => 'Suborno Express (#701)',
                'platform' => 'Platform 1',
                'message_en' => 'Suborno Express from Chittagong is arriving at Platform 1',
                'message_bn' => 'চট্টগ্রাম থেকে আসা সুবর্ণ এক্সপ্রেস প্ল্যাটফর্ম 1 এ আসছে',
                'priority' => 'normal',
                'repeat_times' => 1,
                'repeat_interval' => 0,
                'status' => 'completed',
                'scheduled_at' => Date::now()->subMinutes(2),
                'created_at' => Date::now()->subMinutes(5),
                'updated_at' => Date::now()->subMinutes(2),
            ],
            [
                'type' => 'Train Delay',
                'train_number' => 'Mohanagar Godhuli (#703)',
                'platform' => 'All Platforms',
                'message_en' => 'Mohanagar Godhuli is delayed by 15 minutes due to signal problems',
                'message_bn' => 'সিগন্যাল সমস্যার কারণে মহানগর গোধুলি 15 মিনিট দেরিতে আসবে',
                'priority' => 'high',
                'repeat_times' => 3,
                'repeat_interval' => 30,
                'status' => 'completed',
                'scheduled_at' => Date::now()->subMinutes(15),
                'created_at' => Date::now()->subMinutes(20),
                'updated_at' => Date::now()->subMinutes(15),
            ],
            [
                'type' => 'Safety Reminder',
                'train_number' => null,
                'platform' => 'All Platforms',
                'message_en' => 'Please stand behind the yellow line and allow passengers to exit first',
                'message_bn' => 'অনুগ্রহ করে হলুদ লাইনের পিছনে দাঁড়ান এবং যাত্রীদের প্রথমে নামার সুযোগ দিন',
                'priority' => 'normal',
                'repeat_times' => 1,
                'repeat_interval' => 0,
                'status' => 'completed',
                'scheduled_at' => Date::now()->subHour(1),
                'created_at' => Date::now()->subHour(1),
                'updated_at' => Date::now()->subHour(1),
            ],
        ];

        DB::table('announcements')->insert($announcements);
    }
}
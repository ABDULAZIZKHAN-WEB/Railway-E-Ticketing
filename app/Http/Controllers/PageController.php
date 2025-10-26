<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\TrainSchedule;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        // Get all active stations for the dropdown
        $stations = Station::where('status', 'active')
            ->orderBy('station_name')
            ->get();
            
        // Get some statistics for the stats section
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        $totalSchedules = TrainSchedule::count();
        $activeStations = Station::where('status', 'active')->count();
        
        // Format statistics for display
        $stats = [
            'happy_passengers' => number_format($totalUsers),
            'train_routes' => $activeStations > 0 ? $activeStations : '100+',
            'customer_support' => '24/7',
            'uptime_guarantee' => '99.9%',
        ];
        
        // Get popular routes (in a real app, this would be based on booking frequency)
        $popularRoutes = [
            [
                'from' => 'Dhaka',
                'to' => 'Chittagong',
                'price' => '450+',
                'duration' => '5-7 hours',
                'trains' => 'Multiple daily trains'
            ],
            [
                'from' => 'Dhaka',
                'to' => 'Sylhet',
                'price' => '380+',
                'duration' => '6-8 hours',
                'trains' => 'Daily express trains'
            ],
            [
                'from' => 'Dhaka',
                'to' => 'Rajshahi',
                'price' => '320+',
                'duration' => '4-6 hours',
                'trains' => 'Express & mail trains'
            ]
        ];

        return view('welcome', compact('stations', 'stats', 'popularRoutes'));
    }
}
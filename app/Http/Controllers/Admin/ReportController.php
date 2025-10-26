<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Train;
use App\Models\Station;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the main reports dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get key metrics for the dashboard
        $totalBookings = Booking::count();
        $totalTrains = Train::count();
        $totalStations = Station::count();
        
        // Get recent bookings for the last 30 days
        $recentBookings = Booking::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('admin.reports', compact('totalBookings', 'totalTrains', 'totalStations', 'recentBookings'));
    }

    /**
     * Display sales reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function salesReport()
    {
        // Get sales data
        $salesData = Booking::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_sales')
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('admin.reports.sales', compact('salesData'));
    }

    /**
     * Display train performance reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function trainReport()
    {
        // Get train data
        $trains = Train::withCount('schedules')->get();
        
        return view('admin.reports.trains', compact('trains'));
    }

    /**
     * Display station reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function stationReport()
    {
        // Get station data
        $stations = Station::all();
        
        return view('admin.reports.stations', compact('stations'));
    }
}
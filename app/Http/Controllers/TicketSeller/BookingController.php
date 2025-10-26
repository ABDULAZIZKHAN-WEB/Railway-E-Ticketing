<?php

namespace App\Http\Controllers\TicketSeller;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Train;
use App\Models\Route;
use App\Models\TrainSchedule;
use App\Models\SeatClass;
use App\Models\TrainCoach;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\BookingPassenger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        // Get all active stations for the dropdowns
        $stations = Station::where('status', 'active')
            ->orderBy('station_name')
            ->get();
            
        // Get all seat classes
        $seatClasses = SeatClass::all();
        
        return view('ticket-seller.booking', compact('stations', 'seatClasses'));
    }
    
    public function searchTrains(Request $request)
    {
        $request->validate([
            'from_station' => 'required|exists:stations,id',
            'to_station' => 'required|exists:stations,id',
            'journey_date' => 'required|date|after_or_equal:today',
        ]);
        
        // Get the day of week (0 = Sunday, 6 = Saturday)
        $dayOfWeek = Carbon::parse($request->journey_date)->format('w');
        
        // Find schedules that run on this day
        $allSchedules = TrainSchedule::where('status', 'active')
            ->whereJsonContains('running_days_json', $dayOfWeek)
            ->where('effective_from', '<=', $request->journey_date)
            ->where(function($query) use ($request) {
                $query->where('effective_to', '>=', $request->journey_date)
                      ->orWhereNull('effective_to');
            })
            ->with(['train', 'route.startStation', 'route.endStation', 'route.routeStations.station'])
            ->get();
        
        // Filter schedules that include both stations
        $schedules = collect();
        foreach ($allSchedules as $schedule) {
            if ($this->routeIncludesStations($schedule->route, $request->from_station, $request->to_station)) {
                $schedules->push($schedule);
            }
        }
        
        // Get stations for dropdowns
        $stations = Station::where('status', 'active')
            ->orderBy('station_name')
            ->get();
            
        // Get seat classes
        $seatClasses = SeatClass::all();
        
        return view('ticket-seller.booking', compact('stations', 'seatClasses', 'schedules', 'request'));
    }
    
    private function routeIncludesStations($route, $fromStationId, $toStationId)
    {
        // Handle case where from and to stations are the same
        if ($fromStationId == $toStationId) {
            return false;
        }
        
        // Check if route is direct (start to end)
        if (($route->start_station_id == $fromStationId && $route->end_station_id == $toStationId)) {
            return true;
        }
        
        // Check if route is direct (end to start) - reverse direction
        if (($route->start_station_id == $toStationId && $route->end_station_id == $fromStationId)) {
            return true;
        }
        
        // Get intermediate stations
        $intermediateStations = $route->routeStations->pluck('station_id')->toArray();
        
        // For routes with intermediate stations, check both directions
        // Get all stations in order for this route (start + intermediates + end)
        $routeStations = collect([$route->start_station_id]);
        $sortedIntermediates = $route->routeStations->sortBy('sequence_order');
        foreach ($sortedIntermediates as $intermediate) {
            $routeStations->push($intermediate->station_id);
        }
        $routeStations->push($route->end_station_id);
        
        $routeStationsArray = $routeStations->toArray();
        
        // Find positions of from and to stations
        $fromPosition = array_search($fromStationId, $routeStationsArray);
        $toPosition = array_search($toStationId, $routeStationsArray);
        
        // Check if both stations are on the route and in correct order (forward direction)
        if ($fromPosition !== false && $toPosition !== false && $fromPosition < $toPosition) {
            return true;
        }
        
        // Check if both stations are on the route and in reverse order (reverse direction)
        if ($fromPosition !== false && $toPosition !== false && $fromPosition > $toPosition) {
            return true;
        }
        
        return false;
    }
    
    public function showAvailableSeats(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:train_schedules,id',
            'seat_class_id' => 'required|exists:seat_classes,id',
            'journey_date' => 'required|date',
        ]);
        
        $schedule = TrainSchedule::with('train')->findOrFail($request->schedule_id);
        $seatClass = SeatClass::findOrFail($request->seat_class_id);
        
        // Get coaches for this train and seat class
        $coaches = TrainCoach::where('train_id', $schedule->train_id)
            ->where('seat_class_id', $seatClass->id)
            ->where('status', 'active')
            ->with('seats')
            ->get();
            
        // Get already booked seats for this journey
        $bookedSeatIds = BookingPassenger::whereHas('booking', function($query) use ($request, $schedule) {
            $query->where('train_schedule_id', $schedule->id)
                ->where('journey_date', $request->journey_date);
        })->pluck('seat_id')->toArray();
        
        // Get stations for dropdowns
        $stations = Station::where('status', 'active')
            ->orderBy('station_name')
            ->get();
            
        // Get seat classes
        $seatClasses = SeatClass::all();
        
        return view('ticket-seller.booking', compact('stations', 'seatClasses', 'schedule', 'seatClass', 'coaches', 'bookedSeatIds', 'request'));
    }
    
    public function bookTicket(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:train_schedules,id',
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
            'journey_date' => 'required|date|after_or_equal:today',
            'seat_class_id' => 'required|exists:seat_classes,id',
            'passenger_name.*' => 'required|string|max:255',
            'passenger_age.*' => 'required|integer|min:1',
            'passenger_gender.*' => 'required|in:male,female,other',
            'passenger_id_type.*' => 'required|in:nid,passport,birth_certificate',
            'passenger_id_number.*' => 'required|string|max:50',
            'passenger_seat_id.*' => 'required|exists:seats,id',
            'payment_method' => 'required|in:cash,card,mobile',
        ]);
        
        // Calculate total amount
        $seatClass = SeatClass::findOrFail($request->seat_class_id);
        $totalAmount = count($request->passenger_name) * ($seatClass->base_price_per_km * 50); // Simplified calculation
        $vat = $totalAmount * 0.05;
        $serviceCharge = 20;
        $totalAmount += $vat + $serviceCharge;
        
        // Create booking
        $booking = Booking::create([
            'booking_reference' => 'BR' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(), // Passenger (not used for counter booking)
            'train_schedule_id' => $request->schedule_id,
            'journey_date' => $request->journey_date,
            'from_station_id' => $request->from_station_id,
            'to_station_id' => $request->to_station_id,
            'total_passengers' => count($request->passenger_name),
            'total_amount' => $totalAmount,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'booked_by_role' => 'ticket_seller',
            'booked_by_user_id' => auth()->id(),
        ]);
        
        // Create booking passengers
        for ($i = 0; $i < count($request->passenger_name); $i++) {
            BookingPassenger::create([
                'booking_id' => $booking->id,
                'passenger_name' => $request->passenger_name[$i],
                'age' => $request->passenger_age[$i],
                'gender' => $request->passenger_gender[$i],
                'id_type' => $request->passenger_id_type[$i],
                'id_number' => $request->passenger_id_number[$i],
                'seat_id' => $request->passenger_seat_id[$i],
                'fare_amount' => $seatClass->base_price_per_km * 50,
            ]);
        }
        
        return redirect()->route('ticket-seller.booking')->with('success', 'Booking created successfully! Booking Reference: ' . $booking->booking_reference);
    }
    
    public function searchBookings(Request $request)
    {
        $query = Booking::with(['fromStation', 'toStation', 'trainSchedule.train']);
        
        // Apply filters based on search criteria
        if ($request->filled('search_by') && $request->filled('search_value')) {
            switch ($request->search_by) {
                case 'pnr':
                    $query->where('booking_reference', 'like', '%' . $request->search_value . '%');
                    break;
                case 'phone':
                    // Assuming we have a phone field in bookings or related user
                    // For now, we'll search in booking passengers
                    $query->whereHas('bookingPassengers', function($q) use ($request) {
                        $q->where('id_number', 'like', '%' . $request->search_value . '%');
                    });
                    break;
                case 'name':
                    $query->whereHas('bookingPassengers', function($q) use ($request) {
                        $q->where('passenger_name', 'like', '%' . $request->search_value . '%');
                    });
                    break;
                case 'email':
                    // Assuming we have an email field in bookings or related user
                    break;
                case 'id':
                    $query->whereHas('bookingPassengers', function($q) use ($request) {
                        $q->where('id_number', 'like', '%' . $request->search_value . '%');
                    });
                    break;
            }
        }
        
        if ($request->filled('journey_date')) {
            $query->where('journey_date', $request->journey_date);
        }
        
        if ($request->filled('booking_status') && $request->booking_status !== 'all') {
            $query->where('booking_status', $request->booking_status);
        }
        
        // Order by latest bookings first
        $query->orderBy('created_at', 'desc');
        
        $bookings = $query->paginate(10);
        
        return view('ticket-seller.search', compact('bookings', 'request'));
    }
    
    public function quickSearchBookings($type)
    {
        $query = Booking::with(['fromStation', 'toStation', 'trainSchedule.train']);
        
        switch ($type) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'recent':
                $query->where('booking_status', 'confirmed')
                    ->whereDate('created_at', '>=', now()->subDays(7));
                break;
            case 'pending':
                $query->where('payment_status', 'pending');
                break;
            case 'cancelled':
                $query->where('booking_status', 'cancelled');
                break;
        }
        
        $query->orderBy('created_at', 'desc');
        $bookings = $query->paginate(10);
        
        return view('ticket-seller.search', compact('bookings', 'type'));
    }
    
    public function printTickets(Request $request)
    {
        // Search for bookings based on search criteria
        $query = Booking::with(['fromStation', 'toStation', 'trainSchedule.train', 'bookingPassengers.seat']);
        
        if ($request->filled('search_method') && $request->filled('search_value')) {
            switch ($request->search_method) {
                case 'pnr':
                    $query->where('booking_reference', 'like', '%' . $request->search_value . '%');
                    break;
                case 'phone':
                    $query->whereHas('bookingPassengers', function($q) use ($request) {
                        $q->where('id_number', 'like', '%' . $request->search_value . '%');
                    });
                    break;
                case 'name':
                    $query->whereHas('bookingPassengers', function($q) use ($request) {
                        $q->where('passenger_name', 'like', '%' . $request->search_value . '%');
                    });
                    break;
                case 'booking_id':
                    $query->where('id', $request->search_value);
                    break;
            }
        }
        
        // Order by latest bookings first
        $query->orderBy('created_at', 'desc');
        
        $bookings = $query->paginate(10);
        
        return view('ticket-seller.print', compact('bookings', 'request'));
    }
    
    public function getTicketDetails($bookingId)
    {
        $booking = Booking::with([
            'fromStation', 
            'toStation', 
            'trainSchedule.train', 
            'bookingPassengers.seat.coach'
        ])->findOrFail($bookingId);
        
        return view('ticket-seller.ticket-details', compact('booking'));
    }
    
    public function printTicket($bookingId, Request $request)
    {
        $booking = Booking::with([
            'fromStation', 
            'toStation', 
            'trainSchedule.train', 
            'bookingPassengers.seat.coach'
        ])->findOrFail($bookingId);
        
        // In a real application, this would generate a PDF or send to a printer
        // For now, we'll just return a view that can be printed
        
        return view('ticket-seller.ticket-print', compact('booking', 'request'));
    }
    
    public function cashReport(Request $request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        
        // Get bookings for the date range
        $bookingsQuery = Booking::where('booked_by_user_id', $user->id)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['bookingPassengers', 'fromStation', 'toStation', 'trainSchedule.train']);
            
        $bookings = $bookingsQuery->get();
        
        // Calculate summary statistics
        $totalCashCollected = 0;
        $totalTicketsSold = 0;
        $pendingTransactions = 0;
        $hourlyData = [];
        
        // Initialize hourly data
        for ($i = 0; $i < 24; $i++) {
            $hourlyData[$i] = [
                'hour' => $i,
                'tickets' => 0,
                'total' => 0,
                'cash' => 0
            ];
        }
        
        foreach ($bookings as $booking) {
            if ($booking->payment_status === 'paid') {
                $totalCashCollected += $booking->total_amount;
                $totalTicketsSold++;
                
                // Group by hour
                $hour = $booking->created_at->hour;
                if (isset($hourlyData[$hour])) {
                    $hourlyData[$hour]['tickets']++;
                    $hourlyData[$hour]['total'] += $booking->total_amount;
                    // Simplified - assuming all payments are cash for this example
                    $hourlyData[$hour]['cash'] += $booking->total_amount;
                }
            } elseif ($booking->payment_status === 'pending') {
                $pendingTransactions++;
            }
        }
        
        // Filter out hours with no data
        $hourlyData = array_filter($hourlyData, function($hour) {
            return $hour['tickets'] > 0;
        });
        
        // Calculate average sale
        $averageSale = $totalTicketsSold > 0 ? $totalCashCollected / $totalTicketsSold : 0;
        
        // Cash management data (simplified)
        $openingBalance = 5000; // This would come from a cash register system
        $currentBalance = $openingBalance + $totalCashCollected;
        
        return view('ticket-seller.cash-report', compact(
            'bookings', 
            'totalCashCollected', 
            'totalTicketsSold', 
            'pendingTransactions', 
            'averageSale', 
            'hourlyData',
            'openingBalance',
            'currentBalance',
            'startDate',
            'endDate'
        ));
    }
}
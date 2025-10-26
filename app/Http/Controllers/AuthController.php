<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\TrainSchedule;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.railway-login');
    }

    public function showRegister()
    {
        return view('auth.railway-register');
    }

    public function login(Request $request)
    {
        // Debug: Log login attempt
        \Log::info('Login attempt', ['email' => $request->email]);
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            \Log::error('Login validation failed', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            \Log::info('Login successful', ['user_id' => Auth::id()]);
            
            // Check if there's a redirect target after login (for booking flow)
            if (session()->has('redirect_after_login')) {
                $redirectRoute = session('redirect_after_login');
                session()->forget('redirect_after_login');
                
                // Only redirect to allowed routes
                if (in_array($redirectRoute, ['booking.seat-selection'])) {
                    return redirect()->route($redirectRoute)->with('success', 'Welcome back! Login successful.');
                }
            }
            
            return redirect('/dashboard')->with('success', 'Welcome back! Login successful.');
        }

        \Log::warning('Login failed - invalid credentials', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        // Debug: Log the request data
        \Log::info('Registration attempt', $request->all());
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            \Log::error('Registration validation failed', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role_id' => 2, // passenger role
            ]);

            \Log::info('User created successfully', ['user_id' => $user->id]);

            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Welcome to Bangladesh Railway E-Ticketing! Your account has been created successfully.');
        } catch (\Exception $e) {
            \Log::error('Registration failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully. Thank you for using Bangladesh Railway E-Ticketing!');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Route to appropriate dashboard based on role
        switch ($user->role->name) {
            case 'admin':
                return $this->adminDashboard();
            case 'station_master':
                return $this->stationMasterDashboard();
            case 'ticket_seller':
                return $this->ticketSellerDashboard();
            case 'passenger':
            default:
                return $this->passengerDashboard();
        }
    }

    private function adminDashboard()
    {
        // Admin dashboard data
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_trains' => \DB::table('trains')->count(),
            'total_stations' => \DB::table('stations')->count(),
            'total_bookings' => \DB::table('bookings')->count(),
            'today_bookings' => \DB::table('bookings')->whereDate('created_at', today())->count(),
            'total_revenue' => \DB::table('bookings')->where('payment_status', 'paid')->sum('total_amount'),
            'total_schedules' => \DB::table('train_schedules')->count(),
        ];

        $recent_bookings = \DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('trains', 'bookings.train_schedule_id', '=', 'trains.id')
            ->select('bookings.*', 'users.name as user_name', 'trains.train_name')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.admin-dashboard', compact('stats', 'recent_bookings'));
    }

    private function stationMasterDashboard()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Get today's train schedules
        $trainSchedules = TrainSchedule::whereDate('created_at', $today)
            ->with(['train'])
            ->get();
            
        // Calculate statistics
        $trainsToday = $trainSchedules->count();
        $arrivalsToday = $trainSchedules->where('arrival_time', '!=', null)->count();
        $departuresToday = $trainSchedules->where('departure_time', '!=', null)->count();
        $delayedTrains = $trainSchedules->where('delay_minutes', '>', 0)->count();
        
        // Estimate passengers (in a real app, this would come from booking data)
        $passengersToday = $trainsToday * 50; // Rough estimate
        
        // Station stats
        $station_stats = [
            'assigned_station' => 'Dhaka Railway Station', // This would come from user profile in a real app
            'trains_today' => $trainsToday,
            'arrivals_today' => $arrivalsToday,
            'departures_today' => $departuresToday,
            'delayed_trains' => $delayedTrains,
            'passengers_today' => $passengersToday,
        ];
        
        // Get today's trains with status
        $todays_trains = $trainSchedules
            ->take(5)
            ->map(function ($schedule) {
                return [
                    'train_name' => $schedule->train ? $schedule->train->train_name : 'Unknown Train',
                    'train_number' => $schedule->train ? $schedule->train->train_number : 'N/A',
                    'type' => $schedule->arrival_time ? 'arrival' : 'departure',
                    'scheduled_time' => $schedule->arrival_time ? 
                        $schedule->arrival_time->format('h:i A') : 
                        ($schedule->departure_time ? $schedule->departure_time->format('h:i A') : 'N/A'),
                    'status' => $schedule->delay_minutes > 0 ? 'delayed' : 'on_time'
                ];
            });

        return view('dashboard.station-master-dashboard', compact('station_stats', 'todays_trains'));
    }

    private function ticketSellerDashboard()
    {
        $user = Auth::user();
        
        // Get today's date
        $today = Carbon::today();
        
        // Get bookings created by this ticket seller today
        $bookingsQuery = Booking::where('booked_by_user_id', $user->id)
            ->whereDate('created_at', $today);
            
        // Get all bookings for statistics
        $allBookings = $bookingsQuery->get();
        
        // Calculate statistics
        $ticketsSoldToday = $allBookings->count();
        $cashCollected = $allBookings->where('payment_status', 'paid')->sum('total_amount');
        $pendingTransactions = $allBookings->where('payment_status', 'pending')->count();
        
        // Get recent sales (last 5 bookings)
        $recentSales = $bookingsQuery
            ->with(['bookingPassengers', 'trainSchedule.train'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($booking) {
                return [
                    'pnr' => $booking->booking_reference,
                    'passenger' => $booking->bookingPassengers->first()->passenger_name ?? 'N/A',
                    'train' => $booking->trainSchedule->train->train_name ?? 'N/A',
                    'amount' => $booking->total_amount,
                    'time' => $booking->created_at->format('h:i A')
                ];
            });
            
        // Get seller statistics (using the correct variable name)
        $seller_stats = [
            'assigned_counter' => 'Counter #' . ($user->id % 5 + 1), // Mock counter assignment
            'shift' => 'Morning Shift (8:00 AM - 4:00 PM)',
            'tickets_sold_today' => $ticketsSoldToday,
            'cash_collected' => $cashCollected,
            'pending_transactions' => $pendingTransactions,
        ];

        return view('dashboard.ticket-seller-dashboard', compact('seller_stats', 'recentSales'));
    }

    private function passengerDashboard()
    {
        $user = Auth::user();
        
        // Get user's recent bookings (using the correct variable name for the view)
        $bookings = Booking::where('user_id', $user->id)
            ->with(['trainSchedule.train', 'fromStation', 'toStation', 'bookingPassengers'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get user's upcoming journeys
        $upcoming_journeys = Booking::where('user_id', $user->id)
            ->where('journey_date', '>=', today())
            ->where('booking_status', 'confirmed')
            ->with(['trainSchedule.train', 'fromStation', 'toStation'])
            ->orderBy('journey_date')
            ->limit(3)
            ->get();
            
        // Calculate statistics
        $total_bookings = Booking::where('user_id', $user->id)->count();
        $total_spent = Booking::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
            
        $passenger_stats = [
            'total_bookings' => $total_bookings,
            'total_spent' => $total_spent,
            'upcoming_journeys' => $upcoming_journeys->count(),
            'loyalty_points' => $total_bookings * 10 // Simple loyalty points calculation
        ];

        return view('dashboard.passenger-dashboard', compact('passenger_stats', 'bookings', 'upcoming_journeys'));
    }
}
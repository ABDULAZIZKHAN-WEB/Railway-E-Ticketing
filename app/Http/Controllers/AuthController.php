<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        
        // Mock data for station master (in real app, filter by assigned station)
        $station_stats = [
            'assigned_station' => 'Dhaka Railway Station',
            'trains_today' => 25,
            'arrivals_today' => 12,
            'departures_today' => 13,
            'delayed_trains' => 2,
            'passengers_today' => 1250,
        ];

        $todays_trains = [
            ['train_name' => 'Suborno Express', 'train_number' => '701', 'type' => 'arrival', 'scheduled_time' => '08:30', 'status' => 'on_time'],
            ['train_name' => 'Mohanagar Godhuli', 'train_number' => '703', 'type' => 'departure', 'scheduled_time' => '15:30', 'status' => 'delayed'],
            ['train_name' => 'Turna Nishita', 'train_number' => '705', 'type' => 'arrival', 'scheduled_time' => '23:00', 'status' => 'on_time'],
        ];

        return view('dashboard.station-master-dashboard', compact('station_stats', 'todays_trains'));
    }

    private function ticketSellerDashboard()
    {
        $user = Auth::user();
        
        // Mock data for ticket seller
        $seller_stats = [
            'assigned_counter' => 'Counter #3',
            'shift' => 'Morning Shift (8:00 AM - 4:00 PM)',
            'tickets_sold_today' => 45,
            'cash_collected' => 12500,
            'pending_transactions' => 3,
        ];

        $recent_sales = [
            ['pnr' => 'PNR123456', 'passenger' => 'John Doe', 'train' => 'Suborno Express', 'amount' => 950, 'time' => '10:30 AM'],
            ['pnr' => 'PNR123457', 'passenger' => 'Jane Smith', 'train' => 'Mohanagar Godhuli', 'amount' => 750, 'time' => '11:15 AM'],
            ['pnr' => 'PNR123458', 'passenger' => 'Bob Wilson', 'train' => 'Turna Nishita', 'amount' => 1250, 'time' => '12:00 PM'],
        ];

        return view('dashboard.ticket-seller-dashboard', compact('seller_stats', 'recent_sales'));
    }

    private function passengerDashboard()
    {
        $user = Auth::user();
        
        // Passenger dashboard data
        $passenger_stats = [
            'total_bookings' => 0, // In real app: $user->bookings()->count()
            'total_spent' => 0, // In real app: $user->bookings()->sum('total_amount')
            'upcoming_journeys' => 0,
            'loyalty_points' => 0,
        ];

        return view('dashboard.passenger-dashboard', compact('passenger_stats'));
    }
}
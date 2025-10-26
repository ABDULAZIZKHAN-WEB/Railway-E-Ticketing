<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\TrainSchedule;
use App\Models\Station;
use App\Models\Train;
use App\Models\Route;
use App\Models\SeatClass;
use App\Models\TrainCoach;
use App\Models\Seat;
use App\Models\BookingPassenger;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function myBookings()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Get all bookings for the authenticated user
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['fromStation', 'toStation', 'trainSchedule.train'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('bookings.my-bookings', compact('bookings'));
    }
    
    public function selectTrain(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Store the booking data in session for after login
            $bookingData = [
                'train_number' => $request->train_number,
                'class_code' => $request->class_code,
                'fare' => $request->fare,
                'schedule_id' => $request->schedule_id,
                'from_station' => $request->from_station,
                'to_station' => $request->to_station,
                'journey_date' => $request->journey_date,
            ];
            
            session(['booking_data' => $bookingData]);
            session(['redirect_after_login' => 'booking.seat-selection']);
            
            return redirect()->route('login')->with('info', 'Please login to continue with your booking.');
        }
        
        // Validate the request
        $request->validate([
            'train_number' => 'required',
            'class_code' => 'required',
            'fare' => 'required|numeric',
            'schedule_id' => 'required|exists:train_schedules,id',
            'from_station' => 'required',
            'to_station' => 'required',
            'journey_date' => 'required|date',
        ]);
        
        // Store booking data in session
        $bookingData = [
            'train_number' => $request->train_number,
            'class_code' => $request->class_code,
            'fare' => $request->fare,
            'schedule_id' => $request->schedule_id,
            'from_station' => $request->from_station,
            'to_station' => $request->to_station,
            'journey_date' => $request->journey_date,
        ];
        
        session(['booking_data' => $bookingData]);
        
        // Redirect to seat selection page
        return redirect()->route('booking.seat-selection');
    }
    
    public function seatSelection(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Check if we have booking data from session
            if (session()->has('booking_data') && session('redirect_after_login') === 'booking.seat-selection') {
                // User just logged in, proceed with booking
                session()->forget('redirect_after_login');
            } else {
                return redirect()->route('login')->with('info', 'Please login to continue with your booking.');
            }
        }
        
        // Get booking data from session
        $bookingData = session('booking_data', []);
        
        // Check if we have booking data
        if (empty($bookingData)) {
            return redirect()->route('search.trains')->with('error', 'Please search for trains first.');
        }
        
        try {
            // Get schedule details
            $schedule = TrainSchedule::with(['train', 'route.startStation', 'route.endStation'])
                ->findOrFail($bookingData['schedule_id']);
                
            $fromStation = Station::where('station_code', $bookingData['from_station'])->firstOrFail();
            $toStation = Station::where('station_code', $bookingData['to_station'])->firstOrFail();
            
            // Get seat class
            $seatClass = SeatClass::where('class_code', $bookingData['class_code'])->firstOrFail();
            
            // Get coaches for this train and seat class
            $coaches = TrainCoach::where('train_id', $schedule->train_id)
                ->where('seat_class_id', $seatClass->id)
                ->where('status', 'active')
                ->with('seats')
                ->get();
                
            // Get already booked seats for this journey
            $bookedSeatIds = BookingPassenger::whereHas('booking', function($query) use ($schedule, $bookingData) {
                $query->where('train_schedule_id', $schedule->id)
                    ->where('journey_date', $bookingData['journey_date']);
            })->pluck('seat_id')->toArray();
            
            return view('bookings.seat-selection', compact('schedule', 'fromStation', 'toStation', 'seatClass', 'coaches', 'bookedSeatIds', 'bookingData'));
        } catch (\Exception $e) {
            return redirect()->route('search.trains')->with('error', 'Invalid booking data. Please try again.');
        }
    }
    
    public function payment(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login to continue with your booking.');
        }
        
        // Get booking data from session
        $bookingData = session('booking_data', []);
        
        if (empty($bookingData)) {
            return redirect()->route('search.trains')->with('error', 'Please search for trains first.');
        }
        
        try {
            // Get schedule details
            $schedule = TrainSchedule::with(['train', 'route.startStation', 'route.endStation'])
                ->findOrFail($bookingData['schedule_id']);
                
            $fromStation = Station::where('station_code', $bookingData['from_station'])->firstOrFail();
            $toStation = Station::where('station_code', $bookingData['to_station'])->firstOrFail();
            $seatClass = SeatClass::where('class_code', $bookingData['class_code'])->firstOrFail();
            
            return view('bookings.payment', compact('schedule', 'fromStation', 'toStation', 'seatClass', 'bookingData'));
        } catch (\Exception $e) {
            return redirect()->route('search.trains')->with('error', 'Invalid booking data. Please try again.');
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrainSearchController extends Controller
{
    public function showSearchForm(Request $request)
    {
        // Get all stations for the dropdown
        $stations = DB::table('stations')->orderBy('station_name')->get();
        
        // If we have from and to parameters, we could pre-fill the form
        $fromStation = $request->query('from');
        $toStation = $request->query('to');
        
        return view('trains.search-form', compact('stations', 'fromStation', 'toStation'));
    }

    public function search(Request $request)
    {
        // Debug: Log search attempt
        Log::info('Train search attempt', $request->all());
        
        try {
            $request->validate([
                'from_station' => 'required|string',
                'to_station' => 'required|string|different:from_station',
                'journey_date' => 'required|date|after_or_equal:today',
            ]);

            // Get station details
            $fromStation = DB::table('stations')->where('station_code', $request->from_station)->first();
            $toStation = DB::table('stations')->where('station_code', $request->to_station)->first();

            if (!$fromStation || !$toStation) {
                Log::error('Invalid stations', [
                    'from_station' => $request->from_station,
                    'to_station' => $request->to_station,
                    'from_found' => !!$fromStation,
                    'to_found' => !!$toStation
                ]);
                return back()->withErrors(['error' => 'Invalid station selection.']);
            }

            // For now, return mock data since we don't have routes and schedules set up yet
            $trains = $this->getMockTrainData($fromStation, $toStation, $request->journey_date);

            Log::info('Train search successful', ['trains_found' => count($trains)]);

            return view('trains.search-results', compact('trains', 'fromStation', 'toStation', 'request'));
        } catch (\Exception $e) {
            Log::error('Train search failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Search failed. Please try again.']);
        }
    }

    private function getMockTrainData($fromStation, $toStation, $journeyDate)
    {
        // Mock train data for demonstration
        return [
            [
                'train_number' => '701',
                'train_name' => 'Suborno Express',
                'departure_time' => '07:30',
                'arrival_time' => '14:45',
                'duration' => '7h 15m',
                'classes' => [
                    ['class_code' => 'AC_B', 'class_name' => 'AC Berth', 'available_seats' => 24, 'fare' => 1250],
                    ['class_code' => 'AC_S', 'class_name' => 'AC Seat', 'available_seats' => 48, 'fare' => 950],
                    ['class_code' => 'S_CHAIR', 'class_name' => 'Shovan Chair', 'available_seats' => 72, 'fare' => 650],
                    ['class_code' => 'SHOVON', 'class_name' => 'Shovon', 'available_seats' => 96, 'fare' => 450],
                ]
            ],
            [
                'train_number' => '703',
                'train_name' => 'Mohanagar Godhuli',
                'departure_time' => '15:30',
                'arrival_time' => '22:15',
                'duration' => '6h 45m',
                'classes' => [
                    ['class_code' => 'AC_S', 'class_name' => 'AC Seat', 'available_seats' => 36, 'fare' => 950],
                    ['class_code' => 'SNIGDHA', 'class_name' => 'Snigdha', 'available_seats' => 54, 'fare' => 750],
                    ['class_code' => 'S_CHAIR', 'class_name' => 'Shovan Chair', 'available_seats' => 68, 'fare' => 650],
                ]
            ],
            [
                'train_number' => '705',
                'train_name' => 'Turna Nishita',
                'departure_time' => '23:00',
                'arrival_time' => '06:30',
                'duration' => '7h 30m',
                'classes' => [
                    ['class_code' => 'AC_B', 'class_name' => 'AC Berth', 'available_seats' => 18, 'fare' => 1250],
                    ['class_code' => 'F_BERTH', 'class_name' => 'First Berth', 'available_seats' => 32, 'fare' => 850],
                    ['class_code' => 'SHOVON', 'class_name' => 'Shovon', 'available_seats' => 84, 'fare' => 450],
                ]
            ],
        ];
    }
}
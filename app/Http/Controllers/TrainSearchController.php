<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Station;
use App\Models\TrainSchedule;
use App\Models\Route;
use App\Models\RouteStation;
use Carbon\Carbon;

class TrainSearchController extends Controller
{
    public function showSearchForm(Request $request)
    {
        // Get all active stations for the dropdown
        $stations = Station::where('status', 'active')
            ->orderBy('station_name')
            ->get();
        
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
                'class_preference' => 'nullable|string'
            ]);

            // Get station details
            $fromStation = Station::where('station_code', $request->from_station)->first();
            $toStation = Station::where('station_code', $request->to_station)->first();

            if (!$fromStation || !$toStation) {
                Log::error('Invalid stations', [
                    'from_station' => $request->from_station,
                    'to_station' => $request->to_station,
                    'from_found' => !!$fromStation,
                    'to_found' => !!$toStation
                ]);
                return back()->withErrors(['error' => 'Invalid station selection.']);
            }

            // Get real train data based on schedules
            $trains = $this->getRealTrainData($fromStation, $toStation, $request->journey_date, $request->class_preference);

            Log::info('Train search successful', ['trains_found' => count($trains)]);

            return view('trains.search-results', compact('trains', 'fromStation', 'toStation', 'request'));
        } catch (\Exception $e) {
            Log::error('Train search failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Search failed. Please try again.']);
        }
    }

    private function getRealTrainData($fromStation, $toStation, $journeyDate, $classPreference = null)
    {
        // Get the day of week (0 = Sunday, 6 = Saturday)
        $dayOfWeek = Carbon::parse($journeyDate)->format('w');
        
        // Find schedules that run on this day
        $schedules = TrainSchedule::with(['train', 'route.startStation', 'route.endStation', 'route.routeStations.station'])
            ->where('status', 'active')
            ->whereJsonContains('running_days_json', $dayOfWeek)
            ->where('effective_from', '<=', $journeyDate)
            ->where(function($query) use ($journeyDate) {
                $query->where('effective_to', '>=', $journeyDate)
                      ->orWhereNull('effective_to');
            })
            ->get();
            
        $trains = [];
        
        foreach ($schedules as $schedule) {
            $route = $schedule->route;
            
            // Check if this route includes both from and to stations
            if ($this->routeIncludesStations($route, $fromStation->id, $toStation->id)) {
                // Calculate departure and arrival times for the specific stations
                $departureInfo = $this->getStationTimeInfo($route, $fromStation->id, $schedule);
                $arrivalInfo = $this->getStationTimeInfo($route, $toStation->id, $schedule);
                
                if ($departureInfo && $arrivalInfo) {
                    // Calculate duration
                    $departureTime = Carbon::parse($departureInfo['time']);
                    $arrivalTime = Carbon::parse($arrivalInfo['time']);
                    
                    if ($arrivalTime->lt($departureTime)) {
                        $arrivalTime->addDay();
                    }
                    
                    $duration = $departureTime->diff($arrivalTime);
                    $durationString = $duration->h . 'h ' . $duration->i . 'm';
                    
                    // Get seat classes and availability (mock data for now)
                    $classes = $this->getSeatClasses($schedule, $classPreference);
                    
                    $trains[] = [
                        'train_number' => $schedule->train->train_number,
                        'train_name' => $schedule->train->train_name,
                        'departure_time' => $departureInfo['time']->format('g:i A'),
                        'arrival_time' => $arrivalInfo['time']->format('g:i A'),
                        'duration' => $durationString,
                        'classes' => $classes,
                        'schedule_id' => $schedule->id
                    ];
                }
            }
        }
        
        return $trains;
    }
    
    private function routeIncludesStations($route, $fromStationId, $toStationId)
    {
        // Check if route is direct (start to end)
        if (($route->start_station_id == $fromStationId && $route->end_station_id == $toStationId) ||
            ($route->start_station_id == $toStationId && $route->end_station_id == $fromStationId)) {
            return true;
        }
        
        // Check if both stations are in the intermediate stations
        $intermediateStations = $route->routeStations->pluck('station_id')->toArray();
        
        if (in_array($fromStationId, $intermediateStations) && in_array($toStationId, $intermediateStations)) {
            // Check if from station comes before to station in sequence
            $fromSequence = $route->routeStations->where('station_id', $fromStationId)->first()->sequence_order;
            $toSequence = $route->routeStations->where('station_id', $toStationId)->first()->sequence_order;
            
            return $fromSequence < $toSequence;
        }
        
        // Check if one is start/end and other is intermediate
        if (($route->start_station_id == $fromStationId || $route->end_station_id == $fromStationId) &&
            in_array($toStationId, $intermediateStations)) {
            if ($route->start_station_id == $fromStationId) {
                // From is start, to is intermediate
                return true;
            } else {
                // From is end, to is intermediate (reverse direction)
                return false;
            }
        }
        
        if (($route->start_station_id == $toStationId || $route->end_station_id == $toStationId) &&
            in_array($fromStationId, $intermediateStations)) {
            if ($route->start_station_id == $toStationId) {
                // To is start, from is intermediate (reverse direction)
                return false;
            } else {
                // To is end, from is intermediate
                return true;
            }
        }
        
        return false;
    }
    
    private function getStationTimeInfo($route, $stationId, $schedule)
    {
        // If it's the start station
        if ($route->start_station_id == $stationId) {
            return [
                'time' => Carbon::parse($schedule->departure_time),
                'platform' => 'Platform 1' // This would come from actual data
            ];
        }
        
        // If it's the end station
        if ($route->end_station_id == $stationId) {
            return [
                'time' => Carbon::parse($schedule->arrival_time),
                'platform' => 'Platform 1' // This would come from actual data
            ];
        }
        
        // Check intermediate stations
        $routeStation = $route->routeStations->where('station_id', $stationId)->first();
        if ($routeStation) {
            // Calculate time based on offset from departure time
            $baseTime = Carbon::parse($schedule->departure_time);
            $arrivalOffset = $routeStation->arrival_time_offset_minutes;
            
            return [
                'time' => $baseTime->addMinutes($arrivalOffset),
                'platform' => $routeStation->platform_number ?? 'Platform ' . rand(1, 4)
            ];
        }
        
        return null;
    }
    
    private function getSeatClasses($schedule, $classPreference = null)
    {
        // Mock seat class data - in a real app this would come from the train configuration
        $allClasses = [
            ['class_code' => 'AC_B', 'class_name' => 'AC Berth', 'available_seats' => rand(10, 30), 'fare' => rand(800, 1500)],
            ['class_code' => 'AC_S', 'class_name' => 'AC Seat', 'available_seats' => rand(20, 50), 'fare' => rand(600, 1200)],
            ['class_code' => 'SNIGDHA', 'class_name' => 'Snigdha', 'available_seats' => rand(30, 60), 'fare' => rand(500, 900)],
            ['class_code' => 'S_CHAIR', 'class_name' => 'Shovan Chair', 'available_seats' => rand(40, 80), 'fare' => rand(300, 600)],
            ['class_code' => 'SHOVON', 'class_name' => 'Shovon', 'available_seats' => rand(50, 100), 'fare' => rand(200, 400)],
            ['class_code' => 'F_BERTH', 'class_name' => 'First Berth', 'available_seats' => rand(15, 35), 'fare' => rand(700, 1100)],
        ];
        
        // If class preference is specified, prioritize that class
        if ($classPreference) {
            $preferredClass = array_filter($allClasses, function($class) use ($classPreference) {
                return $class['class_code'] === $classPreference;
            });
            
            if (!empty($preferredClass)) {
                // Move preferred class to the front
                $preferredClass = array_values($preferredClass)[0];
                $otherClasses = array_filter($allClasses, function($class) use ($classPreference) {
                    return $class['class_code'] !== $classPreference;
                });
                
                return array_merge([$preferredClass], array_values($otherClasses));
            }
        }
        
        return $allClasses;
    }
}
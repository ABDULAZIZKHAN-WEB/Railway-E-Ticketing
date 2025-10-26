<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainSchedule;
use App\Models\Train;
use App\Models\Route;
use App\Models\Station;
use Illuminate\Http\Request;

class TrainScheduleController extends Controller
{
    /**
     * Display a listing of the train schedules.
     */
    public function index(Request $request)
    {
        $query = TrainSchedule::with(['train', 'route.startStation', 'route.endStation']);
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('train', function($q) use ($search) {
                $q->where('train_number', 'like', "%{$search}%")
                  ->orWhere('train_name', 'like', "%{$search}%");
            });
        }
        
        // Handle date filter
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('departure_time', $request->date);
        }
        
        $schedules = $query->orderBy('departure_time')->paginate(15);
        
        return view('admin.train-schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new train schedule.
     */
    public function create()
    {
        $trains = Train::all();
        $routes = Route::with(['startStation', 'endStation'])->get();
        $stations = Station::all();
        
        return view('admin.train-schedules.create', compact('trains', 'routes', 'stations'));
    }

    /**
     * Store a newly created train schedule in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'running_days' => 'required|array',
            'running_days.*' => 'in:0,1,2,3,4,5,6',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $schedule = TrainSchedule::create([
            'train_id' => $request->train_id,
            'route_id' => $request->route_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'running_days_json' => $request->running_days,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'status' => 'active',
        ]);

        return redirect()->route('admin.train-schedules.index')->with('success', 'Train schedule created successfully.');
    }

    /**
     * Show the form for editing the specified train schedule.
     */
    public function edit(TrainSchedule $schedule)
    {
        $trains = Train::all();
        $routes = Route::with(['startStation', 'endStation'])->get();
        $stations = Station::all();
        
        return view('admin.train-schedules.edit', compact('schedule', 'trains', 'routes', 'stations'));
    }

    /**
     * Update the specified train schedule in storage.
     */
    public function update(Request $request, TrainSchedule $schedule)
    {
        $request->validate([
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'running_days' => 'required|array',
            'running_days.*' => 'in:0,1,2,3,4,5,6',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $schedule->update([
            'train_id' => $request->train_id,
            'route_id' => $request->route_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'running_days_json' => $request->running_days,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
        ]);

        return redirect()->route('admin.train-schedules.index')->with('success', 'Train schedule updated successfully.');
    }

    /**
     * Remove the specified train schedule from storage.
     */
    public function destroy(TrainSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.train-schedules.index')->with('success', 'Train schedule deleted successfully.');
    }
}
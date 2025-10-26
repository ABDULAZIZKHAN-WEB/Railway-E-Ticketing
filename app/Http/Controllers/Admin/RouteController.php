<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Station;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the routes.
     */
    public function index(Request $request)
    {
        $query = Route::with(['startStation', 'endStation']);
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('route_name', 'like', "%{$search}%")
                  ->orWhereHas('startStation', function($q) use ($search) {
                      $q->where('station_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('endStation', function($q) use ($search) {
                      $q->where('station_name', 'like', "%{$search}%");
                  });
            });
        }
        
        $routes = $query->orderBy('route_name')->paginate(15);
        
        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new route.
     */
    public function create()
    {
        $stations = Station::all();
        return view('admin.routes.create', compact('stations'));
    }

    /**
     * Store a newly created route in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|exists:stations,id|different:start_station_id',
            'total_distance_km' => 'required|numeric|min:0',
            'estimated_duration_minutes' => 'required|integer|min:1',
            'intermediate_stations' => 'array',
            'intermediate_stations.*.station_id' => 'exists:stations,id',
            'intermediate_stations.*.sequence_order' => 'integer|min:1',
            'intermediate_stations.*.arrival_time_offset_minutes' => 'integer|min:0',
            'intermediate_stations.*.departure_time_offset_minutes' => 'integer|min:0',
            'intermediate_stations.*.platform_number' => 'nullable|string|max:10',
            'intermediate_stations.*.distance_from_start_km' => 'numeric|min:0',
            'intermediate_stations.*.halt_duration_minutes' => 'integer|min:0',
        ]);

        // Create the route
        $route = Route::create([
            'route_name' => $request->route_name,
            'start_station_id' => $request->start_station_id,
            'end_station_id' => $request->end_station_id,
            'total_distance_km' => $request->total_distance_km,
            'estimated_duration_minutes' => $request->estimated_duration_minutes,
            'status' => $request->status ?? 'active',
        ]);

        // Create intermediate stations if provided
        if ($request->has('intermediate_stations')) {
            foreach ($request->intermediate_stations as $intermediateStation) {
                RouteStation::create([
                    'route_id' => $route->id,
                    'station_id' => $intermediateStation['station_id'],
                    'sequence_order' => $intermediateStation['sequence_order'],
                    'arrival_time_offset_minutes' => $intermediateStation['arrival_time_offset_minutes'] ?? 0,
                    'departure_time_offset_minutes' => $intermediateStation['departure_time_offset_minutes'] ?? 0,
                    'platform_number' => $intermediateStation['platform_number'] ?? null,
                    'distance_from_start_km' => $intermediateStation['distance_from_start_km'] ?? 0,
                    'halt_duration_minutes' => $intermediateStation['halt_duration_minutes'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route created successfully.');
    }

    /**
     * Show the form for editing the specified route.
     */
    public function edit(Route $route)
    {
        $stations = Station::all();
        $route->load('routeStations.station');
        return view('admin.routes.edit', compact('route', 'stations'));
    }

    /**
     * Update the specified route in storage.
     */
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|exists:stations,id|different:start_station_id',
            'total_distance_km' => 'required|numeric|min:0',
            'estimated_duration_minutes' => 'required|integer|min:1',
            'intermediate_stations' => 'array',
            'intermediate_stations.*.station_id' => 'exists:stations,id',
            'intermediate_stations.*.sequence_order' => 'integer|min:1',
            'intermediate_stations.*.arrival_time_offset_minutes' => 'integer|min:0',
            'intermediate_stations.*.departure_time_offset_minutes' => 'integer|min:0',
            'intermediate_stations.*.platform_number' => 'nullable|string|max:10',
            'intermediate_stations.*.distance_from_start_km' => 'numeric|min:0',
            'intermediate_stations.*.halt_duration_minutes' => 'integer|min:0',
        ]);

        // Update the route
        $route->update([
            'route_name' => $request->route_name,
            'start_station_id' => $request->start_station_id,
            'end_station_id' => $request->end_station_id,
            'total_distance_km' => $request->total_distance_km,
            'estimated_duration_minutes' => $request->estimated_duration_minutes,
            'status' => $request->status ?? 'active',
        ]);

        // Delete existing intermediate stations
        $route->routeStations()->delete();

        // Create new intermediate stations if provided
        if ($request->has('intermediate_stations')) {
            foreach ($request->intermediate_stations as $intermediateStation) {
                RouteStation::create([
                    'route_id' => $route->id,
                    'station_id' => $intermediateStation['station_id'],
                    'sequence_order' => $intermediateStation['sequence_order'],
                    'arrival_time_offset_minutes' => $intermediateStation['arrival_time_offset_minutes'] ?? 0,
                    'departure_time_offset_minutes' => $intermediateStation['departure_time_offset_minutes'] ?? 0,
                    'platform_number' => $intermediateStation['platform_number'] ?? null,
                    'distance_from_start_km' => $intermediateStation['distance_from_start_km'] ?? 0,
                    'halt_duration_minutes' => $intermediateStation['halt_duration_minutes'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route updated successfully.');
    }

    /**
     * Remove the specified route from storage.
     */
    public function destroy(Route $route)
    {
        // Delete intermediate stations first
        $route->routeStations()->delete();
        
        // Delete the route
        $route->delete();

        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully.');
    }
}
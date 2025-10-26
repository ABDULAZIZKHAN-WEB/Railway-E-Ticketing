<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Display a listing of the stations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Station::query();
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('station_code', 'like', "%{$search}%")
                  ->orWhere('station_name', 'like', "%{$search}%")
                  ->orWhere('station_name_bn', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%");
            });
        }
        
        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $stations = $query->get();
        
        return view('admin.stations', compact('stations'));
    }

    /**
     * Show the form for creating a new station.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stations.create');
    }

    /**
     * Store a newly created station in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'station_code' => 'required|unique:stations',
            'station_name' => 'required',
            'division' => 'required',
            'district' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Handle facilities
        $facilities = [];
        if ($request->has('facilities')) {
            $facilities = $request->facilities;
        }

        $station = new Station($request->except('facilities'));
        $station->facilities_json = $facilities;
        $station->save();

        return redirect()->route('admin.stations')->with('success', 'Station created successfully.');
    }

    /**
     * Show the form for editing the specified station.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function edit(Station $station)
    {
        return view('admin.stations.edit', compact('station'));
    }

    /**
     * Update the specified station in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Station $station)
    {
        $request->validate([
            'station_code' => 'required|unique:stations,station_code,'.$station->id,
            'station_name' => 'required',
            'division' => 'required',
            'district' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Handle facilities
        $facilities = [];
        if ($request->has('facilities')) {
            $facilities = $request->facilities;
        }

        $station->update($request->except('facilities'));
        $station->facilities_json = $facilities;
        $station->save();

        return redirect()->route('admin.stations')->with('success', 'Station updated successfully.');
    }

    /**
     * Remove the specified station from storage.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function destroy(Station $station)
    {
        $station->delete();

        return redirect()->route('admin.stations')->with('success', 'Station deleted successfully.');
    }
    
    /**
     * Toggle the status of the specified station.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Station $station)
    {
        $station->status = $station->status === 'active' ? 'inactive' : 'active';
        $station->save();

        $action = $station->status === 'active' ? 'activated' : 'deactivated';
        return redirect()->route('admin.stations')->with('success', "Station {$action} successfully.");
    }
}
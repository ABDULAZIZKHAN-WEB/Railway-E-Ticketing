<?php

namespace App\Http\Controllers\StationMaster;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms = Platform::all();
        return view('station-master.platforms', compact('platforms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('station-master.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance,blocked',
            'type' => 'required|in:passenger,freight',
            'capacity' => 'required|integer|min:0',
            'current_train' => 'nullable|string|max:255',
            'next_arrival' => 'nullable|date',
            'last_maintenance' => 'nullable|date',
            'maintenance_notes' => 'nullable|string',
        ]);

        Platform::create($request->all());

        return redirect()->route('station-master.platforms')->with('success', 'Platform created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        return view('station-master.platforms.show', compact('platform'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        return view('station-master.platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance,blocked',
            'type' => 'required|in:passenger,freight',
            'capacity' => 'required|integer|min:0',
            'current_train' => 'nullable|string|max:255',
            'next_arrival' => 'nullable|date',
            'last_maintenance' => 'nullable|date',
            'maintenance_notes' => 'nullable|string',
        ]);

        $platform->update($request->all());

        return redirect()->route('station-master.platforms')->with('success', 'Platform updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('station-master.platforms')->with('success', 'Platform deleted successfully.');
    }

    /**
     * Update the status of a platform.
     */
    public function updateStatus(Request $request, Platform $platform)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,maintenance,blocked',
            'notes' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $request->status,
        ];

        // If notes are provided, update maintenance notes
        if ($request->filled('notes')) {
            $updateData['maintenance_notes'] = $request->notes;
        }

        // If changing to maintenance, update last maintenance timestamp
        if ($request->status === 'maintenance') {
            $updateData['last_maintenance'] = now();
        }

        $platform->update($updateData);

        return redirect()->back()->with('success', 'Platform status updated successfully.');
    }

    /**
     * Handle platform control panel form submission.
     */
    public function controlPanelUpdate(Request $request)
    {
        $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'status' => 'required|in:available,occupied,maintenance,blocked',
            'notes' => 'nullable|string',
        ]);

        $platform = Platform::findOrFail($request->platform_id);

        $updateData = [
            'status' => $request->status,
        ];

        // If notes are provided, update maintenance notes
        if ($request->filled('notes')) {
            $updateData['maintenance_notes'] = $request->notes;
        }

        // If changing to maintenance, update last maintenance timestamp
        if ($request->status === 'maintenance') {
            $updateData['last_maintenance'] = now();
        }

        $platform->update($updateData);

        return redirect()->route('station-master.platforms')->with('success', 'Platform status updated successfully.');
    }
}
<?php

namespace App\Http\Controllers\StationMaster;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('station-master.announcements', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('station-master.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'train_number' => 'nullable|string|max:50',
            'platform' => 'nullable|string|max:50',
            'message_en' => 'required|string',
            'message_bn' => 'nullable|string',
            'priority' => 'required|in:normal,high,emergency',
            'repeat_times' => 'required|integer|min:1|max:10',
            'repeat_interval' => 'required|integer|min:0|max:300',
        ]);

        $announcement = Announcement::create($request->all());

        return redirect()->route('station-master.announcements')->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return view('station-master.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        return view('station-master.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'train_number' => 'nullable|string|max:50',
            'platform' => 'nullable|string|max:50',
            'message_en' => 'required|string',
            'message_bn' => 'nullable|string',
            'priority' => 'required|in:normal,high,emergency',
            'repeat_times' => 'required|integer|min:1|max:10',
            'repeat_interval' => 'required|integer|min:0|max:300',
        ]);

        $announcement->update($request->all());

        return redirect()->route('station-master.announcements')->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('station-master.announcements')->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Publish an announcement.
     */
    public function publish(Announcement $announcement)
    {
        $announcement->update(['status' => 'published']);

        return redirect()->route('station-master.announcements')->with('success', 'Announcement published successfully.');
    }

    /**
     * Mark an announcement as completed.
     */
    public function complete(Announcement $announcement)
    {
        $announcement->update(['status' => 'completed']);

        return redirect()->route('station-master.announcements')->with('success', 'Announcement marked as completed.');
    }
}
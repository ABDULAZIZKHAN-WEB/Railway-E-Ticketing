<?php

namespace App\Http\Controllers\StationMaster;

use App\Http\Controllers\Controller;
use App\Models\TrainSchedule;
use App\Models\Train;
use Illuminate\Http\Request;

class DelaysController extends Controller
{
    /**
     * Display the delays management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get active train schedules for today
        $activeSchedules = TrainSchedule::with(['train', 'route'])
            ->where('status', 'active')
            ->whereDate('created_at', today())
            ->get();
        
        // Get current delays (schedules with delay_minutes > 0)
        $delays = TrainSchedule::with(['train', 'route'])
            ->where('delay_minutes', '>', 0)
            ->where('status', 'active')
            ->get();
        
        return view('station-master.delays', compact('activeSchedules', 'delays'));
    }

    /**
     * Store a newly reported delay.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'train_schedule_id' => 'required|exists:train_schedules,id',
            'delay_hours' => 'required|integer|min:0',
            'delay_minutes' => 'required|integer|min:0|max:59',
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        // Calculate total delay in minutes
        $totalDelayMinutes = ($request->delay_hours * 60) + $request->delay_minutes;

        // Update the train schedule with delay information
        $schedule = TrainSchedule::findOrFail($request->train_schedule_id);
        $schedule->update([
            'delay_minutes' => $totalDelayMinutes,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return redirect()->route('station-master.delays')->with('success', 'Delay reported successfully.');
    }

    /**
     * Update an existing delay.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainSchedule $schedule)
    {
        $request->validate([
            'delay_hours' => 'required|integer|min:0',
            'delay_minutes' => 'required|integer|min:0|max:59',
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        // Calculate total delay in minutes
        $totalDelayMinutes = ($request->delay_hours * 60) + $request->delay_minutes;

        // Update the train schedule with delay information
        $schedule->update([
            'delay_minutes' => $totalDelayMinutes,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return redirect()->route('station-master.delays')->with('success', 'Delay updated successfully.');
    }

    /**
     * Resolve a delay (set delay_minutes to 0).
     *
     * @param  \App\Models\TrainSchedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function resolve(TrainSchedule $schedule)
    {
        $schedule->update([
            'delay_minutes' => 0,
            'reason' => null,
            'details' => null,
        ]);

        return redirect()->route('station-master.delays')->with('success', 'Delay resolved successfully.');
    }
}
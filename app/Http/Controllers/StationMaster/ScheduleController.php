<?php

namespace App\Http\Controllers\StationMaster;

use App\Http\Controllers\Controller;
use App\Models\TrainSchedule;
use App\Models\Platform;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display the train schedule.
     */
    public function index()
    {
        // Get today's schedules
        $today = now()->format('w'); // 0 for Sunday, 6 for Saturday
        
        $schedules = TrainSchedule::with(['train', 'route.startStation', 'route.endStation', 'route.routeStations.station'])
            ->where('status', 'active')
            ->whereJsonContains('running_days_json', $today)
            ->where('effective_from', '<=', now())
            ->where(function($query) {
                $query->where('effective_to', '>=', now())
                      ->orWhereNull('effective_to');
            })
            ->orderBy('departure_time')
            ->get();

        return view('station-master.schedule', compact('schedules'));
    }

    /**
     * Display the delays page.
     */
    public function delays()
    {
        // Get delayed schedules
        $delays = TrainSchedule::with(['train', 'route.startStation', 'route.endStation'])
            ->where('status', 'delayed')
            ->where('delay_minutes', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
            
        // Get active schedules for the delay reporting form
        $today = now()->format('w'); // 0 for Sunday, 6 for Saturday
        $activeSchedules = TrainSchedule::with('train')
            ->where('status', 'active')
            ->whereJsonContains('running_days_json', $today)
            ->where('effective_from', '<=', now())
            ->where(function($query) {
                $query->where('effective_to', '>=', now())
                      ->orWhereNull('effective_to');
            })
            ->orderBy('departure_time')
            ->get();

        return view('station-master.delays', compact('delays', 'activeSchedules'));
    }

    /**
     * Update a train schedule.
     */
    public function update(Request $request, TrainSchedule $schedule)
    {
        $request->validate([
            'status' => 'required|in:on_time,delayed,cancelled',
            'delay_minutes' => 'nullable|integer|min:0|max:1440',
        ]);

        $schedule->update($request->only(['status', 'delay_minutes']));

        return redirect()->route('station-master.schedule')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Report a delay for a train.
     */
    public function reportDelay(Request $request, TrainSchedule $schedule)
    {
        $request->validate([
            'delay_minutes' => 'required|integer|min:1|max:1440',
        ]);

        $schedule->update([
            'status' => 'delayed',
            'delay_minutes' => $request->delay_minutes,
        ]);

        return redirect()->route('station-master.schedule')->with('success', 'Delay reported successfully.');
    }

    /**
     * Store a new delay report.
     */
    public function storeDelay(Request $request)
    {
        $request->validate([
            'train_schedule_id' => 'required|exists:train_schedules,id',
            'delay_hours' => 'required|integer|min:0|max:24',
            'delay_minutes' => 'required|integer|min:0|max:59',
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        $schedule = TrainSchedule::findOrFail($request->train_schedule_id);
        
        $totalDelayMinutes = ($request->delay_hours * 60) + $request->delay_minutes;

        $schedule->update([
            'status' => 'delayed',
            'delay_minutes' => $totalDelayMinutes,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return redirect()->route('station-master.delays')->with('success', 'Delay reported successfully.');
    }

    /**
     * Update an existing delay.
     */
    public function updateDelay(Request $request, TrainSchedule $schedule)
    {
        $request->validate([
            'delay_hours' => 'required|integer|min:0|max:24',
            'delay_minutes' => 'required|integer|min:0|max:59',
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        $totalDelayMinutes = ($request->delay_hours * 60) + $request->delay_minutes;

        $schedule->update([
            'delay_minutes' => $totalDelayMinutes,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return redirect()->route('station-master.delays')->with('success', 'Delay updated successfully.');
    }

    /**
     * Resolve a delay (mark as on time).
     */
    public function resolveDelay(TrainSchedule $schedule)
    {
        $schedule->update([
            'status' => 'on_time',
            'delay_minutes' => 0,
            'reason' => null,
            'details' => null,
        ]);

        return redirect()->route('station-master.delays')->with('success', 'Delay resolved successfully.');
    }
}
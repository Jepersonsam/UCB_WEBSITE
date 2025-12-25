<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditionSchedule;
use Illuminate\Http\Request;

class AuditionScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AuditionSchedule::query();

        // Only show active schedules for public access
        if (!$request->user()) {
            $query->where('is_active', true);
        }

        // Filter by upcoming or past
        if ($request->has('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('audition_date', '>=', now()->toDateString());
            } elseif ($request->filter === 'past') {
                $query->where('audition_date', '<', now()->toDateString());
            }
        }

        $schedules = $query->orderBy('audition_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return response()->json($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'audition_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $schedule = AuditionSchedule::create($validated);

        return response()->json($schedule, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = AuditionSchedule::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = AuditionSchedule::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'audition_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $schedule->update($validated);

        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = AuditionSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Jadwal audisi berhasil dihapus']);
    }
}

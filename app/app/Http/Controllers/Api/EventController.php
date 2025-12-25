<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->paginate(20);
        return response()->json($events);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_pattern' => 'nullable|string|max:255',
        ]);

        $event = Event::create($validated);
        
        return response()->json($event, 201);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_pattern' => 'nullable|string|max:255',
        ]);
        
        $event->update($validated);
        
        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        
        return response()->json(['message' => 'Event deleted successfully']);
    }
}

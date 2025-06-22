<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['club_id', 'event_name', 'description', 'date', 'time']);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->back()->with('success', 'Event added successfully!');
    }

   public function edit($id)
{
    $event = Event::findOrFail($id);
    return view('events.edit', compact('event'));
}


    public function update(Request $request, $id)
{
    $request->validate([
        'event_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'time' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $event = Event::findOrFail($id);

    // Handle new image upload if provided
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('event_images', 'public');
        $event->image_path = $imagePath;
    }

    $event->event_name = $request->event_name;
    $event->description = $request->description;
    $event->date = $request->date;
    $event->time = $request->time;
    $event->save();

    // ✅ Redirect to the club profile page with success message
    return redirect()->route('clubs.profile', ['id' => $event->club_id])
                     ->with('success', 'Event updated successfully!');
}

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Delete image if exists
        if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }
}

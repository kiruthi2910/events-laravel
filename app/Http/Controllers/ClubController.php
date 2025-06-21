<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\StudentCoordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::with('studentCoordinators')->get();
        return view('clubs.index', compact('clubs'));
    }

    public function create()
    {
        return view('clubs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'club_name' => 'required',
            'staff_coordinator_email' => 'required|email',
            'year_started' => 'required|integer',
            'staff_coordinator_photo' => 'nullable|image|max:5120',
            'logo' => 'nullable|image|max:5120',
            'student_photos.*' => 'nullable|image|max:5120',
        ]);

        $staffPhotoPath = $request->hasFile('staff_coordinator_photo')
            ? $request->file('staff_coordinator_photo')->store('staff_photos', 'public')
            : null;

        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('club_logos', 'public')
            : null;

        $club = Club::create([
            'club_name' => $request->club_name,
            'logo' => $logoPath,
            'introduction' => $request->introduction,
            'mission' => $request->mission,
            'staff_coordinator_name' => $request->staff_coordinator_name,
            'staff_coordinator_email' => $request->staff_coordinator_email,
            'staff_coordinator_photo' => $staffPhotoPath,
            'year_started' => $request->year_started,
        ]);

        $names = $request->student_names ?? [];
        $photos = $request->file('student_photos') ?? [];

        foreach ($names as $index => $name) {
            $photoPath = isset($photos[$index])
                ? $photos[$index]->store('student_photos', 'public')
                : null;

            StudentCoordinator::create([
                'club_id' => $club->id,
                'name' => $name,
                'photo' => $photoPath,
            ]);
        }

        return redirect()->route('clubs.index')->with('success', 'Club added successfully!');
    }

    public function edit($id)
    {
        $club = Club::with('studentCoordinators')->findOrFail($id);
        return view('clubs.edit', compact('club'));
    }

    public function update(Request $request, $id)
    {
        $club = Club::with('studentCoordinators')->findOrFail($id);

        $validated = $request->validate([
            'club_name' => 'required',
            'staff_coordinator_email' => 'required|email',
            'year_started' => 'required|integer',
            'staff_coordinator_photo' => 'nullable|image|max:5120',
            'logo' => 'nullable|image|max:5120',
            'student_names.*' => 'nullable|string',
            'student_photos.*' => 'nullable|image|max:5120',
            'student_ids.*' => 'nullable|integer',
        ]);

        $clubChanged = false;
        $fields = ['club_name', 'introduction', 'mission', 'staff_coordinator_name', 'staff_coordinator_email', 'year_started'];

        foreach ($fields as $field) {
            if ($request->$field !== $club->$field) {
                $club->$field = $request->$field;
                $clubChanged = true;
            }
        }

        if ($request->hasFile('staff_coordinator_photo')) {
            if ($club->staff_coordinator_photo) {
                Storage::disk('public')->delete($club->staff_coordinator_photo);
            }
            $club->staff_coordinator_photo = $request->file('staff_coordinator_photo')->store('staff_photos', 'public');
            $clubChanged = true;
        }

        if ($request->hasFile('logo')) {
            if ($club->logo) {
                Storage::disk('public')->delete($club->logo);
            }
            $club->logo = $request->file('logo')->store('club_logos', 'public');
            $clubChanged = true;
        }

        if ($clubChanged) {
            $club->save();
        }

        $ids = $request->student_ids ?? [];
        $names = $request->student_names ?? [];
        $photos = $request->file('student_photos') ?? [];

        foreach ($names as $i => $name) {
            $id = $ids[$i] ?? null;
            $photoFile = $photos[$i] ?? null;

            if ($id) {
                $student = StudentCoordinator::find($id);
                if ($student) {
                    $changed = false;

                    if ($student->name !== $name) {
                        $student->name = $name;
                        $changed = true;
                    }

                    if ($photoFile) {
                        if ($student->photo) {
                            Storage::disk('public')->delete($student->photo);
                        }
                        $student->photo = $photoFile->store('student_photos', 'public');
                        $changed = true;
                    }

                    if ($changed) {
                        $student->save();
                    }
                }
            } else {
                if ($name) {
                    $photoPath = $photoFile ? $photoFile->store('student_photos', 'public') : null;

                    StudentCoordinator::create([
                        'club_id' => $club->id,
                        'name' => $name,
                        'photo' => $photoPath,
                    ]);
                }
            }
        }

        return redirect()->route('clubs.index')->with('success', 'Club updated successfully!');
    }

    public function destroy($id)
    {
        $club = Club::findOrFail($id);

        if ($club->staff_coordinator_photo) {
            Storage::disk('public')->delete($club->staff_coordinator_photo);
        }

        if ($club->logo) {
            Storage::disk('public')->delete($club->logo);
        }

        $club->studentCoordinators()->delete();
        $club->delete();

        return redirect()->route('clubs.index')->with('success', 'Club deleted successfully!');
    }

    public function profile($id)
    {
        $club = Club::with('studentCoordinators')->findOrFail($id);
        return view('clubs.profile', compact('club'));
    }
}

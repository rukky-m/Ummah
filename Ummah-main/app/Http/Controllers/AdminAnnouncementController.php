<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        $totalAnnouncements = Announcement::count();
        $activeAnnouncements = Announcement::where('is_active', true)->count();
        
        return view('admin.announcements.index', compact('announcements', 'totalAnnouncements', 'activeAnnouncements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,meeting,program',
            'expires_at' => 'nullable|date|after:now',
        ]);

        Announcement::create($validated);

        return back()->with('success', 'Announcement broadcasted successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_active' => !$announcement->is_active]);
        return back()->with('success', 'Announcement status updated.');
    }
}

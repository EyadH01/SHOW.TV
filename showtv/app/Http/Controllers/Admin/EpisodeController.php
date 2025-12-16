<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpisodeController extends Controller
{
    /**
     * Display a listing of episodes.
     */
    public function index(Request $request)
    {
        $query = Episode::with('show');

        if ($request->has('show_id') && $request->show_id) {
            $query->where('show_id', $request->show_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $episodes = $query->orderBy('created_at', 'desc')->paginate(20);
        $shows = Show::orderBy('title')->get();

        return view('admin.episodes.index', compact('episodes', 'shows'));
    }

    /**
     * Show the form for creating a new episode.
     */
    public function create()
    {
        $shows = Show::orderBy('title')->get();
        return view('admin.episodes.create', compact('shows'));
    }

    /**
     * Store a newly created episode.
     */
    public function store(Request $request)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'airing_time' => 'nullable|date',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:512000',
            'youtube_video_id' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

    $data = $request->except('thumbnail', 'video_file');

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('episodes', 'public');
            $data['thumbnail'] = '/storage/' . $thumbnailPath;
        }

        // Handle uploaded local video file
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = '/storage/' . $videoPath;
        }

        Episode::create($data);

        return redirect()->route('admin.episodes.index')
                        ->with('success', 'تم إنشاء الحلقة بنجاح');
    }

    /**
     * Display the specified episode.
     */
    public function show(Episode $episode)
    {
        $episode->load('show');
        return view('admin.episodes.show', compact('episode'));
    }

    /**
     * Show the form for editing the episode.
     */
    public function edit(Episode $episode)
    {
        $shows = Show::orderBy('title')->get();
        return view('admin.episodes.edit', compact('episode', 'shows'));
    }

    /**
     * Update the specified episode.
     */
    public function update(Request $request, Episode $episode)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'airing_time' => 'nullable|date',
            'video_url' => 'nullable|url',
            'youtube_video_id' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists and is local
            if ($episode->thumbnail && str_starts_with($episode->thumbnail, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $episode->thumbnail);
                Storage::disk('public')->delete($oldPath);
            }

            $thumbnailPath = $request->file('thumbnail')->store('episodes', 'public');
            $data['thumbnail'] = '/storage/' . $thumbnailPath;
        }

        // Handle uploaded local video file on update
        if ($request->hasFile('video_file')) {
            // Delete old local video if present
            if ($episode->video_url && str_starts_with($episode->video_url, '/storage/')) {
                $oldVid = str_replace('/storage/', '', $episode->video_url);
                Storage::disk('public')->delete($oldVid);
            }

            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = '/storage/' . $videoPath;
        }

        $episode->update($data);

        return redirect()->route('admin.episodes.index')
                        ->with('success', 'تم تحديث الحلقة بنجاح');
    }

    /**
     * Remove the specified episode.
     */
    public function destroy(Episode $episode)
    {
        // Delete thumbnail if exists and is local
        if ($episode->thumbnail && str_starts_with($episode->thumbnail, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $episode->thumbnail);
            Storage::disk('public')->delete($oldPath);
        }

        $episode->delete();

        return redirect()->route('admin.episodes.index')
                        ->with('success', 'تم حذف الحلقة بنجاح');
    }
}

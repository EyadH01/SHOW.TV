<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::withCount('episodes')->paginate(12);
        return view('shows.index', compact('shows'));
    }

    public function show(Show $show)
    {
        $show->load('episodes');
        $isFollowing = false;
        if (auth()->check()) {
            $isFollowing = auth()->user()->followedShows()->where('show_id', $show->id)->exists();
        }
        return view('shows.show', compact('show', 'isFollowing'));
    }

    public function follow(Show $show)
    {
        auth()->user()->followedShows()->attach($show->id);
        return back()->with('success', 'تم متابعة المسلسل بنجاح!');
    }

    public function unfollow(Show $show)
    {
        auth()->user()->followedShows()->detach($show->id);
        return back()->with('success', 'تم إلغاء متابعة المسلسل!');
    }
}
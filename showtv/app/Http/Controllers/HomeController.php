<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Episode;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'search']]);
    }

    public function index()
    {
        // Show the 5 most recently created episodes across all shows (top latest)
        $latestEpisodes = Episode::with('show')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('latestEpisodes'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $shows = Show::where('title', 'LIKE', "%{$query}%")->get();
        $episodes = Episode::where('title', 'LIKE', "%{$query}%")->with('show')->get();
        return view('search', compact('shows', 'episodes', 'query'));
    }
}

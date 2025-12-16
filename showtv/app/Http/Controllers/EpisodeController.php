<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function show(Episode $episode)
    {
        $episode->load('show');
        $likeStatus = null;
        if (auth()->check()) {
            $like = auth()->user()->likedEpisodes()->where('episode_id', $episode->id)->first();
            if ($like) {
                $likeStatus = $like->pivot->type;
            }
        }
        return view('episodes.show', compact('episode', 'likeStatus'));
    }

    public function like(Episode $episode)
    {
        $user = auth()->user();
        $user->likedEpisodes()->syncWithoutDetaching([
            $episode->id => ['type' => 'like']
        ]);
        $episode->increment('likes');
        return back()->with('success', 'تم تقييم الحلقة!');
    }

    public function dislike(Episode $episode)
    {
        $user = auth()->user();
        $user->likedEpisodes()->syncWithoutDetaching([
            $episode->id => ['type' => 'dislike']
        ]);
        $episode->increment('dislikes');
        return back()->with('success', 'تم تقييم الحلقة!');
    }

    public function unlike(Episode $episode)
    {
        auth()->user()->likedEpisodes()->detach($episode->id);
        return back()->with('success', 'تم إزالة التقييم!');
    }
}
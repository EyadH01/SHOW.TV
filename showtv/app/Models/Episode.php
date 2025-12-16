<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    public $thumbnail;
    public $video_url;
    public $youtube_video_id;

    protected $fillable = [
        'show_id',
        'title',
        'description',
        'duration',
        'airing_time',
        'thumbnail',
        'video_url',
        'youtube_video_id',
        'likes',
        'dislikes',
    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function userLikes()
    {
        return $this->belongsToMany(User::class, 'episode_user_likes')
                    ->withPivot('type')
                    ->withTimestamps();
    }

    public function getLikeStatusByUser($userId)
    {
        $like = $this->userLikes()->where('user_id', $userId)->first();
        return $like ? $like->pivot->type : null;
    }


}

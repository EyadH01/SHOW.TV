<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'airing_time',
        'thumbnail',
        'wallpaper',
        'video_url',
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_show_follows');
    }

    public function isFollowedBy($userId)
    {
        return $this->followers()->where('user_id', $userId)->exists();
    }
}

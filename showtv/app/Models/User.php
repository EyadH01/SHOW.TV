<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followedShows()
    {
        return $this->belongsToMany(Show::class, 'user_show_follows');
    }

    public function likedEpisodes()
    {
        return $this->belongsToMany(Episode::class, 'episode_user_likes')
                    ->withPivot('type')
                    ->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}

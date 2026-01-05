<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $password
 * @property string|null $image
 */
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
        // Personal Information
        'phone',
        'bio',
        'date_of_birth',
        'gender',
        // Location Information
        'country',
        'city',
        'address',
        // Social Media and Website
        'website',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        // User Preferences and Settings
        'preferences',
        'language',
        'email_notifications',
        'sms_notifications',
        // Account Management
        'last_login_at',
        'email_verified_at',
        'is_active',
        'terms_accepted',
        'terms_accepted_at',
        // Account Security
        'login_attempts',
        'locked_until',
        'two_factor_secret',
        'two_factor_enabled',
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
        'date_of_birth' => 'date',
        'last_login_at' => 'datetime',
        'locked_until' => 'datetime',
        'terms_accepted_at' => 'datetime',
        'preferences' => 'array',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'is_active' => 'boolean',
        'terms_accepted' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'image' => null,
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


    /**
     * User has one user preference record
     */
    public function userPreference()
    {
        return $this->hasOne(\App\Models\UserPreference::class);
    }

    /**
     * User has many activity logs
     */
    public function activityLogs()
    {
        return $this->hasMany(\App\Models\UserActivityLog::class);
    }

    /**
     * User has many active sessions
     */
    public function sessions()
    {
        return $this->hasMany(\App\Models\UserSession::class);
    }

    /**
     * Check if user account is locked
     */
    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Get user's age from date of birth
     */
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }

        return $this->date_of_birth->age;
    }

    /**
     * Get user's full location
     */
    public function getFullLocationAttribute()
    {
        $location = [];
        
        if ($this->city) {
            $location[] = $this->city;
        }
        
        if ($this->country) {
            $location[] = $this->country;
        }
        
        return implode(', ', $location);
    }

    /**
     * Get social media links as array
     */
    public function getSocialLinksAttribute()
    {
        return [
            'facebook' => $this->facebook_url,
            'twitter' => $this->twitter_url,
            'instagram' => $this->instagram_url,
            'linkedin' => $this->linkedin_url,
            'youtube' => $this->youtube_url,
            'website' => $this->website,
        ];
    }

    /**
     * Check if user is online
     */
    public function isOnline()
    {
        return $this->sessions()
                    ->where('is_active', true)
                    ->where('last_activity', '>=', now()->subMinutes(5))
                    ->exists();
    }

    /**
     * Scope to get only active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get users by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get a usable avatar URL for the user.
     * Tries storage path, then public path, then returns fallback image.
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute()
    {
        // No image set -> fallback
        if (empty($this->image)) {
            return asset('images/show.jpeg');
        }

        // If the image is already a full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Check storage/app/public/<path>
        $storagePath = storage_path('app/public/' . $this->image);
        if (file_exists($storagePath)) {
            return asset('storage/' . $this->image);
        }

        // Check public/<path>
        $publicPath = public_path(ltrim($this->image, '/'));
        if (file_exists($publicPath)) {
            return asset(ltrim($this->image, '/'));
        }

        // Last resort: fallback image
        return asset('images/show.jpeg');
    }
}

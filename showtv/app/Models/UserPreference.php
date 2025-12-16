<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        // UI/UX Preferences
        'theme',
        'accent_color',
        'font_size',
        'compact_view',
        'show_welcome_tips',
        // Content Preferences
        'favorite_genres',
        'preferred_languages',
        'episodes_per_page',
        'video_quality',
        // Notification Preferences
        'new_episode_notifications',
        'weekly_digest',
        'marketing_emails',
        'account_updates',
        'security_alerts',
        // Privacy Preferences
        'profile_visibility',
        'show_activity',
        'allow_friend_requests',
        'show_online_status',
        // Playback Preferences
        'autoplay_next_episode',
        'autoplay_with_sound',
        'default_subtitle_language',
        'skip_intro',
        // Accessibility Preferences
        'high_contrast',
        'large_text',
        'reduced_motion',
        'screen_reader_mode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'favorite_genres' => 'array',
        'preferred_languages' => 'array',
        'compact_view' => 'boolean',
        'show_welcome_tips' => 'boolean',
        'new_episode_notifications' => 'boolean',
        'weekly_digest' => 'boolean',
        'marketing_emails' => 'boolean',
        'account_updates' => 'boolean',
        'security_alerts' => 'boolean',
        'profile_visibility' => 'boolean',
        'show_activity' => 'boolean',
        'allow_friend_requests' => 'boolean',
        'show_online_status' => 'boolean',
        'autoplay_next_episode' => 'boolean',
        'autoplay_with_sound' => 'boolean',
        'skip_intro' => 'boolean',
        'high_contrast' => 'boolean',
        'large_text' => 'boolean',
        'reduced_motion' => 'boolean',
        'screen_reader_mode' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'theme' => 'light',
        'accent_color' => 'blue',
        'font_size' => 'medium',
        'episodes_per_page' => 10,
        'video_quality' => 'auto',
    ];

    /**
     * User that owns these preferences
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

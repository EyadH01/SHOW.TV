<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\UserPreference;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Storage;

class HandleUserRegistration
{
    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;
        
        // Handle image upload if present
        if (request()->hasFile('image')) {
            try {
                $imagePath = request()->file('image')->store('profile-images', 'public');
                $user->update(['image' => $imagePath]);
            } catch (\Exception $e) {
                // Continue without image if upload fails
            }
        }

        // Set default user preferences
        $user->userPreference()->create([
            'theme' => 'light',
            'accent_color' => 'blue',
            'font_size' => 'medium',
            'episodes_per_page' => 10,
            'video_quality' => 'auto',
            'new_episode_notifications' => true,
            'weekly_digest' => true,
            'marketing_emails' => false,
            'account_updates' => true,
            'security_alerts' => true,
            'profile_visibility' => true,
            'show_activity' => true,
            'allow_friend_requests' => true,
            'show_online_status' => true,
            'autoplay_next_episode' => false,
            'autoplay_with_sound' => false,
            'skip_intro' => false,
            'high_contrast' => false,
            'large_text' => false,
            'reduced_motion' => false,
            'screen_reader_mode' => false,
        ]);

        // Log registration activity
        $user->activityLogs()->create([
            'activity_type' => 'registration',
            'description' => 'User registered successfully',
            'metadata' => ['status' => 'success'],
        ]);
    }
}

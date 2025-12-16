<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers as RegistersUsersTrait;
use Illuminate\Support\Facades\Hash as HashFacade;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use App\Models\UserSession as UserSessionModel;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsersTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return ValidatorFacade::make($data, [
            // Basic Information
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'in:user,admin'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            
            // Personal Information
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female,other,prefer_not_to_say'],
            
            // Location Information
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            
            // Social Media and Website
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            
            // Preferences
            'language' => ['nullable', 'string', 'size:2'],
            'email_notifications' => ['nullable', 'boolean'],
            'sms_notifications' => ['nullable', 'boolean'],
            'terms_accepted' => ['required', 'boolean', 'accepted'],
        ], [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 2 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'website.url' => 'Please enter a valid website URL.',
            'facebook_url.url' => 'Please enter a valid Facebook URL.',
            'twitter_url.url' => 'Please enter a valid Twitter URL.',
            'instagram_url.url' => 'Please enter a valid Instagram URL.',
            'linkedin_url.url' => 'Please enter a valid LinkedIn URL.',
            'youtube_url.url' => 'Please enter a valid YouTube URL.',
            'terms_accepted.accepted' => 'You must accept the terms and conditions.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Handle image upload
        $imagePath = null;
        if (request()->hasFile('image')) {
            $imagePath = request()->file('image')->store('profile-images', 'public');
        }

        // Create user with all enhanced fields
        $user = User::create([
            // Basic Information
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => HashFacade::make($data['password']),
            'role' => $data['role'] ?? 'user',
            'image' => $imagePath,
            
            // Personal Information
            'phone' => $data['phone'] ?? null,
            'bio' => $data['bio'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            
            // Location Information
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            
            // Social Media and Website
            'website' => $data['website'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'twitter_url' => $data['twitter_url'] ?? null,
            'instagram_url' => $data['instagram_url'] ?? null,
            'linkedin_url' => $data['linkedin_url'] ?? null,
            'youtube_url' => $data['youtube_url'] ?? null,
            
            // User Preferences and Settings
            'preferences' => $this->getDefaultPreferences(),
            'language' => $data['language'] ?? 'en',
            'email_notifications' => $data['email_notifications'] ?? true,
            'sms_notifications' => $data['sms_notifications'] ?? false,
            
            // Account Management
            'email_verified_at' => now(),
            'is_active' => true,
            'terms_accepted' => true,
            'terms_accepted_at' => now(),
            
            // Account Security
            'login_attempts' => 0,
            'two_factor_enabled' => false,
        ]);

        // Create default user preferences
        if ($user) {
            \App\Models\UserPreference::create([
                'user_id' => $user->id,
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
            \App\Models\UserActivityLog::logActivity(
                $user->id,
                'registration',
                'User registered successfully',
                ['status' => 'success']
            );

            // Create user session
            UserSessionModel::createSession($user->id);
        }

        return $user;
    }

    /**
     * Get default user preferences
     */
    private function getDefaultPreferences()
    {
        return [
            'theme' => 'light',
            'language' => 'en',
            'notifications' => [
                'email' => true,
                'sms' => false,
            ],
            'privacy' => [
                'profile_visibility' => 'public',
                'show_activity' => true,
            ],
        ];
    }
}

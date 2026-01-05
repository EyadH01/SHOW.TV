<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show user dashboard
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get user statistics
        $stats = [
            'total_shows' => \App\Models\Show::count(),
            'total_episodes' => \App\Models\Episode::count(),
            'follows' => $user->followedShows()->count(),
            'likes' => $user->likedEpisodes()->count(),
        ];

        // Calculate profile completion
        $profileCompletion = $this->calculateProfileCompletion($user);

        // Get recent activities
        $recentActivities = \App\Models\UserActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get active sessions
        $activeSessions = \App\Models\UserSession::where('user_id', $user->id)
            ->where('last_activity', '>', now()->subMinutes(30))
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) use ($user) {
                $session->is_current = $session->id === session('user_session_id');
                return $session;
            });

        return view('profile.dashboard', compact('user', 'stats', 'profileCompletion', 'recentActivities', 'activeSessions'));
    }

    // Show user profile
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    // Edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }


    // Update profile with enhanced fields
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $imageService = new ImageService();

        // Enhanced validation rules
        $data = $request->validate([
            // Basic Information
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'email', 'max:255'],
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
            
            // User Preferences and Settings
            'language' => ['nullable', 'string', 'size:2'],
            'email_notifications' => ['nullable', 'boolean'],
            'sms_notifications' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 2 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'website.url' => 'Please enter a valid website URL.',
            'facebook_url.url' => 'Please enter a valid Facebook URL.',
            'twitter_url.url' => 'Please enter a valid Twitter URL.',
            'instagram_url.url' => 'Please enter a valid Instagram URL.',
            'linkedin_url.url' => 'Please enter a valid LinkedIn URL.',
            'youtube_url.url' => 'Please enter a valid YouTube URL.',
        ]);

        // Handle image upload with ImageService
        if ($request->hasFile('image')) {
            try {
                // Delete old image if exists
                if ($user->image) {
                    $imageService->deleteProfileImage($user->image);
                }
                
                // Process and store new image
                $imagePath = $imageService->storeProfileImage($request->file('image'), $user->id);
                $data['image'] = $imagePath;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Failed to process image: ' . $e->getMessage()]);
            }
        }

        // Update user profile
        $user->update($data);

        // Log profile update activity
        \App\Models\UserActivityLog::logActivity(
            $user->id,
            'profile_update',
            'User updated profile information',
            ['status' => 'success']
        );

        // Refresh the authenticated user session with updated data
        Auth::setUser($user);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }


    // Delete user account
    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $imageService = new ImageService();

        // Validate password confirmation
        $request->validate([
            'password' => ['required', 'string']
        ]);

        if (!Hash::check($request->password, $user->getAuthPassword())) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        // Delete user profile image and thumbnails
        if ($user->image) {
            $imageService->deleteProfileImage($user->image);
        }

        // Log account deletion activity
        \App\Models\UserActivityLog::logActivity(
            $user->id,
            'account_deletion',
            'User deleted account',
            ['status' => 'success']
        );

        // End all user sessions
        \App\Models\UserSession::terminateOtherSessions($user->id);

        // Delete user
        $user->delete();

        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()->route('welcome')->with('success', 'Your account has been deleted successfully.');
    }

    // Show settings form
    public function settings()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    // Update settings
    public function updateSettings(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'profile_public' => 'nullable|boolean',
            'show_email' => 'nullable|boolean',
            'show_phone' => 'nullable|boolean',
            'show_location' => 'nullable|boolean',
            'show_social_media' => 'nullable|boolean',
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean',
            'login_alerts' => 'nullable|boolean',
            'security_alerts' => 'nullable|boolean',
            'marketing_emails' => 'nullable|boolean',
            'two_factor_enabled' => 'nullable|boolean',
            'session_timeout' => 'nullable|integer|min:30|max:480',
            'notify_new_devices' => 'nullable|boolean',
        ]);

        // Update user preferences
        $preferences = $user->userPreference;
        if (!$preferences) {
            $preferences = new \App\Models\UserPreference();
            $preferences->user_id = $user->id;
        }
        $preferences->fill($data);
        $preferences->save();

        // Update user two_factor_enabled
        $user->update(['two_factor_enabled' => $data['two_factor_enabled'] ?? false]);

        return redirect()->route('profile.settings')->with('status', 'Settings updated successfully!');
    }

    // Show sessions
    public function sessions()
    {
        $user = Auth::user();
        $sessions = \App\Models\UserSession::where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) use ($user) {
                $session->is_current = $session->id === session('user_session_id');
                return $session;
            });

        return view('profile.sessions', compact('user', 'sessions'));
    }

    // Destroy session
    public function destroySession(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = \App\Models\UserSession::where('user_id', $user->id)
            ->where('id', $sessionId)
            ->first();

        if ($session && !$session->is_current) {
            $session->delete();
        }

        return redirect()->route('profile.sessions')->with('status', 'Session ended successfully!');
    }

    // Show activity log
    public function activity()
    {
        $user = Auth::user();
        $activities = \App\Models\UserActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('profile.activity', compact('user', 'activities'));
    }

    // Export user data
    public function export(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = [
            'user' => $user->toArray(),
            'preferences' => $user->userPreference,
            'activities' => $user->activityLogs()->orderBy('created_at', 'desc')->get(),
            'sessions' => $user->sessions()->orderBy('last_activity', 'desc')->get(),
            'followed_shows' => $user->followedShows,
            'liked_episodes' => $user->likedEpisodes,
        ];

        $filename = 'user-data-' . $user->id . '-' . now()->format('Y-m-d') . '.json';

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    // Calculate profile completion percentage
    private function calculateProfileCompletion($user)
    {
        $fields = [
            'name', 'email', 'phone', 'bio', 'date_of_birth', 'gender',
            'country', 'city', 'address', 'website', 'facebook_url',
            'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url'
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $completed++;
            }
        }

        return round(($completed / count($fields)) * 100);
    }
}

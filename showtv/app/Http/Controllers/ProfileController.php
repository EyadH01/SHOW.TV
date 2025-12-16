<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            
            // Store new image
            $path = $request->file('image')->store('profile-images', 'public');
            $data['image'] = $path;
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

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    // Delete user account
    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validate password confirmation
        $request->validate([
            'password' => ['required', 'string']
        ]);

        if (!Hash::check($request->password, $user->getAuthPassword())) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        // Delete user profile image
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
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

        return redirect()->route('welcome')->with('status', 'Your account has been deleted successfully.');
    }
}

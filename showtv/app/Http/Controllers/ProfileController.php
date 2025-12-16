<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show user profile (simple view)
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

    // Update profile (name, email, profile_image)
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('status', __('messages.profile_updated'));
    }
}

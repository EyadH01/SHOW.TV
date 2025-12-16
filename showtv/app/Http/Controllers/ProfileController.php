<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            
            // Store new image
            $path = $request->file('image')->store('profile-images', 'public');
            $data['image'] = $path;
        }

        $user->fill($data)->save();

        return redirect()->route('profile.show')->with('status', __('messages.profile_updated'));
    }
}

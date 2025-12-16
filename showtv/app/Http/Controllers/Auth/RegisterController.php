<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Models\UserSession;
use App\Services\ImageService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Image service instance.
     *
     * @var \App\Services\ImageService
     */
    protected $imageService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\ImageService $imageService
     * @return void
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
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
        // Handle image upload using injected ImageService if file provided
        $imagePath = null;

        if (!empty($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            try {
                $imagePath = $this->imageService->storeProfileImage($data['image']);
            } catch (\Exception $e) {
                Log::error('Image upload failed during registration: ' . $e->getMessage());
                $imagePath = null;
            }
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => $imagePath,
            'role' => $data['role'] ?? 'user',
            'email_verified_at' => now(),
            'is_active' => true,
            'terms_accepted' => $data['terms_accepted'] ?? true,
            'terms_accepted_at' => now(),
            'login_attempts' => 0,
            'two_factor_enabled' => false,
        ]);

        if ($user) {
            // Create a minimal default preferences object if model exists
            if (class_exists(\App\Models\UserPreference::class)) {
                try {
                    \App\Models\UserPreference::create([
                        'user_id' => $user->id,
                        'theme' => 'light',
                        'language' => 'en',
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Could not create user preferences: ' . $e->getMessage());
                }
            }

            // Log registration activity
            try {
                UserActivityLog::logActivity(
                    $user->id,
                    'registration',
                    'User registered successfully',
                    ['status' => 'success']
                );
            } catch (\Exception $e) {
                Log::warning('Could not log registration activity: ' . $e->getMessage());
            }

            // Create user session record (best-effort)
            try {
                if (method_exists(UserSession::class, 'createSession')) {
                    UserSession::createSession($user->id);
                }
            } catch (\Exception $e) {
                Log::warning('Could not create user session: ' . $e->getMessage());
            }
        }

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // User is automatically logged in by the RegistersUsers trait.
        // This method is called after successful registration.
    }
}


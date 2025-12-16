<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Enhanced validation for login
        $this->validateLogin($request);

        // Check if user is active
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user || !$user->is_active) {
            // Log failed login attempt
            if ($user) {
                $this->logLoginAttempt($user->id, $request, false, 'Account is inactive');
            }
            
            return $this->sendFailedLoginResponse($request);
        }

        // Check if account is locked
        if ($user->isLocked()) {
            // Log failed login attempt
            $this->logLoginAttempt($user->id, $request, false, 'Account is locked');
            
            return $this->sendLockoutResponse($request);
        }

        // Check if the rate limit has been exceeded
        if ($this->hasTooManyLoginAttempts($request)) {
            // Log failed login attempt
            $this->logLoginAttempt($user ? $user->id : 0, $request, false, 'Too many login attempts');
            
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            // Login successful
            if ($user) {
                // Update login attempts
                $user->resetLoginAttempts();
                
                // Log successful login
                $this->logLoginAttempt($user->id, $request, true, 'Login successful');
                
                // Create user session
                $this->createUserSession($user);
                
                // Update last login timestamp
                $user->update([
                    'last_login_at' => now(),
                ]);
                
                // Update last activity
                $user->touch();
            }

            $request->session()->regenerate();
            
            // Clear any existing login attempts
            $this->clearLoginAttempts($request);

            return $this->sendLoginResponse($request);
        }

        // Increment login attempts
        $this->incrementLoginAttempts($request);
        
        // Log failed login attempt
        if ($user) {
            $this->logLoginAttempt($user->id, $request, false, 'Invalid credentials');
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Log login attempt
     */
    protected function logLoginAttempt($userId, Request $request, $success, $reason = null)
    {
        \App\Models\UserActivityLog::logActivity(
            $userId,
            'login',
            $success ? 'User logged in successfully' : 'Failed login attempt',
            [
                'status' => $success ? 'success' : 'failed',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'reason' => $reason,
            ]
        );
    }

    /**
     * Create user session
     */
    protected function createUserSession($user)
    {
        // Clean up old sessions
        \App\Models\UserSession::cleanupOldSessions($user->id);
        
        // Create new session
        \App\Models\UserSession::createSession($user->id);
    }

    /**
     * Send the response after a successful authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Send the response after a failed authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn($this->throttleKey($request));

        $errors = [$this->username() => ['Too many login attempts. Please try again in ' . $seconds . ' seconds.']];

        if ($request->expectsJson()) {
            return response()->json($errors, 429);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the path to redirect to.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Log successful authentication
        \App\Models\UserActivityLog::logActivity(
            $user->id,
            'authentication',
            'User authenticated successfully',
            ['status' => 'success']
        );
        
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            // End current session
            \App\Models\UserSession::where('session_id', $request->session()->getId())
                ->where('user_id', $user->id)
                ->update([
                    'is_active' => false,
                    'logout_time' => now(),
                    'status' => 'logged_out',
                ]);

            // Log logout activity
            \App\Models\UserActivityLog::logActivity(
                $user->id,
                'logout',
                'User logged out',
                ['status' => 'success']
            );
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? response()->json([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // Additional logout logic can be added here
    }
}

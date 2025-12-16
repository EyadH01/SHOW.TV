<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'device_name',
        'device_type',
        'browser_name',
        'os_name',
        'browser_version',
        'ip_address',
        'country',
        'city',
        'timezone',
        'user_agent',
        'login_time',
        'last_activity',
        'logout_time',
        'is_active',
        'remember_token',
        'fingerprint',
        'status',
        'security_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'login_time' => 'datetime',
        'last_activity' => 'datetime',
        'logout_time' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * User that owns this session
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', 'active');
    }

    /**
     * Scope to get sessions by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get recent sessions
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('login_time', '>=', now()->subDays($days));
    }

    /**
     * Check if session is expired
     */
    public function isExpired()
    {
        return $this->last_activity->lt(now()->subHours(24));
    }

    /**
     * Check if session is currently active
     */
    public function isCurrentlyActive()
    {
        return $this->is_active && !$this->isExpired() && $this->status === 'active';
    }

    /**
     * End this session
     */
    public function endSession()
    {
        $this->update([
            'is_active' => false,
            'logout_time' => now(),
            'status' => 'logged_out',
        ]);
    }

    /**
     * Update last activity
     */
    public function updateActivity()
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Create a new session
     */
    public static function createSession($userId, $options = [])
    {
        $sessionId = $options['session_id'] ?? session()->getId();
        
        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'device_name' => $options['device_name'] ?? null,
            'device_type' => $options['device_type'] ?? self::detectDeviceType(request()->userAgent()),
            'browser_name' => $options['browser_name'] ?? self::detectBrowser(request()->userAgent()),
            'os_name' => $options['os_name'] ?? self::detectOS(request()->userAgent()),
            'browser_version' => $options['browser_version'] ?? null,
            'ip_address' => request()->ip(),
            'country' => $options['country'] ?? null,
            'city' => $options['city'] ?? null,
            'timezone' => $options['timezone'] ?? config('app.timezone'),
            'user_agent' => request()->userAgent(),
            'login_time' => now(),
            'last_activity' => now(),
            'is_active' => true,
            'remember_token' => $options['remember_token'] ?? null,
            'fingerprint' => $options['fingerprint'] ?? self::generateFingerprint(),
            'status' => 'active',
        ]);
    }

    /**
     * Clean up old sessions for a user
     */
    public static function cleanupOldSessions($userId, $keepActive = true)
    {
        $query = self::where('user_id', $userId)->where('is_active', false);
        
        if ($keepActive) {
            $query->orWhere(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('is_active', true)
                  ->where('last_activity', '<', now()->subDays(30));
            });
        }
        
        $query->delete();
    }

    /**
     * Detect device type from user agent
     */
    private static function detectDeviceType($userAgent)
    {
        if (preg_match('/Mobile|Android|iPhone/', $userAgent)) {
            return preg_match('/iPad/', $userAgent) ? 'tablet' : 'mobile';
        }
        return 'desktop';
    }

    /**
     * Detect browser name from user agent
     */
    private static function detectBrowser($userAgent)
    {
        if (preg_match('/Chrome/', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/Firefox/', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/Safari/', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Edge/', $userAgent)) {
            return 'Edge';
        }
        return 'Unknown';
    }

    /**
     * Detect operating system from user agent
     */
    private static function detectOS($userAgent)
    {
        if (preg_match('/Windows/', $userAgent)) {
            return 'Windows';
        } elseif (preg_match('/Mac/', $userAgent)) {
            return 'macOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/Android/', $userAgent)) {
            return 'Android';
        } elseif (preg_match('/iOS|iPhone|iPad/', $userAgent)) {
            return 'iOS';
        }
        return 'Unknown';
    }

    /**
     * Generate device fingerprint
     */
    private static function generateFingerprint()
    {
        return hash('sha256', request()->userAgent() . request()->ip());
    }

    /**
     * Get active session count for user
     */
    public static function getActiveSessionCount($userId)
    {
        return self::where('user_id', $userId)
                  ->where('is_active', true)
                  ->where('last_activity', '>=', now()->subHours(24))
                  ->count();
    }

    /**
     * Terminate all sessions for a user except current
     */
    public static function terminateOtherSessions($userId, $currentSessionId = null)
    {
        $query = self::where('user_id', $userId)->where('is_active', true);
        
        if ($currentSessionId) {
            $query->where('session_id', '!=', $currentSessionId);
        }
        
        $query->update([
            'is_active' => false,
            'logout_time' => now(),
            'status' => 'terminated',
        ]);
    }
}

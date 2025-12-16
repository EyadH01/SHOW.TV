<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'activity_type',
        'action',
        'resource_type',
        'resource_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser_name',
        'os_name',
        'country',
        'city',
        'metadata',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * User that performed this activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get logs by activity type
     */
    public function scopeByActivityType($query, $activityType)
    {
        return $query->where('activity_type', $activityType);
    }

    /**
     * Scope to get logs by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get successful activities
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope to get failed activities
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope to get activities from last 24 hours
     */
    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    /**
     * Log user activity
     */
    public static function logActivity($userId, $activityType, $action, $options = [])
    {
        return self::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => self::detectDeviceType(request()->userAgent()),
            'browser_name' => self::detectBrowser(request()->userAgent()),
            'os_name' => self::detectOS(request()->userAgent()),
            'status' => $options['status'] ?? 'success',
            'description' => $options['description'] ?? null,
            'resource_type' => $options['resource_type'] ?? null,
            'resource_id' => $options['resource_id'] ?? null,
            'metadata' => $options['metadata'] ?? null,
        ]);
    }

    /**
     * Detect device type from user agent
     */
    private static function detectDeviceType($userAgent)
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
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
}

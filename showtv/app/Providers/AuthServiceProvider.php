<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define admin access gate
        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });

        // Define moderator access gate
        Gate::define('moderator-access', function ($user) {
            return in_array($user->role, ['admin', 'moderator']);
        });

        // Define user access gate
        Gate::define('user-access', function ($user) {
            return in_array($user->role, ['admin', 'moderator', 'user']);
        });
    }
}

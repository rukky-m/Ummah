<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Role-Based Access Control Gates
        Gate::define('manage-members', function ($user) {
            return $user->canManageMembers();
        });

        Gate::define('manage-announcements', function ($user) {
            return $user->canManageAnnouncements();
        });

        Gate::define('view-cashbook', function ($user) {
            return $user->canViewCashbook();
        });

        Gate::define('manage-savings', function ($user) {
            return $user->canManageSavings();
        });

        Gate::define('manage-repayments', function ($user) {
            return $user->canManageRepayments();
        });

        Gate::define('manage-contributions', function ($user) {
            return $user->canManageContributions();
        });

        Gate::define('manage-loans', function ($user) {
            return $user->canManageLoans();
        });

        // --- Rate Limiters ---
        
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('registration', function (Request $request) {
            return Limit::perHour(10)->by($request->ip());
        });

        RateLimiter::for('support', function (Request $request) {
            return Limit::perHour(5)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

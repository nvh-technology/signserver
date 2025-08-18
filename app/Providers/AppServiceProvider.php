<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Define a gate for admin access
        Gate::define('isAdmin', function ($user) {
            return $user->email === 'admin@example.com'; // Replace with your actual admin check
        });
    }
}

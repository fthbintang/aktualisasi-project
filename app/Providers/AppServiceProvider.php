<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('Admin', function ($user) {
            return $user->role === 'Admin';
        });
        
        Gate::define('Staff Kepaniteraan Hukum', function ($user) {
            return $user->role === 'Staff Kepaniteraan Hukum';
        });

        Gate::define('Staff Kepaniteraan Pidana', function ($user) {
            return $user->role === 'Staff Kepaniteraan Pidana';
        });

        Gate::define('Staff Kepaniteraan Perdata', function ($user) {
            return $user->role === 'Staff Kepaniteraan Perdata';
        });

        Gate::define('Panitera', function ($user) {
            return $user->role === 'Panitera';
        });

        Gate::define('Ketua PN', function ($user) {
            return $user->role === 'Ketua PN';
        });

        Carbon::setLocale('id');
    }
}
<?php

namespace App\Providers;

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
        Gate::define('Kepaniteraan Hukum', function ($user) {
            return $user->role === 'Kepaniteraan Hukum';
        });

        Gate::define('Kepaniteraan Pidana', function ($user) {
            return $user->role === 'Kepaniteraan Pidana';
        });

        Gate::define('Kepaniteraan Perdata', function ($user) {
            return $user->role === 'Kepaniteraan Perdata';
        });

        Gate::define('Panitera', function ($user) {
            return $user->role === 'Panitera';
        });

        Gate::define('Ketua PN', function ($user) {
            return $user->role === 'Ketua PN';
        });
    }
}
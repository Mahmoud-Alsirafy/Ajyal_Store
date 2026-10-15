<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->super_admin || $user->type == 'super admin') {
                return true;
            }
            return false;
        });
        foreach (config('abilities') as $ability_code => $ability_name) {
            Gate::define($ability_code, function ($user) use ($ability_code) {
                return $user->hasAbility($ability_code);
            });
        }
    }
}
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
        Gate::define('category.view', fn($user) => true);
        Gate::define('category.create', fn($user) => true);
        Gate::define('category.update', fn($user) => false);
        Gate::define('category.delete', fn($user) => false);
    }
}

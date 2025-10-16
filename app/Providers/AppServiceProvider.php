<?php

namespace App\Providers;

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
        // Force HTTPS for all asset URLs in production
        if (app()->environment('production')) {
            \URL::forceScheme('https');
            
            // Force HTTPS for all asset URLs
            \Illuminate\Support\Facades\Asset::macro('secure', function ($path) {
                return 'https://carbonwallet-admin-xprl.onrender.com' . $path;
            });
        }
    }
}

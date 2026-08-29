<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\Inflector\InflectorFactory;
use App\Services\RealTimeNotificationService;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RealTimeNotificationService::class, function($app){ 
            return new RealTimeNotificationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for ngrok URLs to prevent Mixed Content errors in JavaScript fetch requests
        if (str_contains(config('app.url'), 'ngrok-free.dev') || env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
        
        // Load broadcasting routes
    }
}

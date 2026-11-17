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
        // Share global settings ke seluruh views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = app(\App\Services\StoreSettingService::class)->getAllSettings();
            $view->with('globalSettings', $settings);
        });
    }
}

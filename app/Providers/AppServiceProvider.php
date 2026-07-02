<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        /*URL::forceScheme('https');*/

        \Illuminate\Support\Facades\View::composer('layouts.navigation', function ($view) {
            $unreadCount = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $unreadCount = \Illuminate\Support\Facades\Auth::user()->unreadNotifications->count();
            }
            $view->with('unreadCount', $unreadCount);
        });
    }
}

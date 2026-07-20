<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\MergeGuestDataOnLogin;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        if (config('app.env') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        
        Event::listen(Login::class, [MergeGuestDataOnLogin::class, 'handle']);

        \Illuminate\Support\Facades\View::composer('layouts.navigation', function ($view) {
            $unreadCount = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $unreadCount = \Illuminate\Support\Facades\Auth::user()->unreadNotifications->count();
            }
            $view->with('unreadCount', $unreadCount);
        });
    }
}


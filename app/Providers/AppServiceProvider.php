<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Notification;

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
        View::composer('layouts.app', function ($view) {
            if (Schema::hasTable('notifications')) {
                $notificationsList = Notification::latest()->take(10)->get();
                $unreadNotificationsCount = Notification::where('is_read', false)->count();
            } else {
                $notificationsList = collect([]);
                $unreadNotificationsCount = 0;
            }

            $view->with('notificationsList', $notificationsList)
                 ->with('unreadNotificationsCount', $unreadNotificationsCount);
        });
    }
}

<?php

namespace App\Providers;

use App\Models\Advertising;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Observers\AdvertisingObserver;
use App\Observers\MenuItemObserver;
use App\Observers\SettingObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    protected $observers = [
        Setting::class => [SettingObserver::class],
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Setting::observe(SettingObserver::class);
    }
}

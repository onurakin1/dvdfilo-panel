<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
    public function __construct()
    {
    }

    /**
     * Handle the Setting "created" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function created(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "updated" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function updated(Setting $setting)
    {
       

    }

    /**
     * Handle the Setting "deleted" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "restored" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function restored(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "force deleted" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function forceDeleted(Setting $setting)
    {
        //
    }
}

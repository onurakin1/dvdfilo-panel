<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Spatie\Activitylog\Models\Activity;
use Laravel\Dusk\Browser;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Request::macro('hasAdmin', function () {
            return request()->is(['dvdfilo', 'dvdfilo/*']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws Exception
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //Activity Log
        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('agent', [
                'ip' => request()->ip(),
                'browser' => getBrowser(request()->userAgent()),
                'os' => getOs(request()->userAgent()),
                'url' => request()->fullUrl(),
            ]);
        });


        // Config
        if (Schema::hasTable('settings')) {
            $caches = cache()->rememberForever('settings', function () {

                return [
                    'settings' => Setting::all(),
                ];
            });

            foreach ($caches['settings'] as $setting) {
                Config::set('settings.' . $setting->group . '.' . $setting->key, $setting->value);
            }
        }

        if (Schema::hasTable('branches')) {
            $caches = cache()->rememberForever('branches', function () {
                return Branch::select('id', 'name')->where('status', 1)->get()->toArray();
            });
        }
    }
}

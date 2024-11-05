<?php

namespace App\Http\Middleware;

use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected  $rootView = 'backend.admin';


    public function rootView(Request $request): string
    {
        return request()->hasAdmin() ? 'backend.admin' : 'backend.guest';
    }


    /**
     * Define the props that are shared by default.
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'settings' => collect(Setting::all())->keyBy('key'),
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
                'image' => session('image'),
            ],
            'language' => function () {
                return translations(
                    resource_path('lang/' . app()->getLocale() . '.json')
                );
            },
            'branches' => cache('branches'),

        ]);
    }
}

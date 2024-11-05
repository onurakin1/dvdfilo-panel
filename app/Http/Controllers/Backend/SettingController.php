<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Http\Requests\Setting\SettingIndexRequest;
use App\Repositories\Eloquent\Interfaces\SettingRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    private SettingRepositoryInterface $settingRepository;


    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index(SettingIndexRequest $request)
    {
        $general = $this->settingRepository->getForGroup('general');

        return Inertia::render('Admin/Setting/Index', [
            'general' => $general,
        ]);
    }

    public function update(SettingUpdateRequest $request)
    {

        $this->settingRepository->updateKeyValue($request->toArray());

        cache()->forget('settings_caches');

        session()->flash('success', 'Bilgiler başarıyla güncellendi.');

        return redirect()->back();
    }

}

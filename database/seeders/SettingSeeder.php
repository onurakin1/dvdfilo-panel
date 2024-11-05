<?php

namespace Database\Seeders;

use App\Repositories\Eloquent\Interfaces\SettingRepositoryInterface;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{

    public function __construct(private SettingRepositoryInterface $settingRepository)
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $general = [
            ["group" => 'general', 'name' => "Panel Logo", 'key' => "site_logo", "value" => "/backend/media/logos/logo.png"],
            ["group" => 'general', 'name' => 'Favicon Logo', 'key' => "site_favicon", "value" => "/backend/media/logos/logo.png"],
        ];


        $data = array_merge($general);

        $this->settingRepository->saveMany($data);

    }
}

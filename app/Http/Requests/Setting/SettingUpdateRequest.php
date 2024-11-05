<?php

namespace App\Http\Requests\Setting;

use App\Repositories\Eloquent\Interfaces\SettingRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    private SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        parent::__construct();
        $this->settingRepository = $settingRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', [auth()->user(), $this->settingRepository->getModelClass()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $settings = $this->settingRepository->get();
        
       
        foreach ($settings as $setting) {
             
            if (request()->input($setting->key)) {
                
                $data[$setting->key] = $setting->rules;
               
            } 
            
            if (request()->input($setting->key) == 'frontend') {
                
                $data[$setting->key.'.0'] = 'required';

            }
            if (request()->input($setting->key) == 'backend') {

                $data[$setting->key.'.0'] = 'required';

            } 
        }
        return $data;
    }
}
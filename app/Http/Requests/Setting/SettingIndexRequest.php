<?php

namespace App\Http\Requests\Setting;

use App\Repositories\Eloquent\Interfaces\SettingRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class SettingIndexRequest extends FormRequest
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
        return auth()->user()->can('viewAny', $this->settingRepository->getModelClass());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}

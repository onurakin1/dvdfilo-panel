<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\Eloquent\Interfaces\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $group_name
     * @return Collection
     */
    public function getForGroup(string $group_name): Collection
    {
        return $this->model::query()->where('group', $group_name)->get();
    }

    public function updateKeyValue(array $attributes): bool
    {
        foreach ($attributes as $key => $value) {

            $row = $this->model::query()->where('key', $key)->first();
            if ($row->type === 'image' && $key === $row->key) {
                if ($value !== null && !is_string($value)) {
                    $row->updateLogo($value);
                }
            } else {

                $new_value =  $value;
                if(is_array($value)){
                   $new_value = [];
                    foreach($value as $val){
                           $new_value[] = ['id'=>$val['id'],'name'=>$val['name']];     
                   }     
                }
                
                $this->model::query()->where('key', $key)->update(['value' => $new_value]);

            }

        }

        return true;
    }

}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends = ['full_path', 'resolution_info','resolution_original','imagex_modal_image'];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromDate($this->attributes['created_at'])->translatedFormat('d F Y');
    }

    public function getFullPathAttribute()
    {
        return url($this->attributes['path']);
    }

    public function getImagexModalImageAttribute()
    {
        return  imagex($this->attributes['path'],['w'=>"120",'auto'=>'format'],false);
    }

    public function getResolutionInfoAttribute()
    {
        if ($this->attributes['resolution'] !== 'video') {
            $explode = explode('x', $this->attributes['resolution']);
            if (isset($explode[0]) && isset($explode[1])) {
                return [
                    'width' => (int) $explode[0] / 2.5,
                    'height' => (int) $explode[1] / 2.5
                ];
            }
            return [
                'width' => 100,
                'height' => 100
            ];
        }

        return null;
    }

    public function getResolutionOriginalAttribute()
    {
        if ($this->attributes['resolution'] !== 'video') {
            $explode = explode('x', $this->attributes['resolution']);

            if (isset($explode[0]) && isset($explode[1])) {
                return [
                    'width' => (int) $explode[0] / 2.5,
                    'height' => (int) $explode[1] / 2.5
                ];
            }
            return [
                'width' => 100,
                'height' => 100
            ];
        }

        return null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'hough_data' => 'array',
        'canny_data' => 'array',
        'normal_data' => 'array',
    ];

    protected $appends = ['full_status', 'full_images', 'main_image'];

    public function getFullStatusAttribute()
    {
        if ($this->hough_status && $this->canny_status && $this->normal_status) {
            return true;
        }

        return false;
    }

    public function getMainImageAttribute()
    {
        return url('uploads/' . $this->image_path);
    }

    private static function url($path)
    {

        return 'https://beta2.limonistmeta.co.uk/' . $path;
    }

    public function getFullImagesAttribute()
    {
        $images = [];
        foreach ($this->hough_data as $key => $value) {

            $images[] = self::url('uploads/outputs/' . $value);
        }
        foreach ($this->canny_data as $key => $value) {

            $images[] = self::url('uploads/outputs/' . $value);
        }
        foreach ($this->normal_data as $key => $value) {

            $images[] = self::url('uploads/outputs/' . $value);
        }


        return $images;
    }
}

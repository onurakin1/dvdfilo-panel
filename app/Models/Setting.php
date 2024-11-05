<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\SettingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use HasFactory,SettingTrait,HasTranslations,LogsActivity;

    public $translatable = ['label'];

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnlyDirty()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }
}

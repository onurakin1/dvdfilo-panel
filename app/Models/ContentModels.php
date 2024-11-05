<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Brands;

class ContentModels extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "contents";
    protected $primaryKey = 'id';

    
    protected $fillable = ['about_us', 'our_services', 'main_slider', 'slider', 'reference', 'created_at'];

}

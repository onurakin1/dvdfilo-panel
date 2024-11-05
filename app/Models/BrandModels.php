<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Brands;

class BrandModels extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "brand_models";
    protected $primaryKey = 'id';
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'desc', 'brand_id', 'image', 'price', 'created_at', 'updated_at', 'deleted_at'];

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}

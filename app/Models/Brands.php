<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BrandModels;

class Brands extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "brands";
    protected $primaryKey = 'id';
    protected $fillable = ['brand_name', 'brand_type', 'created_at', 'updated_at', 'deleted_at'];

    public function brandModels()
    {
        return $this->hasMany(BrandModels::class, 'brand_id');
    }

    public function offers()
    {
        return $this->hasMany(Offers::class, 'brand');
    }
}

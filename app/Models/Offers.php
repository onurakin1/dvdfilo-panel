<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brands;

class Offers extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "offers";
    protected $primaryKey = 'id';
    protected $fillable = ['firstname', 'lastname', 'phone_number', 'email', 'brand', 'carname', 'rental_period', 'km_time', 'offer_type'];

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand');
    }

}
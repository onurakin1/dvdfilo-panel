<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Brands;

class ContractsModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "contracts";
    protected $primaryKey = 'id';

    
    protected $fillable = ['clarification_text', 'our_privacy_policy', 'privacy_policy', 'created_at'];

}

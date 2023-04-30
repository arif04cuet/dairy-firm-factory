<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class FormulationEstimate extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "product_id",
        "user_id",
        "processing_plant_id",
        "density",
        "fat_percentage",
        "was_in_stock",
        "total_raw_mix",
        "total_mix",
        "date",
        "formulation_density",
        "formulation_bran",
        "used_stock",
    ];

    //
    protected $appends = ['product_name', 'user_name'];

    //
    public function product() 
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getProductNameAttribute()
    {
        return ($this->product()->first()->product_name ?? 'N/A');
    }

    public function getUserNameAttribute()
    {
       return ($this->user()->first()->name_bn ?? 'N/A'); 
    }

    public function item ()
    {
        return $this->hasMany(FormulationEstimateItem::class, 'estimate_id', 'id');
    }

    public function user () {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

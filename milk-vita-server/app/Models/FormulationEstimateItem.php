<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use App\Models\Product\ProductUnit;

class FormulationEstimateItem extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "estimate_id",
        "product_id",
        "material_percentage",
        "no_of_product",
        "quantity",
        "was_in_stock",
        "unit_id",
        "is_raw",
        "type",
    ];

    //
    protected $appends = ['product_name', 'unit_name'];

    //
    public function product() 
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    //
    public function unit() 
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }

    public function getProductNameAttribute()
    {
        return ($this->product()->first()->product_name ?? 'N/A');
    }

    public function getUnitNameAttribute()
    {
        return ($this->unit()->first()->unit_name ?? 'N/A');
    }
}

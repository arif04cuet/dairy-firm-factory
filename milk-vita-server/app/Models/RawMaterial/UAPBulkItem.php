<?php

namespace App\Models\RawMaterial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductUnit;
use App\Models\Product\Product;
use App\Models\Product\ProductStock;

class UAPBulkItem extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "bulk_id",
        "processing_plant_id",
        "user_id",
        "product_id",
        "unit_id",
        "quantity",
        "price",
        "type",
        "date",
    ];
    //
    protected $appends = ['product_name', 'product_code', 'unit_name'];
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
    //
    public function getProductNameAttribute()
    {
        return ($this->product()->first()->product_name ?? "---");
    }
    //
    public function getProductCodeAttribute()
    {
        return ($this->product()->first()->product_code ?? "---");
    }
    //
    public function getUnitNameAttribute()
    {
        return ($this->unit()->first()->unit_name ?? "---");
    }
}


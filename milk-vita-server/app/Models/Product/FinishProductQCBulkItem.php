<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FinishProductQCBulkItem extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "qc_bulk_id",
        "processing_plant_id",
        "user_id",
        "product_id",
        "unit_id",
        "quantity",
        "pro_liter",
        "density",
        "pro_kg",
        "fat_kg",
        "snf_kg",
        "fat_persentase",
        "snf_persentase",
        "date",
    ];

    //
    protected $appends = ['product_name', 'product_code', 'unit_name', 'product_slug'];
    //
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    //
    public function getProductNameAttribute()
    {
        return ($this->product()->first()->product_name ?? "---");
    }
    //
    public function getProductSlugAttribute()
    {
        return ($this->product()->first()->slug ?? "---");
    }
    //
    public function getProductCodeAttribute()
    {
        return ($this->product()->first()->product_code ?? "---");
    }

    //
    public function unit(){
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }
    //
    public function getUnitNameAttribute()
    {
        return ($this->unit()->first()->unit_name ?? '');
    }
}

<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;    
    //
    protected $fillable = [
        'stockable_type',
        'stockable_id',
        'product_id',
        'unit_id',
        'category_id',
        'quantity'
    ];
    //
    protected $appends = ['product_name', 'product_code', 'unit_name', 'category_name'];
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
    //
    public function category()
    {
        return ($this->hasOne(ProductCategory::class, 'id', 'category_id'));
    }
    //
    public function getCategoryNameAttribute()
    {
        return $this->category()->first()->category_name ?? 'N/A';
    }
}

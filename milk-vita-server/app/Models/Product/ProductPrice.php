<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "price_label_id",
        "product_id",
        "unit_id",
        "price",
        "is_active",
    ];

    //
    protected $appends = ['unit_name', 'product_name', 'price_label', 'price_label_slug'];

    // RELATION WITH UNIT
    public function unit()
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }

    // RELATION WITH PRODUCT
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getUnitNameAttribute()
    {
        return $this->unit()->first()->unit_name ?? 'N/A';
    }

    public function getProductNameAttribute()
    {
        return $this->product()->first()->product_name ?? 'N/A';
    }

    public function label ()
    {
        return $this->hasOne(ProductPriceLabel::class, 'id', 'price_label_id');
    }

    public function getPriceLabelAttribute()
    {
        return $this->label()->first()->label_name ?? 'N/A';
    }

    public function getPriceLabelSlugAttribute()
    {
        return $this->label()->first()->slug ?? 'N/A';
    }
}

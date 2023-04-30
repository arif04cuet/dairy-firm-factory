<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\{
    Product, ProductCategory
};

class FormulaPackingItem extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        "product_id",
        "material_product_id",
        "material_percentage", // IF NEEDED
        "is_raw", // IF NEEDED
        "type" // ENUM (formula, packing)
    ];

    protected $appends = [
        "product_name",
        "category_name",
    ];

    public function product(){
        return $this->hasOne(Product::class, 'id', 'material_product_id');
    }

    public function getProductNameAttribute()
    {
        return $this->product()->first()->product_name ?? 'N/A';
    }

    public function getCategoryNameAttribute()
    {
        return $this->product()->first()->category_name ?? 'N/A';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductCategory;

class MilkChallanCategoryWise extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "challan_id",
        "category_id",
        "density",
        "quantity",
        "kg",
        "fat_percentage",
        "fat_kg",
        "snf_percentage",
        "snf_kg",
        "date",
    ];

    //
    protected $appends = ["category_name"];


    //
    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category()->first()->category_name ?? 'N/A';
    }
}

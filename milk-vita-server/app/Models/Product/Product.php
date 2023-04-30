<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CategoryTrait;

class Product extends Model
{
    use HasFactory, SoftDeletes, CategoryTrait;

    //
    protected $fillable = [
        "formulation_density",
        "formulation_bran",
        "product_name",
        "product_code",
        "is_active",
        "slug",
        "cat_id",
        "vat",
    ];

    //
    protected $appends = ['category_name'];

    //
    public function getCategoryNameAttribute()
    {
        return ($this->getChildParentCategoryName($this->cat_id));
    }
}

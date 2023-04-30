<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceLabel extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        "label_name",
        "slug",
        "is_system",
    ];
}

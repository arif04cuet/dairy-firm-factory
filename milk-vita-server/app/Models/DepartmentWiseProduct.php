<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class DepartmentWiseProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "department_id",
        "product_id",
    ];

    protected $appends = ['product_name'];
    //
    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
    //
    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    //
    public function getProductNameAttribute()
    {
        $product = $this->product()->first();

        return $product ? $product->product_name." <span class='text-success'> (<small>{$product->category_name}</small>)</span>" : 'N/A';
    }

}

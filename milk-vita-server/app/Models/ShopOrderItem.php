<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use App\Models\Product\ProductUnit;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductPrice, DB;

class ShopOrderItem extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "unit_id",
        "cat_id",
        "product_id",
        "quantity",
        "order_id",
        "is_receive_as_demand",
        "price",
        "date",
        "delivery_date",
    ];

    //
    protected $appends = ['product_name', 'unit_name', 'category_name'];


    // RELATION WITH PRODUCT
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');   
    }

    // RELATION WITH UNIT
    public function unit()
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }

    // RELATION WITH CATEGORY
    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'cat_id');
    }



    ///////////////////////////////////////////////

    //
    public function getProductNameAttribute()
    {
        return $this->product()->first()->product_name ?? 'N/A';
    }
    //
    public function getUnitNameAttribute()
    {
        return $this->unit()->first()->unit_name ?? 'N/A';
    }
    //
    public function getCategoryNameAttribute()
    {
        return $this->category()->first()->category_name ?? 'N/A';
    }
    //
    public function getPriceAttribute($value)
    {
        if($value <= 0){
            $price = DB::table('shop_order_items')
                ->join('product_prices', 'shop_order_items.product_id', '=', 'product_prices.product_id')
                ->join('product_price_labels', 'product_price_labels.id', '=', 'product_prices.price_label_id')
                ->where([
                    'shop_order_items.id'       => $this->id,
                    'product_prices.product_id' => $this->product_id,
                    'product_prices.unit_id'    => $this->unit_id,
                    'product_price_labels.slug' => 'shop-price',
                ])
                ->select('product_prices.*', 'product_price_labels.slug')
                ->first();
            //
            return ($price->price ?? 0);
        }
        else {
            return $value;
        }
    }


}

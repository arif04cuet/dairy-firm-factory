<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "shop_id",
        "area_id",
        "user_id",
        "voucher_no",
        "date",
        "status",
    ];

    //
    protected $appends = ['shop_name', 'shop_mobile', 'user_name', 'area_name'];


    // RELATION WITH SHOP
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    // RELATION WITH ORDER ITEMS
    public function items()
    {
        return $this->hasMany(ShopOrderItem::class, 'order_id', 'id');
    }

    // RELATION WITH USER
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // RELATION WITH AREA
    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }

    ////////////////////////////////////////////////////////////////

    //
    public function getShopNameAttribute()
    {
        return $this->shop()->first()->shop_name_bn ?? 'N/A';
    }

    //
    public function getShopMobileAttribute()
    {
        return $this->shop()->first()->shop_mobile ?? 'N/A';
    }

    //
    public function getUserNameAttribute()
    {
        return $this->user()->first()->name_bn ?? 'N/A';
    }

    //
    public function getAreaNameAttribute ()
    {
        return $this->area()->first()->area_name_bn ?? 'A/A';
    }


}

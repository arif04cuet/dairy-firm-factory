<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "app_id",
        "user_id",
        "area_id",
        "shop_name_bn",
        "shop_name_en",
        "owner_name_bn",
        "owner_name_en",
        "mobile",
        "division_id",
        "district_id",
        "upazila_id",
        "union_id",
        "address_details",
    ];

    //
    protected $appends = ['area_name'];

    // RELATION WITH AREA
    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }

    //
    public function getAreaNameAttribute()
    {
        return $this->area()->first()->area_name_bn ?? '';
    }
}

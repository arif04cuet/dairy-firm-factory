<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorShopMap extends Model
{
    use HasFactory;

    protected $fillable = [
        "distributor_id",
        "zone_id",
        "area_id",
        "shop_id",
    ];
}

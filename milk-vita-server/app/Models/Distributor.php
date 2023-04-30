<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distributor extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "zone_id",
        "distributor_name_bn",
        "distributor_name_en",
        "distributor_mobile",
        "distributor_address",
    ];

    //
    protected $appends = ['zone_name'];

    //
    public function zone ()
    {
        return $this->hasOne(Zone::class, 'id', 'zone_id');
    }

    //
    public function getZoneNameAttribute()
    {
        return $this->zone()->first()->zone_name_bn ?? 'N/A';
    }

}

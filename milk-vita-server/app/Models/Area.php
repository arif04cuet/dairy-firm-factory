<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "zone_id",
        "area_name_bn",
        "area_name_en",
        "division_id",
        "district_id",
        "upazila_id",
        "union_id",
        "area_details",
    ];

    // 
    protected $appends = ['zone_name'];

    // RELATION WITH ZONE
    public function zone()
    {
        return $this->hasOne(Zone::class, 'id', 'zone_id');
    }

    //
    public function getZoneNameAttribute()
    {
        return $this->zone()->first()->zone_name_bn ?? 'N/A';
    }

    //
    public function getAreaDetailsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "name_en",
        "name_bn",
        "mobile",
        "email",
        "division_id",
        "district_id",
        "upazila_id",
        "union_id",
        "address_details",
        "user_id",
        "remarks",
        "status",
        "type",
    ];
    
    protected $casts = [
        'address_details' => 'json',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class, 'app_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

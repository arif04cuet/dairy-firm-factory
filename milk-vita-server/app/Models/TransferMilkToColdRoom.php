<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TransferMilkToColdRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id",
        "processing_plant_id",
        "date",
        "code_no",
        "temperature",
        "total",
        "total_cream_can",
        "total_cream",
        "bulk_milk",
        "grand_total",
        "total_crate",
        "total_packet",
    ];

    protected $appends = ['user_name'];

    public function items()
    {
        return $this->hasMany(TransferMilkToColdRoomItem::class, 'transfer_id', 'id');
    }

    //
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getUserNameAttribute()
    {
        return ($this->user()->first()->name_bn ?? "N/A");
    }
}

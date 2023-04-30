<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TransferMilkToColdRoomItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "transfer_id",
        "date",
        "type",
        "unit",
        "full_column",
        "partial_column",
        "total_milk",
        "total_packet",
    ];
}

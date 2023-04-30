<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssociationBillDetails extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "bill_id",
        "association_id",
        "milk_collection_date",
        "shift",
        "litre",
        "specific_gravity",
        "fat",
        "snf",
        "unit_price",
        "date",
    ];
}

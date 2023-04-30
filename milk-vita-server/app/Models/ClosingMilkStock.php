<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClosingMilkStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id",
        "processing_plant_id",

        "pro_liter",
        "density",
        "pro_kg",
        "fat_kg",
        "snf_kg",
        "fat_persentase",
        "snf_persentase",

        "toned_pro_liter",
        "toned_density",
        "toned_pro_kg",
        "toned_fat_kg",
        "toned_snf_kg",
        "toned_fat_persentase",
        "toned_snf_persentase",

        "date",
    ];
}

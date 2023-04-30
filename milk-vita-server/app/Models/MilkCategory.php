<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkCategory extends Model
{
    use HasFactory;

    protected $fillable = ['milk_category_name'];
}

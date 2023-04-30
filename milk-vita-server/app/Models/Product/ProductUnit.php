<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = ['unit_name'];
}

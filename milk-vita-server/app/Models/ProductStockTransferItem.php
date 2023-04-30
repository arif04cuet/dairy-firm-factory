<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\{Product, ProductUnit};

class ProductStockTransferItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "trx_id",
        "product_id",
        "unit_id",
        "quantity",
        "density",
        "quantity_kg",
        "quantity_litre",
        "fat_persentase",
        "snf_persentase",
        "fat_kg",
        "snf_kg",
    ];

    protected $appends = [
        "product_name",
        "unit_name",
    ];


    /*
     * *****************
     * RELATION WITH
     * PRODUCT MODEL
     * *************
    */ 
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /*
     * *****************
     * RELATION WITH
     * UNIT MODEL
     * *************
    */ 
    public function unit()
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }


    /*
     * *****************
     * SET PRODUCT NAME
     * ATTRIBUTE
     * *************
    */ 
    public function getProductNameAttribute(){
        return $this->product()->first()->product_name ?? 'N/A';
    }


    /*
     * *****************
     * SET UNIT NAME
     * ATTRIBUTE
     * *************
    */ 
    public function getUnitNameAttribute(){
        return $this->unit()->first()->unit_name ?? 'N/A';
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductCategory;

class MilkChallanStockRecord extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "challan_id",
        "department_id",
        "processing_plant_id",
        "category_id",
        "quantity",
        "density",
        "kg",
        "fat_percentage",
        "fat_kg",
        "snf_percentage",
        "snf_kg",
    ];

    protected $appends = ["department_name", "category_name"];
    //
    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
    //
    public function category(){
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }
    //  
    public function getDepartmentNameAttribute()
    {
        return $this->department()->first()->department_name_en ?? 'N/A';
    }
    //  
    public function getCategoryNameAttribute()
    {
        return $this->category()->first()->category_name ?? 'N/A';
    }
}

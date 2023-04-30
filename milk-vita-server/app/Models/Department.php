<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "processing_plant_id",
        "manager_id",
        "department_name_en",
        "department_name_bn",
    ];

    //
    protected $appends = ['processing_plant_name', 'manager_name'];

    // 
    public function processingPlant()
    {
        return $this->hasOne(ProcessingPlant::class, 'id', 'processing_plant_id');
    }

    //
    public function getProcessingPlantNameAttribute()
    {
        return $this->processingPlant()->first()->processing_plant_name ?? 'N/A';
    }

    //
    public function product()
    {
        return $this->hasMany(DepartmentWiseProduct::class, 'department_id', 'id');
    }

    //
    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

    //
    public function milkStock(){
        return $this->morphOne(MilkStock::class, 'stockable');
    }

    //
    public function stock(){
        return $this->hasOne(MilkStock::class, 'stockable_id', 'id')->where('stockable_type', 'App\Models\Department');
    }

    //
    public function getManagerNameAttribute()
    {
        return $this->manager()->first()->name_bn ?? "N/A";
    }
}

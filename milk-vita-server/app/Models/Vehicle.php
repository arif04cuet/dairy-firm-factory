<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['model_no', 'vat_no', 'processing_plant_id', 'vehicle_category_id'];

    public function category(){
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id', 'id');
    }

    public function processingPlant(){
        return $this->belongsTo(ProcessingPlant::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "processing_plant_id",
        "zone_name_en",
        "zone_name_bn",
    ];

    //
    protected $appends = ['processing_plant_name'];
    
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
}

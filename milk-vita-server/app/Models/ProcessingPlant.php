<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductStock;

class ProcessingPlant extends Model
{
    use HasFactory;

    protected $fillable = [
        'processing_plant_name',
        'full_address',
        'division_id',
        'district_id',
        'upazila_id',
        'union_id',
        'longitude',
        'latitude',
        'location_details',
        'office_id'
     ];

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function thana(){
        return $this->belongsTo(Thana::class);
    }
    
    //
    public function milkStock()
    {
        return $this->morphOne(MilkStock::class, 'stockable');
    }

    public function productStock()
    {
        return $this->morphOne(ProductStock::class, 'stockable');
    }

    public function getLocationDetailsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}

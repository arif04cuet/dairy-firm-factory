<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model, DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChillingPlant extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "chilling_plant_name",
        "processing_plant_id",
        "division_id",
        "district_id",
        "upazila_id",
        "union_id",
        "full_address",
        "stock_capacity",
        "location_details",
        "office_id",
    ];
    // 
    protected $appends = [
        "processing_plant_name",
        "fillup"
    ];
    protected $morphClass = 'staff';

    public function getFillupAttribute()
    {
        $chilling_plant = DB::table('chilling_plants')
        ->leftjoin('milk_stocks', 'milk_stocks.stockable_id', '=', 'chilling_plants.id')
        ->select(
            'milk_stocks.amount as stock_amount',
            DB::raw('SUM((100/chilling_plants.stock_capacity) * milk_stocks.amount) AS fillup_persentage')
        )
        ->where(
            [
                'milk_stocks.stockable_type' => 'App\Models\ChillingPlant', 
                'chilling_plants.id' => $this->id, 
                'milk_stocks.stockable_id' => $this->id
            ]
        )->first();

        //
        return [
            "stock"      => $chilling_plant->stock_amount ?? 0,
            "percentage" => $chilling_plant->fillup_persentage ?? 0,
        ];
    }

    //
    public function milkStock(){
        return $this->morphOne(MilkStock::class, 'stockable');
    }

    //
    public function processingPlant()
    {
        return $this->hasOne(ProcessingPlant::class, 'id', 'processing_plant_id');
    }

    //
    public function getLocationDetailsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    //
    public function getProcessingPlantNameAttribute()
    {
        return ($this->processingPlant()->first()->processing_plant_name ?? 'N/A');
    }

}

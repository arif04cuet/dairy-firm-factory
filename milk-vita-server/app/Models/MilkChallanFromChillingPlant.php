<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkChallanFromChillingPlant extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        "bulk_id",
        "chilling_plant_id",
        "processing_plant_id",
        "chilling_plant_manager_id",
        "voucher_no",
        //
        "clpt_liter",
        "clpt_density",
        "clpt_kg",
        "clpt_fat_percentage",
        "clpt_fat_kg",
        "clpt_snf_percentage",
        "clpt_snf_kg",
        //
        "prpt_liter",
        "prpt_density",
        "prpt_kg",
        "prpt_fat_percentage",
        "prpt_fat_kg",
        "prpt_snf_percentage",
        "prpt_snf_kg",
        //
        "QCPMFP",
        "QCPMMP",
        "AFP",
        "SFP",
        "RFK",
        "RSNFK",
        //
        "pre_stock",
        "remark",
        "status",
        "date",
        "is_done",
        "is_submit",
        "driver_id",
        "is_driver_receive",
        //
        "sample_quantity",
        "qc_manager_id",
        "is_send_qc",
        "is_qc",
        "sand_qc_date",
        "qc_date",
    ];

    //
    protected $appends = ['chilling_plant_name', 'chilling_plant_address', 'stock_amount', 'chilling_plant_manger_signature'];

    //
    public function category_wise_milk ()
    {
        return $this->hasMany(MilkChallanCategoryWise::class, 'challan_id', 'id');
    }
    //
    public function department_wise_milk ()
    {
        return $this->hasMany(MilkChallanStockRecord::class, 'challan_id', 'id');
    }

    //
    public function test_results()
    {
        return $this->morphMany(TestResult::class, 'testable');
    }

    //
    public function chillingPlant()
    {
        return $this->hasOne(ChillingPlant::class, 'id', 'chilling_plant_id');
    }

    //
    public function namager ()
    {
        return $this->hasOne(User::class, 'id', 'chilling_plant_manager_id');
    }

    //
    public function getChillingPlantMangerSignatureAttribute ()
    {
        return $this->namager()->first()->signature_path ?? false;
    }
    //
    public function getChillingPlantNameAttribute()
    {
        return ($this->chillingPlant()->first()->chilling_plant_name ?? '');
    }

    //
    public function getChillingPlantAddressAttribute()
    {
        return ($this->chillingPlant()->first()->full_address ?? '---');
    }

    // RELATION WITH BULK
    public function bulk()
    {
        return $this->belongsTo(MilkChallanBulk::class, 'bulk_id');
    }

    //
    public function getStockAmountAttribute(){
        return (MilkStock::where(
            [
                'stockable_id'   => $this->chilling_plant_id,
                'stockable_type' => 'App\Models\ChillingPlant'
            ]
        )->sum('amount'));
    }

    //
    public function getStatusAttribute($value)
    {
        return ($value=='submited' ? (($this->is_sand_qc==0) ? 'ready_for_qc' : ($this->is_qc==1 ? 'qc_done' : 'qc_pending')) : $value);
    }
}

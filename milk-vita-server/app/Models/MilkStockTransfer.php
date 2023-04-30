<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class MilkStockTransfer extends Model
{
    use HasFactory, SoftDeletes;


    //
    protected $fillable = [
        "from_processing_plant_id",
        "to_processing_plant_id",
        "sender_id",
        "receiver_id",
        "voucher_no",
        //
        "sdr_liter",
        "sdr_density",
        "sdr_kg",
        "sdr_fat_persentase",
        "sdr_fat_kg",
        "sdr_snf_persentase",
        "sdr_snf_kg",
        //
        "rvr_liter",
        "rvr_density",
        "rvr_kg",
        "rvr_fat_persentase",
        "rvr_fat_kg",
        "rvr_snf_persentase",
        "rvr_snf_kg",
        //
        "remark",
        "date",
        "receive_date",
        "is_receive",
    ];

    //
    protected $appends = ['from_processing_plant_name', 'to_processing_plant_name', 'status'];


    //
    public function fromProcessingPlant()
    {
        return $this->hasOne(ProcessingPlant::class, 'id', 'from_processing_plant_id');
    }

    //
    public function toProcessingPlant()
    {
        return $this->hasOne(ProcessingPlant::class, 'id', 'to_processing_plant_id');
    }


    //
    public function getFromProcessingPlantNameAttribute(){
        return ($this->fromProcessingPlant()->first()->processing_plant_name ?? 'N/A');
    }
    //
    public function getToProcessingPlantNameAttribute(){
        return ($this->toProcessingPlant()->first()->processing_plant_name ?? 'N/A');
    }

    //
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }


    //
    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }




    //
    public function getStatusAttribute(){
        return ($this->is_receive==1 ? 'গৃহীত' : 'অপেক্ষমান');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStockTransfer extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "from_processing_plant_id",
        "to_processing_plant_id",
        "voucher_no",
        "sender_id",
        "receiver_id",
        "is_receive",
        "remark",
        "date",
        "receive_date",
    ];

    protected $appends = [
        "status",
        "from_processing_plant_name", 
        "to_processing_plant_name",
        "total_item"
    ];


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
    public function items()
    {
        return $this->hasMany(ProductStockTransferItem::class, 'trx_id', 'id');
    }

    // RELATION WITH SENDER USER
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

    public function getTotalItemAttribute()
    {
        return $this->items()->count() ?? 0;
    }
}

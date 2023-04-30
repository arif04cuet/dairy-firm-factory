<?php

namespace App\Models\RawMaterial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessingPlant;
use App\Models\User;

class UAPBulk extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        "processing_plant_id",
        "user_id",
        "voucher_no",
        "type",
        "date",
    ];
    //
    protected $appends = ['user_name', 'processing_plant_name', 'grand_total', 'total_item'];
    //
    public function items()
    {
        return $this->hasMany(UAPBulkItem::class, 'bulk_id', 'id');
    }
    //
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    //
    public function processingPlant()
    {
        return $this->hasOne(ProcessingPlant::class, 'id', 'processing_plant_id');
    }
    //
    public function getUserNameAttribute()
    {
        return ($this->user()->first()->name_bn ?? "---");
    }
    //
    public function getProcessingPlantNameAttribute()
    {
        return ($this->processingPlant()->first()->processing_plant_name ?? "---");
    }
    //
    public function getGrandTotalAttribute()
    {
        return ($this->items()->sum(\DB::raw("quantity * price")) ?? "0");
    }
    //
    public function getTotalItemAttribute()
    {
        return ($this->items()->count() ?? "0");
    }
}


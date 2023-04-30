<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallanAssociationToChillingPlant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "milk_cat_id",
        "association_id",
        "chilling_plant_id",
        "asso_manager_id",
        "chilling_plant_manager_id",
        "voucher_no",
        "amount_of_milk",
        "temperature",
        "lectometer_reading",
        "snf",
        "noni",
        "full_can",
        "half_can",
        "shift",
        "remark",
        "driver_name",
        "entry_no",
        "sour_milk_sample_no",
        "total_can_return",
        "received_time",
        "milk_amount_kg_in_plant",
        "milk_amount_liter_in_plant",
        "specific_gravity_in_plant",
        "snf_in_plant",
        "noni_in_plant",
        "milk_difference",
        "status",
        "date",
    ];

    protected $appends = [
        'update_permission',
        'manager_signature',
        'association_name',
        'chilling_manager_signature'
    ];

    public function getUpdatePermissionAttribute()
    {
        return ($this->date == date('Y-m-d') && $this->status == 'pending');
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'asso_manager_id');
    }

    public function plantManager()
    {
        return $this->hasOne(User::class, 'id', 'chilling_plant_manager_id');
    }

    public function getManagerSignatureAttribute()
    {
        return ($this->manager()->first()->signature_path ?? '');
    }

    public function getChillingManagerSignatureAttribute()
    {
        return ($this->plantManager()->first()->signature_path ?? '');
    }

    public function getAssociationNameAttribute()
    {
        $asso = $this->association()->first();

        return "{$asso->association_name}({$asso->association_code})";
    }

    public function association()
    {
        return $this->hasOne(Association::class, 'id', 'association_id');
    }
}

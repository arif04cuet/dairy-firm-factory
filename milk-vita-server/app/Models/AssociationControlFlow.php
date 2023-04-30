<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationControlFlow extends Model
{
    use HasFactory;
    protected $fillable = [
        "association_id",
        "chilling_plant_id",
        "field_officer_id",
        "is_resolution",

        "chilling_plant_manager_id",
        "is_approved_chilling_plant_manager",
        "is_reject_chilling_plant_manager",
        "is_forward_for_correction",
        "is_forward_chilling_plant_manager",

        "milkvita_officer_id",
        "is_approved_milkvita_officer",
        "is_reject_milkvita_officer",

        "is_upazila_cooperative_officer",
        "upazila_cooperative_officer_id",
        "is_approved_cooperative_officer",
        "is_reject_cooperative_officer",

        "remark",
    ];

    public function chillingPlant(){
        return $this->hasOne(ChillingPlant::class, 'id', 'chilling_plant_id');
    }
}



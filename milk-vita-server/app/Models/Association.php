<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model, DB;

class Association extends Model
{
    use HasFactory;
    protected $fillable = [
        "dairy_storage_area",
        "user_id",
        "milk_area_division_id",
        "milk_area_district_id",
        "milk_area_upazila_id",
        "milk_area_union_id",
        "milk_area_village",
        "association_name",
        "association_code",
        "name_of_dairy_area",
        "working_area_of_association",
        "association_division_id",
        "association_district_id",
        "association_upazila_id",
        "association_union_id",
        "association_village",
        "total_present_member",
        "distance_of_working_area_to_adjoining_area",
        "distance_of_factory_to_association_center",
        "longitude",
        "latitude",
        "temparary_approved",
        "permanent_approved",
        "milk_area_location_details",
        "association_location_details",
    ];

    protected $appends = [
        "total_members",
        "total_committe_member",
        "signatures",
        "last_status",
        "chilling_plant_id", 
        "chilling_plant_name"
    ];

    //
    protected $casts = [
        "milk_area_location_details"    => "json",
        "association_location_details"  => "json"
    ];

    // RELATION WITH MEMBER
    public function members(){
        return $this->hasMany(AssociationMember::class, 'association_id', 'id');
    }

    //
    public function milkStock()
    {
        return $this->morphOne(MilkStock::class, 'stockable');
    }

    //
    public function milkCollections (){
        return $this->hasMany(MilkCollectionInAssociation::class, 'association_id', 'id')->orderBy('id', 'DESC');
    }

    // RELATION WITH 
    public function road_types(){
        return $this->hasMany(AssociationRoadType::class, 'association_id', 'id');
    }

    // 
    public function getTotalMembersAttribute(){
        return ($this->members()->count() ?? 0);
    }


    //
    public function getChillingPlantIdAttribute()
    {
        return $this->control_flow()->first()->chilling_plant_id ?? 0;
    }

    //
    public function getChillingPlantNameAttribute()
    {
        $control_flow = $this->control_flow()->first();
        //
        return (!empty($control_flow->chillingPlant) ? $control_flow->chillingPlant->chilling_plant_name : "N/A");
    }

    //
    public function commitee_members()
    {
        return $this->hasMany(AssociationCommiteeMember::class, 'association_id', 'id');
    }

    //
    public function getTotalCommitteMemberAttribute()
    {
        return $this->commitee_members()->count() ?? 0;
    }

    //
    public function control_flow()
    {
        return $this->hasOne(AssociationControlFlow::class, 'association_id', 'id');
    }

    //
    public function getSignaturesAttribute(){
        $signatures = DB::table('association_control_flows')
            ->where('association_id', $this->id)
            ->select(
                DB::raw("(SELECT signature_path FROM users WHERE association_control_flows.field_officer_id=users.id limit 1) AS field_officer_signature_path"),
                DB::raw("(SELECT signature_path FROM users WHERE association_control_flows.chilling_plant_manager_id=users.id limit 1) AS chilling_plant_manager_signature_path"),
                DB::raw("(SELECT signature_path FROM users WHERE association_control_flows.milkvita_officer_id=users.id limit 1) AS milkvita_officer_signature_path"),
                DB::raw("(SELECT signature_path FROM users WHERE association_control_flows.upazila_cooperative_officer_id=users.id limit 1) AS upazila_cooperative_officer_signature_path"),
            )
            ->first();

        return $signatures;
    }

    //
    public function manager(){
        return $this->hasOne(User::class, 'association_id', 'id')->where('type', 'association-manager');
    }

    //
    public function bank_infos(){
        return $this->hasMany(AssociationBankInfo::class, 'association_id', 'id');
    }

    //
    public function getLastStatusAttribute(){
        return AssociationHistory::where('association_id', $this->id)->orderBy('id', 'DESC')->first()->status ?? '---';
    }
}

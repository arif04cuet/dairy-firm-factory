<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model, DB;

class AssociationMember extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "association_id",
        "member_name",
        "member_name_en",
        "member_code",
        "father_name_en",
        "father_name_bn",
        "mother_name_en",
        "mother_name_bn",
        "spouse_name_en",
        "spouse_name_bn",
        "village",
        "post_office",
        "division_id",
        "district_id",
        "upazila_id",
        "location_details",
        "amount_of_milk_produced",
        "where_sales_are",
        "total_gavi",
        "total_bokna",
        "total_bokon_bachor",
        "total_are_bachor",
        "total_shar",
        "total_bolod",
        "total_mohish",
        "age",
        "date_of_birth",
        "membership_date",
        "nid",
        "bkash_account_number",
        "bank_address",
        "religion",
        "gender_id",
        "gender_details",
        "occupation",
        "educational_qualification",
        "email",
        "mobile",
        "remark",
    ];

    protected $appends = [
        'total_cattle',
        'designation',
    ];

    protected $casts = [
        'gender_details' => 'array',
        'location_details' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            $model->member_code = mkMemberCode((DB::table('association_members')->max('id') + 1));
        });
    }

    public function getTotalCattleAttribute()
    {
        return (
            $this->total_gavi +
            $this->total_bokna +
            $this->total_bokon_bachor +
            $this->total_are_bachor +
            $this->total_shar +
            $this->total_bolod +
            $this->total_mohish
        );
    }

    //
    public function getDesignationAttribute()
    {
        return $this->committee()->first()->designation ?? 'সদস্য';
    }

    // RELATION WITH DIVISION MODEL
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // RELATION WITH DISTRICT MODEL
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // RELATION WITH THANA MODEL
    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }

    // RELATION WITH ASSOCITAION MODEL
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    // RELATION WITH COMMITTEE
    public function committee()
    {
        return $this->hasOne(AssociationCommiteeMember::class, 'member_id', 'id');
    }


}

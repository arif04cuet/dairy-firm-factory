<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationMeetingResolution extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        "field_officer_id",
        "association_id",
        "meeting_date",
        "meeting_title",
        "meeting_resolution",
        "type",
        "is_done"
    ];

    //
    protected $appends = ['status', 'association_name'];

    //
    public function getStatusAttribute()
    {
        return ($this->is_done==1?'রেজোলিউশন সম্পন্ন হয়েছে':'রেজোলিউশন এ ওপেক্কিয়মান');
    }

    //
    public function association()
    {
        return $this->hasOne(Association::class, 'id', 'association_id');
    }

    //
    public function getAssociationNameAttribute()
    {
        return $this->association()->first()->association_name ?? 'N/A';
    }

    public function manager(){
        return $this->hasOne(User::class, 'association_id', 'association_id')->where([
            'type'  => 'association-manager',
            'trash' => 0
        ]);
    }


    //
    public function commitee_members()
    {
        return $this->hasMany(AssociationCommiteeMember::class, 'association_id', 'association_id')->where('trash', 0);
    }

}

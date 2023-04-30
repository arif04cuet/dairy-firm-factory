<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationCommiteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'member_id',
        'designation_id',
        'trash'
    ];

    protected $appends = ['member_name', 'designation'];

    // 
    public function getMemberNameAttribute()
    {
        return $this->commitee_member()->first()->member_name ?? null;
    }

    //
    public function getDesignationAttribute(){
        return $this->designation()->first()->designation_name ?? null;
    }

    //
    public function commitee_member(){
        return $this->hasOne(AssociationMember::class, 'id', 'member_id');
    }

    //
    public function designation(){
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }
}

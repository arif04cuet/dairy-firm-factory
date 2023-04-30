<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssociationBillRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "chilling_plant_id",
        "association_id",
        "user_id",
        "from_date",
        "to_date",
        "date"
    ];

    //
    protected $appends = ['association_name', 'association_code', 'grand_total'];


    //
    public function association ()
    {
        return $this->hasOne(Association::class, 'id', 'association_id');
    }

    //
    public function getAssociationNameAttribute()
    {
        return ($this->association()->first()->association_name ?? '--');
    } 
    //
    public function getAssociationCodeAttribute()
    {
        return ($this->association()->first()->association_code ?? '--');
    } 
    //
    public function getGrandTotalAttribute(){
        return 0;
    }  
}

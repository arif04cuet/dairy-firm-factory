<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;
    protected $fillable = ["district_id", "name", "bn_name", "url", "trash"];
    protected $appends  = ['district_name', 'division_id'];


    /*
     * *************************
     * RELATION WITH DISTRICT
     * **********************
    */
    public function district(){
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    /*
     * *************************
     * FETCH DISTRICT NAME ATTR
     * **********************
    */
    public function getDistrictNameAttribute(){
        return $this->district()->first()->name ?? 'N/A';
    }

    /*
     * *************************
     * FETCH DIVISION ID ATTR
     * **********************
    */
    public function getDivisionIdAttribute(){
        return $this->district()->first()->division_id ?? 'N/A';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ["division_id", "name", "bn_name", "lat", "lon", "url", "trash"];
    protected $appends  = ['division_name'];

    /*
     * *************************
     * RELATION WITH DIVISION
     * **********************
    */
    public function division(){
        return $this->hasOne(Division::class, 'id', 'division_id');
    }

    /*
     * *************************
     * FETCH DIVISION NAME ATTR
     * **********************
    */
    public function getDivisionNameAttribute(){
        return $this->division()->first()->name ?? 'N/A';
    }
}

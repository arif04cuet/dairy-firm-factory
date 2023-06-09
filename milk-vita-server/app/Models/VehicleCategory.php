<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_category_name'];

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }
}

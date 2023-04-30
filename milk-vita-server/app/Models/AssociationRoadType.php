<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationRoadType extends Model
{
    use HasFactory;
    protected $fillable = [
        'association_id',
        'road_type_id',
        'distance',
        'unit',
    ];

    protected $appends = [
        'road_type_name',
    ];

    public function road_type(){
        return $this->hasOne(RoadType::class, 'id', 'road_type_id');
    }

    public function getRoadTypeNameAttribute(){
        return $this->road_type()->first()->road_type_name ?? 'N/A';
    }
}

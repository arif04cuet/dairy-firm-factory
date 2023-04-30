<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        "designation_name",
        "entity_id",
    ];

    protected $appends = ['entity_name', "parent_entity_id", "parent_entity_name"];

    // RELATION WITH ENTITY
    public function entity(){
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }

    //
    public function getEntityNameAttribute(){
        return $this->entity()->first()->entity_name ?? 'N/A';
    }

    //
    public function getParentEntityNameAttribute(){
        return $this->entity()->first()->parent_name ?? 'N/A';
    }
    //
    public function getParentEntityIdAttribute()
    {
        $entity = $this->entity()->first();
        return ($entity->parent_id ?? '0');
    }
}

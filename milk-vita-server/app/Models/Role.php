<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_name',
        'entity_id',
        'slug',
        'is_system'
    ];

    protected $appends = ['entity_name', 'parent_entity_name', 'parent_entity_id'];

    public function entity()
    {
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }

    public function getEntityNameAttribute()
    {
        return $this->entity()->first()->entity_name ?? 'N/A';
    }

    public function getParentEntityNameAttribute()
    {
        return $this->entity()->first()->parent_name ?? 'N/A';
    }

    public function getParentEntityIdAttribute()
    {
        return $this->entity()->first()->parent_id ?? 0;
    }

    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }


    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'entity_name',
        'is_system',
        'slug',
    ];

    protected $appends = [
        'parent_name'
    ];

    public function getSystemNameAttribute(){
        return $this->system()->first()->system_name ?? 'N/A';
    }

    public function parent(){
        return $this->hasOne(Entity::class, 'id', 'parent_id');
    }

    public function getParentNameAttribute(){
        return $this->parent()->first()->entity_name ?? 'N/A';
    }
}

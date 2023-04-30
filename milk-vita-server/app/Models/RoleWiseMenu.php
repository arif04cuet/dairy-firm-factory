<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleWiseMenu extends Model
{
    use HasFactory;

    protected $casts = [
        "menus" => "array",
        "sub_menus" => "array",
        "action_menus" => "array"
    ];

    
    protected $fillable = [
        'role_id',
        'menus',
        'sub_menus',
        'action_menus',
    ];
}

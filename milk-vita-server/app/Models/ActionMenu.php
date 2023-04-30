<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionMenu extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id', 'name_en', 'name_bn', 'trash', 'url', 'icon', 'type', 'position', 'slug'];

    //
    protected $appends = ['menu_name'];

    // Relation With Menu 
    public function getMenu(){
    	return $this->hasOne(Menu::class, 'id', 'menu_id')->where('trash', 0)->orderBy('position', 'ASC');
    }

    // Relation With Sub-Menu
    public function getSubMenu(){
    	return $this->hasOne(SubMenu::class, 'id', 'sub_menu_id')->where('trash', 0)->orderBy('position', 'ASC');
    }

    //
    public function getMenuNameAttribute()
    {
        return $this->getMenu()->orWhere('trash', 1)->first()->name_en ?? 'N/A';
    }
}

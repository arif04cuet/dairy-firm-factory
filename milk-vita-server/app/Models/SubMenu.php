<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['menu_id', 'name_en', 'name_bn', 'trash', 'url', 'icon', 'position'];

    // Relation With Menu Model
    public function getMenu()
    {
    	return $this->hasOne(Menu::class, 'id', 'menu_id')->where('trash', 0)->orderBy('position', 'ASC');
    }

    // Relation With Action Menus 
    public function getActionMenu()
    {
    	return $this->hasMany(ActionMenu::class, 'sub_menu_id', 'id')->where('trash', 0)->orderBy('position', 'ASC');
    }
    public function actionMenu()
    {
        return $this->hasMany(ActionMenu::class, 'sub_menu_id', 'id')->where('trash', 0)->orderBy('position', 'ASC');
    }
}

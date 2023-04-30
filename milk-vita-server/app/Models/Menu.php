<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'name_en', 'name_bn', 'trash', 'url', 'icon', 'position', 'slug'];

    //
    protected $appends = ['parent_name'];

    // 
    protected $parentColumn = 'parent_id';

    // Relation with Sub-Menu
    public function subMenu()
    {
    	return $this->hasMany(Menu::class, 'parent_id', 'id')->where('trash', 0)->orderBy('position', 'ASC')->with('actionMenu');
    }

    // Relation with Sub-Menu
    public function actionMenu(){
        return $this->hasMany(ActionMenu::class, 'menu_id', 'id')->where('trash', 0)->orderBy('position', 'ASC');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, $this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function getParentNameAttribute()
    {
        return $this->parent()->first()->name_en ?? 'N/A';
    }
}

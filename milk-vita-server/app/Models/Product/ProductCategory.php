<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = ['parent_id', 'category_name', 'slug', 'is_system'];
    //
    protected $appends = ['parent_category', 'is_children'];
    //
    public function parent(){
        return $this->hasOne(ProductCategory::class, 'id', 'parent_id');
    }
    //
    public function getParentCategoryAttribute()
    {
        return $this->parent()->first();
    }
    //
    public function children(){
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    //
    public function getIsChildrenAttribute()
    {
        return ($this->children()->get()->isEmpty() ? 0 : 1);
    }
}

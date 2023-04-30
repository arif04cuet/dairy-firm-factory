<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductCategory, DB;
use Illuminate\Http\Request;

trait CategoryTrait
{
	static function getChildParentCategoryName($cat_id=null)
	{
		if($cat_id)
		{	
			$category = ProductCategory::where('id', $cat_id)->first();
			//
			return ($category->parent_category ? ($category->category_name.' < '.$category->parent_category->category_name) : $category->category_name);
		}
		return '...';
	}
}
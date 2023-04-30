<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\MilkCategory;

class MilkCategoryController extends Controller
{
    public function all(Request $request, MilkCategory $milk_category)
    {
        $where = where($request->where);
        // 
        if($request->select){
            $milk_category = $milk_category->select($request->select);
        }
        // MAKE PAGINATED DATA
        $data = paginate($milk_category, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function store(Request $request, MilkCategory $milk_category)
    {
        $validator = Validator::make($request->all(), [
            'milk_category_name'=>'required||unique:milk_categories,milk_category_name'
        ]);
        
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $milk_category->create($request->only('milk_category_name'));

        return response()->json($milk_category->get());
    }

    public function update(Request $request, MilkCategory $milk_category)
    {
        $validator = Validator::make($request->all(), [
            'milk_category_name'=>'required||unique:milk_categories,milk_category_name'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        if($request->id){
            $milk_category->where('id', $request->id)->update($request->only('milk_category_name'));
            return response()->json($milk_category->get());
        }
        else {
            return response(['errors'=>['message'=>'Something Is Wrong!! Please Try Again..']], 200);
        }
    }
}

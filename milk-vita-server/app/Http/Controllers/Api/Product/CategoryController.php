<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, ProductCategory $category)
    {
        if($request->select){
            $category = $category->select($request->select);
        }
        if($request->children){
            $category = $category->with(['children'=>function($query)
            {
                $query->orderBy('id', 'DESC');
            }]);
        }
        // 
        $where   = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($category, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductCategory $category)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "category_name" => "required|unique:product_categories,category_name",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only("category_name", "parent_id");
        $data['slug'] = str_replace(' ', '-', strtolower($request->category_name));
        // 
        return response()->json($category->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $category, $id=null)
    {
        if($id){
            $old_category = $category->whereId($id)->first();
            // DATA VALIDATION
            if($old_category->category_name!=$request->category_name){
                $validator = Validator::make($request->all(), [
                    "category_name" => "required|unique:product_categories,category_name",
                ]);
                if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
            }
            // CATCH ALL DATA FROM REQUEST
            $data = $request->only("category_name", "parent_id");
            // 
            return response()->json($category->whereId($id)->update($data));
        }
        else response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductCategory $category, $id=null)
    {
        if($id){
            return response()->json($category->whereId($id)->delete());
        }
        else response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Shop $shop)
    {
        //
        if($request->select){
            $shop = $shop->select($request->select);
        }
        // 
        $where   = where($request->where);
        //
        if($request->whereIn && is_array($request->whereIn) && count($request->whereIn) > 0){
            $shop = $shop->whereIn(array_keys($request->whereIn)[0], $request->whereIn[array_keys($request->whereIn)[0]]);
        }
        // MAKE PAGINATED DATA
        $data = paginate($shop, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shop $shop)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "area_id"       => "required",
            "shop_name_bn"  => "required|unique:shops,shop_name_bn",
            "shop_name_en"  => "required|unique:shops,shop_name_en",
            "shop_mobile"  => "required|unique:shops,shop_mobile",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "shop_name_en",
            "shop_name_bn",
            "shop_mobile",
            "area_id",
        );
        // 
        return response()->json($shop->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop, $id)
    {
        // DATA VALIDATION
        $validator_field = ["area_id" => "required"];

        $old_shop = Shop::whereId($id)->first();
        if($old_shop->shop_name_bn!=$request->shop_name_bn){
            $validator_field['shop_name_bn'] = "required|unique:shops,shop_name_bn";
        }
        if($old_shop->shop_name_en!=$request->shop_name_en){
            $validator_field['shop_name_en'] = "required|unique:shops,shop_name_en";
        }
        if($old_shop->shop_mobile!=$request->shop_mobile){
            $validator_field['shop_mobile'] = "required|unique:shops,shop_mobile";
        }
        $validator = Validator::make($request->all(), $validator_field);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "shop_name_en",
            "shop_name_bn",
            "shop_mobile",
            "area_id",
        );
        // 
        return response()->json($shop->where('id', $id)->update($data));
    }

    public function destroy(Request $request, Shop $shop, $id)
    {
        return Shop::whereId($id)->delete();
    }
}

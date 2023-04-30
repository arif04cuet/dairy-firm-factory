<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceLabel;

class ProductPriceController extends Controller
{
    public function labelList(Request $request, ProductPriceLabel $product_price_label)
    {
        if($request->select){
            $product_price_label = $product_price_label->select($request->select);
        }
        // 
        $where = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($product_price_label, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, ProductPrice $product_price)
    {
        if($request->select){
            $product_price = $product_price->select($request->select);
        }
        // 
        $where = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($product_price, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductPrice $product_price)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "price_label_id" => "required",
            "product_id"     => "required",
            "unit_id"        => "required",
            "price"          => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only("price_label_id","product_id","unit_id","price");
        // 
        return response()->json($product_price->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPrice $product_price, $id=null)
    {
        if($id && $product_price->whereId($id)->exists())
        {
            $old_label = $product_price->whereId($id)->first();
            //
            $validator = [
                "price_label_id"  => "required",
                "product_id"      => "required",
                "unit_id"         => "required",
                "price"           => "required",
            ];
            // DATA VALIDATION
            $validator = Validator::make($request->all(), $validator);
            // 
            if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
            // CATCH ALL DATA FROM REQUEST
            $data = $request->only("price_label_id","product_id","unit_id","price");
            // 
            return response()->json($product_price->whereId($id)->update($data));
        }
        else response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductPrice $product_price, $id=null)
    {
        if($id){
            return response()->json($product_price->whereId($id)->delete());
        }
        else response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }
}

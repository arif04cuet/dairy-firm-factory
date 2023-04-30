<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator, DB;
use App\Models\Product\{Product, ProductUnit};
use Illuminate\Http\Request;

trait UnitTrait
{
    /**
     * A listing of the resource of Unit Model.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function unitList($request)
    {
    	$unit = new ProductUnit();
    	//
        if($request->select){
            $unit = $unit->select($request->select);
        }
        // 
        $where = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($unit, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function unitStore($request){
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "unit_name" => "required|unique:product_units,unit_name",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only("unit_name");
        // 
        return response()->json(ProductUnit::create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unitUpdate($request, $id=null)
    {
        if($id){
            $old_unit = ProductUnit::whereId($id)->first();
            // DATA VALIDATION
            if($old_unit->unit_name!=$request->unit_name){
                $validator = Validator::make($request->all(), [
                    "unit_name" => "required|unique:product_units,unit_name",
                ]);
                if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
            }

            // CATCH ALL DATA FROM REQUEST
            $data = $request->only("unit_name");
            // 
            return response()->json(ProductUnit::whereId($id)->update($data));
        }
        return response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }

    /**
     * A listing of the resource of Unit Model.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productWiseUnit ($product_id=null)
    {
    	$products = DB::table('product_units')
    	->join('product_prices', 'product_prices.unit_id', '=', 'product_units.id')
    	->groupBy('product_units.id')
    	->select('product_units.*');
    	//
    	$products = $products->where('product_prices.product_id', $product_id);
    	//
    	return $products->get();
    }
}
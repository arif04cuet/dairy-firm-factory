<?php

namespace App\Http\Controllers\Api\ProcessingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\ProductStock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, ProductStock $product_stock, $type=null)
    {
        if($request->select){
            $product_stock = $product_stock->select($request->select);
        }
        if($request->groupBy){
            $product_stock = $product_stock->groupBy($request->groupBy);
        }
        // 
        $where = where($request->where);
        if($type){
            $where['stockable_type'] = $type;
        }
        // MAKE PAGINATED DATA
        $data = paginate($product_stock, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }
}

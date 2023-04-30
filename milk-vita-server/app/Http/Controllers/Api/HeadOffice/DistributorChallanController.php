<?php

namespace App\Http\Controllers\Api\HeadOffice;



use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\DistributorDemand;
use App\Models\ShopOrderItem;
use App\Models\Product\ProductStock;
use App\Models\DistributorDemandItem, DB;

class DistributorChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, DistributorDemand $demand)
    {
        //
        if($request->select){
            $demand = $demand->select($request->select);
        }
        // 
        $where = where($request->where);
        $where['is_challan'] = 1;

        if($request->user()->role_slug=='distributor')
            $where['distributor_id'] = $request->user()->id;
        else
            $where['challan_creator_id'] = $request->user()->id;
        //
        $demand = $demand->with('distributor');


        // ->where('received_processing_plant_id', $request->user()->processing_plant_id)
        // ->orWhere('received_processing_plant_id', '');


        // MAKE PAGINATED DATA
        $data = paginate($demand, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DistributorDemand $demand)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "demand_id"             => "required",
            "items"                 => "required|array|min:1",
            "items.*.id"            => "required",
            "items.*.price"         => "required",
            "items.*.unit_id"       => "required",
            "items.*.cat_id"        => "required",
            "items.*.product_id"    => "required",
            "items.*.quantity"      => "required|min:1",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        //
        $demand = DistributorDemand::whereId($request->demand_id)->update(
        [
            'is_challan'         => 1,
            'challan_date'       => date('Y-m-d'),
            'challan_creator_id' => $request->user()->id,
            'status'             => 'challan-submit'
        ]);

        //
        $items = collect($request->items)->map(function($e) use ($request)
        {
            $item = collect($e)->only('unit_id', 'cat_id', 'product_id', 'quantity', 'price');
            //
            DistributorDemandItem::where([
                'demand_id' => $request->demand_id,
                'id'        => $e['id'],
            ])
            ->update([
                "challan_quantity"  => $e['quantity'],
                "price"             => $e['price'],
                "challan_date"      => date('Y-m-d'),
            ]);


            /* 
             * ************************
             * FINISH PRODUCT STOCK MANAGEMENT
             * ********************* */
            $where_stock = [
                'stockable_type' => "finish-product", 
                'stockable_id'   => $request->user()->processing_plant_id,
                'product_id'     => $e['product_id'],
                'unit_id'        => $e['unit_id'],
            ];
            //
            $stock = ProductStock::where($where_stock)->first();
            ProductStock::where($where_stock)->update(['quantity' => (+($stock->quantity ?? 0) - (0+$e['quantity']))]);
            // ** //
            return $item;
        });

        return $request->demand_id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DistributorDemand $demand, $demand_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "demand_id"             => "required",
            "items"                 => "required|array|min:1",
            "items.*.unit_id"       => "required",
            "items.*.cat_id"        => "required",
            "items.*.product_id"    => "required",
            "items.*.quantity"      => "required|min:1",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        
        // DELETE ALL OLD ITEMS
        DB::table('distributor_demand_items')->delete();
        // 
        $items = collect($request->items)->map(function($e) use ($demand_id)
        {
            $item = collect($e)->only('unit_id', 'cat_id', 'product_id', 'quantity');
            $item['demand_id'] = $demand_id;
            $item['date']      = date('Y-m-d');
            //
            DistributorDemandItem::create($item->toArray());
            //
            return $item;
        });
        return $demand_id;
    }

    public function destroy(Request $request, DistributorDemand $order, $demand_id)
    {
        DistributorDemandItem::where('demand_id', $demand_id)->limit(500)->delete();
        return DistributorDemand::whereId($demand_id)->delete();
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, DistributorDemand $demand, $id)
    {
        //
        $demand = $demand->where('id', $id)
        ->with(
            [
                'items', 
                'distributor',
                'challan_creator'
            ]
        )->first();
        //
        return response()->json($demand);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\DistributorDemand;
use App\Models\ShopOrderItem;
use App\Models\DistributorDemandItem, DB;

class DistributorDemandController extends Controller
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
        $where['is_challan'] = 0;
        //
        if($request->user()->role_slug=="distributor"){
            $where['distributor_id'] = $request->user()->id;
        }


        // MAKE PAGINATED DATA
        $data = paginate($demand->where('status', '!=', 'challan'), $where, $request->per_page, $request->page_no);
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
            "items"                 => "required|array|min:1",
            "items.*.unit_id"       => "required",
            "items.*.cat_id"        => "required",
            "items.*.product_id"    => "required",
            "items.*.quantity"      => "required|min:1",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $demand = DistributorDemand::create(
        [
            'distributor_id' => $request->user()->id,
            'voucher_no'     => mkVoucherNo($demand, 'voucher_no'),
            'date'           => date('Y-m-d'),
        ]);
        // 
        $items = collect($request->items)->map(function($e) use ($demand)
        {
            $item = collect($e)->only('unit_id', 'cat_id', 'product_id', 'quantity');
            $item['demand_id'] = $demand->id;
            $item['date']      = date('Y-m-d');
            //
            DistributorDemandItem::create($item->toArray());
            //
            return $item;
        });

        // ------------------------------------------------- //
        $shops = DB::table('distributor_shop_maps')->where('distributor_id', $request->user()->id)->pluck('shop_id');
        //
        $items = ShopOrderItem::groupBy(['product_id', 'unit_id'])
        ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
        ->select(
            'shop_order_items.*',
            DB::raw("SUM(quantity) AS quantity")
        )
        ->groupBy('shop_order_items.id')
        ->where([
            'shop_order_items.is_receive_as_demand' => 0,
        ])
        ->whereIn('shop_orders.shop_id', $shops)
        ->get();

        foreach($items as $item){
            ShopOrderItem::whereId($item->id)->update(['is_receive_as_demand'=>1]);
        }
        // -------------------------------------------------- //

        return $demand->id;
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

    public function details(Request $request, DistributorDemand $demand, $id)
    {
        $demand = $demand->where('id', $id)
        ->with(
            [
                'items', 
                'distributor'
            ]
        )->first();
        //
        return response()->json($demand);
    }



    public function tag(Request $request)
    {
        $shops = DB::table('distributor_shop_maps')->where('distributor_id', $request->user()->id)->pluck('shop_id');
        //
        $items = ShopOrderItem::groupBy(['product_id', 'unit_id'])
        ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
        ->select(
            'shop_order_items.*',
            DB::raw("SUM(quantity) AS quantity")
        )
        ->groupBy('shop_order_items.product_id')
        // ->groupBy('shop_order_items.id')
        ->where([
            'shop_order_items.is_receive_as_demand' => 0,
        ])
        ->whereIn('shop_orders.shop_id', $shops)
        ->get();

        //
        return response()->json($items);
    }


    //
    public function challanReceive(Request $request, DistributorDemand $demand, $id)
    {
         DistributorDemand::where([
            "distributor_id" => $request->user()->id,
            "is_distributor_received" => 0,
            "id" =>  $id,
         ])
         ->update([
            "is_distributor_received" => 1,
            "distributor_received_date" => date("Y-m-d"),
            "status" => "challan-received"
         ]); 

         return 1;
    }
}

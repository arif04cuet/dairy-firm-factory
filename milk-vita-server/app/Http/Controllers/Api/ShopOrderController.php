<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem, DB;

class ShopOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, ShopOrder $order)
    {
        //
        if($request->select){
            $order = $order->select($request->select);
        }
        // 
        $where   = where($request->where);

        // CONDITION FOR DELIVERY BOY
        if($request->user()->role_slug=='delivery-man'){
            $where['user_id'] = $request->user()->id;
        }

        // CONDITION FOR DISTRIBUTOR
        if($request->user()->role_slug=='distributor'){
            $shops = DB::table('distributor_shop_maps')->where('distributor_id', $request->user()->id)->pluck('shop_id');
            $order = $order->whereIn('shop_id', $shops);
        }

        // MAKE PAGINATED DATA
        $data = paginate($order, $where, $request->per_page, $request->page_no);
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
            "shop_id"               => "required",
            "items"                 => "required|array|min:1",
            "items.*.unit_id"       => "required",
            "items.*.cat_id"        => "required",
            "items.*.product_id"    => "required",
            "items.*.quantity"      => "required|min:1",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}


        $order = ShopOrder::create(
        [
            'shop_id'     => $request->shop_id,
            'area_id'     => (Shop::whereId($request->shop_id)->first()->area_id ?? 0),
            'user_id'     => $request->user()->id,
            'voucher_no'  => mkVoucherNo((new ShopOrder()), 'voucher_no'),
            'date'        => date('Y-m-d'),
        ]);

        // 
        $items = collect($request->items)->map(function($e) use ($order)
        {
            $item = collect($e)->only('unit_id', 'cat_id', 'product_id', 'quantity');
            $item['order_id'] = $order->id;
            $item['date']     = date('Y-m-d');
            //
            ShopOrderItem::create($item->toArray());
            //
            return $item;
        });
        return $order->id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop, $order_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "shop_id"               => "required",
            "items"                 => "required|array|min:1",
            "items.*.unit_id"       => "required",
            "items.*.cat_id"        => "required",
            "items.*.product_id"    => "required",
            "items.*.quantity"      => "required|min:1",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}


        $order = ShopOrder::whereId($order_id)->update(
        [
            'shop_id'     => $request->shop_id,
            'area_id'     => (Shop::whereId($request->shop_id)->first()->area_id ?? 0),
        ]);

        // DELETE ALL OLD ITEMS
        DB::table('shop_order_items')->delete();

        // 
        $items = collect($request->items)->map(function($e) use ($order_id)
        {
            $item = collect($e)->only('unit_id', 'cat_id', 'product_id', 'quantity');
            $item['order_id'] = $order_id;
            $item['date']     = date('Y-m-d');
            //
            ShopOrderItem::create($item->toArray());
            //
            return $item;
        });
        return $order_id;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderPlace(Request $request, Shop $shop, $order_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "order_id"              => "required",
            "items"                 => "required|array|min:1",
            "items.*.id"            => "required",
            "items.*.unit_id"       => "required",
            "items.*.cat_id"        => "required",
            "items.*.product_id"    => "required",
            "items.*.quantity"      => "required|min:1",
            "items.*.price"         => "required|min:1",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}



        ShopOrder::whereId($order_id)->update(
        [
            'status'        => 'delivered',
            'delivery_date' => date('Y-m-d')
        ]);

        // 
        $items = collect($request->items)->map(function($e) use ($request)
        {
            $item = collect($e)->only('quantity', 'price');
            $item['delivery_date'] = date('Y-m-d');
            //
            ShopOrderItem::where('id', $e['id'])->update($item->toArray());
            //
            return $item;
        });
        return $order_id;
    }

    public function destroy(Request $request, ShopOrder $order, $order_id)
    {
        ShopOrderItem::where('order_id', $order_id)->limit(500)->delete();
        return ShopOrder::whereId($order_id)->delete();
    }

    public function details(Request $request, ShopOrder $order, $id)
    {
        $order = $order->where('id', $id)->with('items')->first();
        //
        return response()->json($order);
    }
}


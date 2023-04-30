<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ZoneMap, DB;
use App\Models\DistributorShopMap;

class DistributorShopMapController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $distributor_id)
    {
        DB::table('distributor_shop_maps')->where('distributor_id', $distributor_id)->delete();
        if(is_array($request->shops) && count($request->shops) > 0){
        $validator = Validator::make($request->all(), [
            "shops"                  => "required|array",
            "shops.*.shop_id"        => "required",
            "shops.*.area_id"        => "required",
            "shops.*.zone_id"        => "required",
            "shops.*.distributor_id" => "required|numeric|min:1",
        ]);
        //
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
            //
            \DB::table('zone_maps')->where('user_id', $distributor_id)->delete();
            
            ZoneMap::create([
                "zone_id" => ($request->shops[0]['zone_id']),
                "user_id" => $distributor_id
            ]);

            //
            foreach($request->shops as $row){
                $data = [
                    'distributor_id' => $distributor_id,
                    'shop_id'        => $row['shop_id'],  
                    'area_id'        => $row['area_id'],  
                    'zone_id'        => $row['zone_id'],  
                ];
                DistributorShopMap::create($data);
            }
        }
        //
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mapData(Request $request, $distributor_id)
    {
        $map_data = DistributorShopMap::where('distributor_id', $distributor_id)->get();
        //
        return response()->json([
            "area_ids" => array_keys(collect($map_data)->groupBy('area_id')->toArray()),
            "shop_ids" => array_keys(collect($map_data)->groupBy('shop_id')->toArray()),
            "zone_id"  => (array_keys(collect($map_data)->groupBy('zone_id')->toArray())[0]) ?? null,
        ]);
    }
}

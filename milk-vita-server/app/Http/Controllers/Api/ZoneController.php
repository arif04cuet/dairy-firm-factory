<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ZoneMap;
use App\Models\Zone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Zone $zone)
    {
        //
        if($request->select){
            $zone = $zone->select($request->select);
        }
        // 
        $where   = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($zone, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Zone $zone)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "processing_plant_id" => "required",
            "zone_name_bn"        => "required|unique:zones,zone_name_bn",
            "zone_name_en"        => "required|unique:zones,zone_name_en",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "zone_name_en",
            "zone_name_bn",
            "processing_plant_id",
        );
        // 
        return response()->json($zone->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone, $id)
    {
        // DATA VALIDATION
        $validator_field = ["processing_plant_id" => "required"];

        $old_zone = Zone::whereId($id)->first();
        if($old_zone->zone_name_bn!=$request->zone_name_bn){
            $validator_field['zone_name_bn'] = "required|unique:zones,zone_name_bn";
        }
        if($old_zone->zone_name_en!=$request->zone_name_en){
            $validator_field['zone_name_en'] = "required|unique:zones,zone_name_en";
        }
        $validator = Validator::make($request->all(), $validator_field);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "zone_name_en",
            "zone_name_bn",
            "processing_plant_id",
        );
        // 
        return response()->json($zone->where('id', $id)->update($data));
    }

    public function map(Request $request, ZoneMap $map)
    {
        //
        if($request->select){
            $map = $map->select($request->select);
        }
        // 
        $where   = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($map->select('user_id', 'zone_id'), $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function destroy(Request $request, Zone $zone, $id)
    {
        return Zone::whereId($id)->delete();
    }
}

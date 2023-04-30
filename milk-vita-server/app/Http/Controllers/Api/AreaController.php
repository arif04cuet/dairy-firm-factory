<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Area $area)
    {
        if($request->select){
            $area = $area->select($request->select);
        }
        // 
        $where = where($request->where);
        //
        if($request->whereIn && is_array($request->whereIn) && count($request->whereIn) > 0){
            $area = $area->whereIn(array_keys($request->whereIn)[0], $request->whereIn[array_keys($request->whereIn)[0]]);
        }
        // MAKE PAGINATED DATA
        $data = paginate($area, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Area $area)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "zone_id"      => "required",
            "division_id"  => "required",
            "district_id"  => "required",
            "upazila_id"   => "required",
            "union_id"     => "required",
            "area_name_bn" => "required|unique:areas,area_name_bn",
            "area_name_en" => "required|unique:areas,area_name_en",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "area_name_en",
            "area_name_bn",
            "zone_id",
            "division_id",
            "district_id",
            "upazila_id",
            "union_id",
        );
        //
        $data['area_details'] = json_encode(
        [
            "division" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        //
        return response()->json($area->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area, $id)
    {
        // DATA VALIDATION
        $validator_field = [
            "zone_id"      => "required",
            "division_id"  => "required",
            "district_id"  => "required",
            "upazila_id"   => "required",
            "union_id"     => "required",
        ];

        $old_area = Area::whereId($id)->first();
        if($old_area->area_name_bn!=$request->area_name_bn){
            $validator_field['area_name_bn'] = "required|unique:areas,area_name_bn";
        }
        if($old_area->area_name_en!=$request->area_name_en){
            $validator_field['area_name_en'] = "required|unique:areas,area_name_en";
        }
        $validator = Validator::make($request->all(), $validator_field);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "area_name_en",
            "area_name_bn",
            "zone_id",
            "division_id",
            "district_id",
            "upazila_id",
            "union_id",
        );
        //
        $data['area_details'] = json_encode(
        [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        // 
        return response()->json($area->where('id', $id)->update($data));
    }

    public function destroy(Request $request, Area $area, $id)
    {
        return Area::whereId($id)->delete();
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ChillingPlant;


class ChillingPlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, ChillingPlant $chilling_plant)
    {
        $where   = where($request->where);
        // $where[] = ['user_id', '=', $request->user()->id];

        // SELECTED ATTRIBUTE
        if($request->select){
            $chilling_plant = $chilling_plant->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($chilling_plant, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ChillingPlant $chilling_plant)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "chilling_plant_name" => "required",
            'division_id'   => 'required|integer',
            'district_id'   => 'required|integer',
            'upazila_id'    => 'required|integer',
            'union_id'      => 'required|integer',
            "full_address"  => "required",
            "stock_capacity"=> "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "chilling_plant_name",
            "processing_plant_id",
            "division_id", 
            "district_id", 
            "upazila_id", 
            "union_id",
            "full_address",
            "stock_capacity",
        );
        //
        $data['location_details'] = json_encode(
        [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        // 
        return response()->json($chilling_plant->create($data));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChillingPlant $chilling_plant, $plant_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "chilling_plant_name" => "required",
            'division_id'   => 'required|integer',
            'district_id'   => 'required|integer',
            'upazila_id'    => 'required|integer',
            'union_id'      => 'required|integer',
            "full_address"  => "required",
            "stock_capacity"=> "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "chilling_plant_name",
            "processing_plant_id",
            "division_id", 
            "district_id", 
            "upazila_id", 
            "union_id",
            "full_address",
            "stock_capacity",
        );
        //
        $data['location_details'] = json_encode(
        [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        // 
        return response()->json($chilling_plant->whereId($plant_id)->update($data));
    }
    /*
     * *********************
     *  STOCK CALCULATION
     * *********************
    */
    public function stock(Request $request, ChillingPlant $plant)
    {
        $stock = null;
        if($request->user()->chilling_plant_id){
            $stock = $plant->where('id', $request->user()->chilling_plant_id)->first()->milkStock()->first();
        }
        return response()->json($stock ?? ['amount'=>0]);
    }

    //
    public function destroy(Request $request, ChillingPlant $plant, $plant_id)
    {
        $plant = ChillingPlant::whereId($plant_id);
        if($plant->exists())
        {
            return $plant->delete();
        }
        else return response()->json(['errors'=>['Something is Wrong!']]);
    }
}

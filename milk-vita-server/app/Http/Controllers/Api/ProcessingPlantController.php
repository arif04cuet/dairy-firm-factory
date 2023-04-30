<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ProcessingPlant;
use App\Models\Entity;

class ProcessingPlantController extends Controller
{

    public function all(Request $request, ProcessingPlant $processing_plant)
    {
        //
        $where   = where($request->where);
        //
        if($request->select)
            $processing_plant = $processing_plant->select($request->select);
        // MAKE PAGINATED DATA
        $processing_plant = $processing_plant->with(['division:id,bn_name', 'district:id,bn_name', 'thana:id,bn_name']);
        //
        $processing_plant = paginate($processing_plant, $where, $request->per_page, $request->page_no);
        //
        return response()->json($processing_plant);
    }

    public function store(Request $request, ProcessingPlant $processing_plant)
    {
        //
        $validator = Validator::make($request->all(), [
            'processing_plant_name' => 'required|unique:processing_plants,processing_plant_name',
            'division_id'           => 'required|integer',
            'district_id'           => 'required|integer',
            'upazila_id'            => 'required|integer',
            'union_id'              => 'required|integer',
        ]);
        //
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $data = $request->only('system_id', 'entity_id', 'division_id', 'district_id', 'upazila_id', 'union_id', 'processing_plant_name', 'full_address', 'longitude', 'latitude');
        $data['entity_id'] = (Entity::where('slug', 'processing-plant')->first()->id ?? 0);
        
        $data['location_details'] = json_encode(
        [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        //
        return response()->json($processing_plant->create($data));
    }

    public function update(Request $request, ProcessingPlant $processing_plant, $id)
    {
        $validator = Validator::make($request->all(), [
            'processing_plant_name' =>'required',
            'division_id'           => 'required|integer',
            'district_id'           => 'required|integer',
            'upazila_id'            => 'required|integer',
            'union_id'              => 'required|integer',
        ]);
        //
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $data = $request->only('division_id', 'district_id', 'upazila_id', 'union_id', 'processing_plant_name', 'full_address', 'longitude', 'latitude');
        $data['location_details'] = json_encode(
        [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        //
        $processing_plant = $processing_plant->whereId($id);
        //
        if(!$processing_plant->get()->isEmpty()){
            return response()->json($processing_plant->update($data));
        }
        else {
            return response()->json(['erros'=>['Something is wrong!! please try again']]);
        }
    }
}

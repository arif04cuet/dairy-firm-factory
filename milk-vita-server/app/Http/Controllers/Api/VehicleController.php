<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle, DB;

class VehicleController extends Controller
{
    public function all(Request $request, Vehicle $vehicle)
    {
        $where = where($request->where);
        //
        if($request->user()->processing_plant_id) $where['processing_plant_id'] = $request->user()->processing_plant_id;

        if($request->type=='bulk-check'){
            $vehicle = $vehicle->whereNotIn('id',
                DB::table('milk_challan_bulks')->where([
                    'is_receive'=>0,
                    'processing_plant_id'=>$request->user()->processing_plant_id
                ])->pluck('milk_challan_bulks.vehicle_id')
            );
        }

        // MAKE PAGINATED DATA
        $vehicles = paginate($vehicle->with(['category:id,vehicle_category_name', 'processingPlant:id,processing_plant_name']), $where, $request->per_page, $request->page_no);
        //
        return response()->json($vehicles);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $validator = Validator::make($request->all(), [
            'model_no'            => 'required',
            'vat_no'              => 'required|unique:vehicles,vat_no',
            'processing_plant_id' => 'required|integer',
            'vehicle_category_id' => 'required|integer',
        ]);

        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $vehicle->create($request->only('model_no', 'vat_no', 'system_id', 'processing_plant_id', 'vehicle_category_id'));

        return response()->json($vehicle->get());
    }

    public function update(Request $request, Vehicle $vehicle, $id)
    {
        $validator = Validator::make($request->all(), [
            'model_no'            => 'required',
            'vat_no'              => 'required|unique:vehicles,vat_no',
            'processing_plant_id' => 'required|integer',
            'vehicle_category_id' => 'required|integer'
        ]);

        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only('model_no', 'vat_no', 'system_id', 'processing_plant_id', 'vehicle_category_id');
        $vehicle = $vehicle->find($id);
        //
        if(!$vehicle->get()->isEmpty()){
            return response()->json($vehicle->update($data));
        }
        else {
            return response()->json(['erros'=>['Something is wrong!! please try again']]);
        }
    }
}

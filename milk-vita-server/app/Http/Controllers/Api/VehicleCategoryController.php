<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VehicleCategory;

class VehicleCategoryController extends Controller
{
    public function all(Request $request, VehicleCategory $vehicle_category)
    {
        $vehicle_category = $vehicle_category->where(where($request->where));
        return response()->json($vehicle_category->get());
    }

    public function store(Request $request, VehicleCategory $vehicle_category)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_category_name'=>'required||unique:vehicle_categories,vehicle_category_name'
        ]);
        
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $vehicle_category->create($request->only('vehicle_category_name'));

        return response()->json($vehicle_category->get());
    }

    public function update(Request $request, VehicleCategory $vehicle_category)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_category_name'=>'required'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        if($request->id){
            $vehicle_category->where('id', $request->id)->update($request->only('vehicle_category_name'));
            return response()->json($vehicle_category->get());
        }
        else {
            return response(['errors'=>['message'=>'Something Is Wrong!! Please Try Again..']], 200);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\RoadType;

class RoadTypeController extends Controller
{
    public function all(Request $request, RoadType $road_type)
    {
        return response()->json($road_type->get());
    }

    public function add(Request $request, RoadType $road_type)
    {
        $validator = Validator::make($request->all(), [
            'road_type_name'=>'required||unique:road_types,road_type_name'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $road_type->create($request->only('road_type_name'));
        return response()->json($road_type->get());
    }

    public function update(Request $request, RoadType $road_type)
    {
        $validator = Validator::make($request->all(), [
            'road_type_name'=>'required||unique:road_types,road_type_name'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        if($request->type_id){
            $road_type->where('id', $request->type_id)->update($request->only('road_type_name'));
            return response()->json($road_type->get());
        }
        else {
            return response(['errors'=>['message'=>'Something Is Wrong!! Please Try Again..']], 200);
        }
    }
}
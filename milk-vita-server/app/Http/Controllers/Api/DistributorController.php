<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Distributor $distributor)
    {
        //
        if($request->select){
            $distributor = $distributor->select($request->select);
        }
        // 
        $where   = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($distributor, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Distributor $distributor)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "zone_id"             => "required",
            "distributor_name_bn" => "required",
            "distributor_name_en" => "required",
            "distributor_mobile"  => "required|unique:distributors,distributor_mobile",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "zone_id",
            "distributor_name_bn",
            "distributor_name_en",
            "distributor_mobile",
            "distributor_address",
        );
        // 
        return response()->json($distributor->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distributor $distributor, $id)
    {
        // DATA VALIDATION
        $validator_field = [
            "zone_id"             => "required",
            "distributor_name_bn" => "required",
            "distributor_name_en" => "required",
        ];

        $old_distributor = Distributor::whereId($id)->first();
        if($old_distributor->distributor_mobile != $request->distributor_mobile){
            $validator_field['distributor_mobile'] = "required|unique:distributors,distributor_mobile";
        }
        //
        $validator = Validator::make($request->all(), $validator_field);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "zone_id",
            "distributor_name_bn",
            "distributor_name_en",
            "distributor_mobile",
            "distributor_address",
        );
        // 
        return response()->json($distributor->where('id', $id)->update($data));
    }

    public function destroy(Request $request, Distributor $distributor, $id)
    {
        return Distributor::whereId($id)->delete();
    }
}

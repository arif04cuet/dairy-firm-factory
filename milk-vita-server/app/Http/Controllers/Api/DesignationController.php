<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Designation $designation)
    {
        // 
        $where   = where($request->where);
        //
        if($request->select){
            $designation = $designation->select($request->select);
        }
        // MAKE PAGINATED DATA
        $data = paginate($designation, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Designation $designation)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "designation_name" => "required",
        ]);
        //
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "designation_name",
            "entity_id",
        );
        //
        return response()->json($designation->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation, $id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "designation_name" => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "designation_name",
            "entity_id",
        );
        // 
        return response()->json($designation->where('id', $id)->update($data));
    }
}

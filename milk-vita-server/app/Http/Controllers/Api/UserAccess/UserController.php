<?php

namespace App\Http\Controllers\Api\UserAccess;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\System;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, User $user)
    {   
        $where = where($request->where);
        // $where[] = ['user_id', '=', $request->user()->id];

        // SELECTED ATTRIBUTE
        if($request->select){
            $user = $user->select($request->select);
        }

        //
        if($request->type=='driver-processing-plant'){
            $user = $user->where(['role_id'=>Role::where('slug', 'driver-processing-plant')->first()->id]);

            if($request->user()->processing_plant_id){
                $user = $user->where(['processing_plant_id'=>$request->user()->processing_plant_id]);
            }
        }

        //
        if($request->slug && $request->slug!=''){
            $user = $user->where(['role_id'=>Role::where('slug', $request->slug)->first()->id]);
        }

        //
        $data = paginate($user->with('zoneIds'), $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }
}

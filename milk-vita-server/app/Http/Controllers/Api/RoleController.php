<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, Role $role)
    {
        $where = where($request->where);
        // $where[] = ['user_id', '=', $request->user()->id];

        // SELECTED ATTRIBUTE
        if($request->select){
            $role = $role->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($role, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'role_name'=>'required'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only('role_name', 'entity_id');
        $data['slug'] = strtolower(str_replace(' ', '_', $request->role_name));
        //
        $role = Role::create($data);
        //
        SendToDashboard('roles', [
            'roles'=> [
                [
                    "module_role_id"=> $role->id,
                    "name"          => $role->role_name,
                    "doptor_id"     => config('services.doptor_id')
                ]
            ]
        ]);
        //
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role, $role_id)
    {
        $validator = Validator::make($request->all(), [
            'role_name'=>'required'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        if($role_id){
            $data   = $request->only('role_name', 'entity_id');
            $result = $role->whereId($role_id)->update($data);
            return response()->json($result);
        }
        else {
            return response(['errors'=>['message'=>'Something Is Wrong!! Please Try Again..']], 200);
        }
    }


    /**
     * Sync All Role resource in Server Dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request, Role $role)
    {
        try{
            $roles = Role::get()->map(function($role){
                return [
                    "module_role_id" => $role->id,
                    "name"           => $role->role_name,
                    "doptor_id"      => config('services.doptor_id')
                ];

            })->toArray();
            //
            SendToDashboard('roles/sync', ['roles'=>$roles], 'POST');
            //
            return response(['success'=>true, 'message'=>'সকল রোল ড্যাশবোর্ডের সাথে সিঙ্ক হয়েছে']);
        }
        catch(Exception $error)
        {
            return response(['success'=>false, 'message'=>$error->getMessage()]);
        }
    }
}

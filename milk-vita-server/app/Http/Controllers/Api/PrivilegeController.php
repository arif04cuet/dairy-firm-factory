<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleWiseMenu;

class PrivilegeController extends Controller
{
    public function permitedMenus(Request $request){
        $where = where($request->where);

        $data = RoleWiseMenu::where($where)->first();
        return response()->json($data);
    }

    public function permitedMenuUpdate(Request $request){

        if($request->role_id){
            $response = RoleWiseMenu::updateOrCreate(
                ['role_id'=>$request->role_id],
                [
                    'menus'         => $request->menus,
                    'action_menus'  => $request->action_menus,
                    'role_id'       => $request->role_id
                ]
            );
            return response()->json($response);
        }
        else {
            return response()->json(['msg'=>'Somethings Is Wrong!!!']);
        }
        
        
    }
}

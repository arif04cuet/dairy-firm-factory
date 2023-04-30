<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Application;
use App\Models\User, Hash;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Application $application)
    {
        if($request->select && is_array($request->select)){
            $application = $application->select($request->select);
        }
        // 
        $where = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($application, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function distributorApplication(Request $request)
    {
        // DATA VALIDATION
        $validator_field = [
            "name_en" => "required",
            "name_bn" => "required",
            "type"    => "required",
            "email"   => "required|unique:applications,email|unique:users,email",
            "mobile"  => "required|unique:applications,mobile|unique:users,mobile",
            //
            'division_id'   => 'required|integer',
            'district_id'   => 'required|integer',
            'upazila_id'    => 'required|integer',
            'union_id'      => 'required|integer',
        ];

        //
        if($request->type=="shop"){
            $validator_field = array_merge($validator_field, [
                "shop_name_en"  => "required",
                "shop_name_bn"  => "required",
            ]);
        }

        $validator = Validator::make($request->all(), $validator_field);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        //
        $data = $request->only(
            "name_en",
            "name_bn",
            "mobile",
            "email",
            "division_id",
            "district_id",
            "upazila_id",
            "union_id",
            "remarks",
            "type",
        );

        $data['address_details'] = [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),
        ];

        $app_id = Application::create($data)->id;
        //
        if($request->type=='shop')
        {
            $data = array_merge($data, 
                array_merge($request->only("shop_name_en", "shop_name_bn"), [
                    "owner_name_bn"=>$request->name_bn,
                    "owner_name_en"=>$request->name_en,
                ])
            );
            //
            unset($data['name_bn']); unset($data['name_en']); unset($data['remarks']); unset($data['address_details']);
            //
            $data['app_id'] = $app_id;
            Shop::create($data);
        }
        return response()->json(1);
    }

    //
    public function view(Request $request, Application $application, $app_id=null)
    {
        if($app_id || $request->app_id)
            $app_id = ($app_id ? $app_id : $request->app_id);
        else 
            return response()->json(['errors'=>['Something is wrong!!']]);

        /////\\\/////////
        $application = $application::where('id', $app_id)->with(
            [
                'shop'=>function($query){
                    return $query->select('id', 'app_id', 'shop_name_bn', 'shop_name_en');
                },
                'user'=>function($query){
                    return $query->select('id', 'username');
                }
            ]
        )->first();

        return response()->json($application);
    }   

    //
    public function setStatus(Request $request, Application $application, $app_id=null)
    {
        if($app_id || $request->app_id)
        {
            $app_id = ($app_id ? $app_id : $request->app_id);
        }
        else 
        {
            return response()->json(['errors'=>['Something is wrong!!']]);
        }

        // 
        $validator = Validator::make($request->all(), ['status'=>'required']);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $application = Application::where('id', $app_id)->first();
        $role_id     = roleId($application->type);
        //

        if($application->status=='pending' && $role_id)
        {
            $id = User::create([
                "name_en"       => $application->name_en,
                "name_bn"       => $application->name_bn,
                "username"      => $application->mobile,
                "mobile"        => $application->mobile,
                "email"         => $application->email,
                "role_id"       => $role_id,
                "division_id"   => $application->division_id,
                "district_id"   => $application->district_id,
                "password"      => Hash::make(123456),
            ])->id;
            $application->update(['status'=>$request->status, 'user_id'=>$id]);
            //
            if($application->type=='shop'){
                Shop::where('app_id', $app_id)->update(['user_id'=>$role_id]);
            }
            return 1;
        }
        return response()->json(['errors'=>['Something is wrong!!']]);
    }
}

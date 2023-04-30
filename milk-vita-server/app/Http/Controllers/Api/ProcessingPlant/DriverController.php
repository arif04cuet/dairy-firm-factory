<?php

namespace App\Http\Controllers\Api\ProcessingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Role, DB;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Role $role)
    {
        $role = $role->with(['user'=>
            function($query) use ($request){
                $query->where(['trash'=>0, 'processing_plant_id'=>$request->user()->processing_plant_id])
                ->whereNotIn('id',
                    DB::table('milk_challan_bulks')->where([
                        'is_receive'=>0,
                        'processing_plant_id'=>$request->user()->processing_plant_id
                    ])->pluck('milk_challan_bulks.driver_id')
                );
            }
        ])->where(['slug'=>'driver-processing-plant'])->first();
        //
        return response()->json($role->user ?? []);
    }
}

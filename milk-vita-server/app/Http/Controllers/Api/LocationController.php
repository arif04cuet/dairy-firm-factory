<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Thana;

class LocationController extends Controller
{
    public function divisions(Request $request)
    {
        $where = where($request);
        //
        return response()->json(Division::where($where)->get());
    }
    public function districts(Request $request)
    {
        $where = where($request);
        //
        return response()->json(District::where($where)->get());
    }
    public function thanas(Request $request)
    {
        $where = where($request);
        //
        return response()->json(Thana::where($where)->get());
    }
    public function location(Request $request)
    {
        return response()->json(locationFromDashboard($request->all()));
    }
}

<?php

namespace App\Http\Controllers\Api\HeadOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistributorDemand, DB;

class DistributorDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, DistributorDemand $demand)
    {
        //
        if($request->select){
            $demand = $demand->select($request->select);
        }
        // 
        $where = where($request->where);


        // MAKE PAGINATED DATA
        $demand = $demand->with('distributor')
              ->where(function($query) use ($request){
                  $query->where('received_processing_plant_id', $request->user()->processing_plant_id)
                  ->orWhere('received_processing_plant_id', '');
              })
              ->where('is_challan', 0)
              ->whereIn(
                'distributor_id', 
                DB::table('zones')
                ->join('zone_maps', 'zones.id', 'zone_maps.zone_id')
                ->where('zones.processing_plant_id', $request->user()->processing_plant_id)
                ->pluck('zone_maps.user_id')
              );
        //
        $data = paginate($demand, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, DistributorDemand $demand, $id)
    {
        $demand = $demand->where('id', $id)
        ->with(
            [
                'items', 
                'distributor'
            ]
        )->first();
        //
        return response()->json($demand);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receive(Request $request, DistributorDemand $demand, $id)
    {
        DistributorDemand::whereId($id)->where('received_processing_plant_id', '=', 0)->update([
            'status'   => 'demand-received',
            'received_processing_plant_id'   => 1,
            'received_date_processing_plant' => date('Y-m-d')
        ]);
        return 1;
    }
}

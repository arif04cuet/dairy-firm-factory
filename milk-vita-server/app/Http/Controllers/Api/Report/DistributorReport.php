<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, DB;

class DistributorReport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function challan(Request $request)
    {
        $where = [];
        if($request->where){
            foreach($request->where as $key=>$value){
                if(is_array($value) && $key=='date'){
                    foreach($value as $entity=>$date)
                    {
                        if($date!='' && $entity=='from')
                            $where[] = ['distributor_demands.challan_date', '>=', $date];
                        if($date!='' && $entity=='to')
                            $where[] = ['distributor_demands.challan_date', '<=', $date];
                    }
                }
                else if($value!='' && $key!='date'){
                    $where['distributor_demands'.$key] = $value;
                }
            }
        }

        $type = $request->type;
        $type = ($type=='daily' ? '' : ($type=='monthly' ? 'MONTH' : 'YEAR'));
        $date = ($request->where && !is_array($request->where['date'])) ? $request->where['date'] : ($type=='' ? date('Y-m-d') : ($type=='MONTH' ? date('m') : date('Y')));

        //
        $support_query = ($type == "" ? "challan_date=date_for_challan" : ($type=='MONTH' ? "challan_date LIKE '{$date}%'" : "{$type}(challan_date)={$date}"));

        //
        $records = DB::table("distributor_demands")
        ->select(
            "distributor_demands.challan_date as date",
            "distributor_demands.challan_date as date_for_challan",
            DB::raw("COUNT(distributor_demands.id) AS total_challan"),
            DB::raw("EXTRACT(YEAR FROM distributor_demands.challan_date) as year"),
            DB::raw("EXTRACT(MONTH FROM distributor_demands.challan_date) as month"),
            //
            DB::raw("(SELECT sum(quantity) FROM distributor_demand_items WHERE demand_id IN         (SELECT id from distributor_demands WHERE {$support_query} AND deleted_at IS NULL )) AS total_demand_item"),
            DB::raw("(SELECT sum(challan_quantity) FROM distributor_demand_items WHERE demand_id IN (SELECT id from distributor_demands WHERE {$support_query} AND deleted_at IS NULL )) AS total_challan_item"),
        )
        ->groupBy(($type=='' ? "distributor_demands.challan_date" : DB::raw("SUBSTRING(distributor_demands.challan_date, 0, ".($type=='MONTH' ? 7 : 4).")")));


        //
        $records = ($type=='' ? $records->where($where) : $records->where('distributor_demands.challan_date', 'LIKE', $date.'%'));


        return response()->json(paginate($records, [], $request->per_page, $request->page_no));
    }
}

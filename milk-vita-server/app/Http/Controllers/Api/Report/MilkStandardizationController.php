<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MilkChallanBulk;
use App\Models\MilkChallanFromChillingPlant;

class MilkStandardizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, MilkChallanFromChillingPlant $challan)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){
            $challan = $challan->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($challan, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
}

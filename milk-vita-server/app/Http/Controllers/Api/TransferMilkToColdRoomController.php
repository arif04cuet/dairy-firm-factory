<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TransferMilkToColdRoom;
use App\Models\TransferMilkToColdRoomItem;


class TransferMilkToColdRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, TransferMilkToColdRoom $transfer)
    {
        if($request->select){
            $transfer = $transfer->select($request->select);
        }
        // 
        $where = where($request->where);
        $where['processing_plant_id'] = $request->user()->processing_plant_id;

        $data = paginate($transfer, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }


    public function store(Request $request, TransferMilkToColdRoom $transfer)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "date"            => "required",
            "code_no"         => "required",
            "temperature"     => "required",
            "total"           => "required|numeric",
            "total_cream_can" => "required|numeric",
            "total_cream"     => "required|numeric",
            "bulk_milk"       => "required|numeric",
            "grand_total"     => "required|numeric",
            "total_crate"     => "required|numeric",
            "total_packet"    => "required|numeric",
            //
            "items"           => "required|array",
            "items.*.type"    => "required",
            "items.*.unit"    => "required",
            "items.*.partial_column" => "required",
            "items.*.total_milk"     => "required",
            "items.*.total_packet"   => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        if($request->user()->processing_plant_id){
            $data             = $request->only("date","code_no","temperature","total","total_cream_can","total_cream","bulk_milk","grand_total","total_crate","total_packet");
            $data['user_id']  = $request->user()->id;
            $data['processing_plant_id']  = $request->user()->processing_plant_id;
            //
            $transfer_id = $transfer->create($data)->id;
            //
            $item_mode = new TransferMilkToColdRoomItem();
            //
            $request->collect('items')->map(function($item) use ($transfer_id, $request, $item_mode)
            {
                $data = collect($item)->only( "type", "unit", "partial_column", "total_milk", "total_packet")->toArray();
                $item_mode->create(
                    array_merge($data,
                    [
                        "transfer_id" => $transfer_id,
                        "date"        => $request->date
                    ])
                );
            });
        }
        else {
            return response()->json(['errors'=>['Permission Denied']]);
        }
        return response()->json($transfer_id);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, TransferMilkToColdRoom $transfer, $transfer_id)
    {
        $transfer = $transfer->whereId($transfer_id)->with('items')->first();

        return response()->json($transfer);
    }
}
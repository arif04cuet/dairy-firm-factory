<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\MilkStockTransfer, DB;
use Illuminate\Http\Request;

trait MilkStockTransferTrait
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static function milkTransactionList(MilkStockTransfer $milk_stock_transfer, Request $request)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){$challan = $milk_stock_transfer->select($request->select);}

        // 
        if($request->user()->role_slug!='superadmin') {$where['from_processing_plant_id'] = $request->user()->processing_plant_id;};

        // MAKE PAGINATED DATA
        $data = paginate($milk_stock_transfer, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function storeMilkTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
			"to_processing_plant_id" => "required",
			"sdr_liter" 		     => "required|numeric|min:1",
			"sdr_density" 		     => "required|numeric|min:1",
			"sdr_fat_persentase"     => "required|numeric",
			"sdr_snf_persentase"     => "required|numeric",
        ],
        [
        	"to_processing_plant_id.required" => "প্রসেসিং প্ল্যান্ট নির্বাচন করুন!",
        	"sdr_liter.required" => "দুধের পরিমানটা দিন!",
        	"sdr_liter.min" => "দুধের পরিমানটা দিন!",
        	"sdr_density.required" => "দুধের ঘনত্ব দি!",
        	"sdr_density.min" => "দুধের ঘনত্ব দি!",
        	"sdr_fat_persentase.required" => "দুধের ফ্যাট পার্সেন্টেজ(%) দিন!",
        	"sdr_snf_persentase.required" => "দুধের স.এন.ফ পার্সেন্টেজ(%) দিন!",
        ]);
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
        //
        $data 		  = $request->only( "sdr_liter", "sdr_density", "sdr_fat_persentase", "sdr_snf_persentase", "date");
        $data['date'] = $request->date ?? date('Y-m-d');
        //
        $data['sender_id'] 			 	  = $request->user()->id;
        $data['to_processing_plant_id']   = $request->to_processing_plant_id;
        $data['from_processing_plant_id'] = $request->user()->processing_plant_id;
        //
        $id = MilkStockTransfer::create($data)->id;

        return response()->json($id);
    }


    /**
     * Update a specific item resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function updateMilkTransaction(MilkStockTransfer $milk_stock_transfer, Request $request, $transfer_id=null)
    {
        $validator = Validator::make($request->all(), [
			"to_processing_plant_id" => "required",
			"sdr_liter" 		  => "required|numeric|min:1",
			"sdr_density" 		  => "required|numeric|min:1",
			"sdr_fat_persentase"  => "required|numeric",
			"sdr_snf_persentase"  => "required|numeric",
        ],
        [
        	"to_processing_plant_id.required" => "প্রসেসিং প্ল্যান্ট নির্বাচন করুন!",
        	"sdr_liter.required" => "দুধের পরিমানটা দিন!",
        	"sdr_liter.min"      => "দুধের পরিমানটা দিন!",
        	"sdr_density.required" => "দুধের ঘনত্ব দি!",
        	"sdr_density.min" => "দুধের ঘনত্ব দি!",
        	"sdr_fat_persentase.required" => "দুধের ফ্যাট পার্সেন্টেজ(%) দিন!",
        	"sdr_snf_persentase.required" => "দুধের স.এন.ফ পার্সেন্টেজ(%) দিন!",
        ]);
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}

        //
        $transfer = MilkStockTransfer::where([
            "id" => $transfer_id,
            "is_receive" => 0,
            "from_processing_plant_id" => $request->user()->processing_plant_id,
        ]);

        if($transfer->get()->isEmpty() || ($transfer_id==null && !$request->transfer_id))
        	return response(['errors' => ['প্রক্রিয়াটি অননুমোদিত']], 200);
        //
        $data 		  = $request->only( "sdr_liter", "sdr_density", "sdr_fat_persentase", "sdr_snf_persentase", "date");
        $data['date'] = $request->date ?? date('Y-m-d');
        //
        $data['to_processing_plant_id'] = $request->to_processing_plant_id;
        //
        $transfer_id = ($request->transfer_id ?? $transfer_id);
        //
        $transfer->update($data);
        //
        return response()->json($transfer_id);
    }

    /**
     * Update a specific item resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function milkTransactionReceiveConfirm(MilkStockTransfer $milk_stock_transfer, Request $request, $transfer_id=null)
    {
        $validator = Validator::make($request->all(), [
			"rvr_liter" 		  => "required|numeric|min:1",
			"rvr_density" 		  => "required|numeric|min:1",
			"rvr_fat_persentase"  => "required|numeric",
			"rvr_snf_persentase"  => "required|numeric",
        ],
        [
        	"rvr_liter.required" 		  => "দুধের পরিমানটা দিন!",
        	"rvr_liter.min" 			  => "দুধের পরিমানটা দিন!",
        	"rvr_density.required" 		  => "দুধের ঘনত্ব দি!",
        	"rvr_density.min" 			  => "দুধের ঘনত্ব দি!",
        	"rvr_fat_persentase.required" => "দুধের ফ্যাট পার্সেন্টেজ(%) দিন!",
        	"rvr_snf_persentase.required" => "দুধের স.এন.ফ পার্সেন্টেজ(%) দিন!",
        ]);
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
        //
        $transfer_id = ($request->transfer_id ?? $transfer_id);
        //
        $transaction = MilkStockTransfer::where([
        	"id" => $transfer_id,
        	"to_processing_plant_id" => $request->user()->processing_plant_id,
        ]);
        //
        if($transfer_id==null && !$request->transfer_id && !$transaction->get()->isEmpty())
        	return response(['errors' => ['প্রক্রিয়াটি অননুমোদিত']], 200);
        //
        $data = $request->only("rvr_liter", "rvr_density", "rvr_fat_persentase", "rvr_snf_persentase");
        $data['receive_date'] = $request->date ?? date('Y-m-d');
        $data['receiver_id']  = $request->user()->id;
        $data['is_receive']   = 1;
        //
        MilkStockTransfer::whereId($transfer_id)->update($data);
        //
        return response()->json($transfer_id);
    }

    /**
     * Update a specific item resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function milkTransactionReceiveList(MilkStockTransfer $milk_stock_transfer, Request $request, $transfer_id=null)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){$challan = $milk_stock_transfer->select($request->select);}

        // 
        if($request->user()->role_slug!='superadmin') {$where['to_processing_plant_id'] = $request->user()->processing_plant_id;};

        // MAKE PAGINATED DATA
        $data = paginate($milk_stock_transfer, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function milkStockDetails (MilkStockTransfer $milk_stock_transfer, Request $request, $transfer_id=null)
    {
    	if(!$request->transfer_id && $transfer_id==null)
    		return response(['errors' => ['ট্রান্সফার আইডি সঠিক নয়']], 200);
    	//
    	$record = $milk_stock_transfer->whereId(($request->transfer_id ?? $transfer_id))->with(['sender', 'receiver'])->first();
    	//
    	return response()->json($record);
    }


}
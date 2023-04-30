<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\MilkStockTransfer, DB;
use Illuminate\Http\Request;
use App\Models\{
	ProductStockTransfer, ProductStockTransferItem, ProcessingPlant
};

trait ProductStockTransferTrait
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static function productTransactionList(ProductStockTransfer $challan, Request $request)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){$challan = $challan->select($request->select);}

        // 
        if(isRoleSlug('superadmin')) {$where['from_processing_plant_id'] = $request->user()->processing_plant_id;};

        // MAKE PAGINATED DATA
        $data = paginate($challan, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function storeProductTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
			"to_processing_plant_id" => "required",
			"items" 				 => "required",
			"items.*.quantity" 		 => "required|numeric|min:1",
			"items.*.quantity_litre" 	 => "required|numeric|min:1",
			"items.*.density" 		 => "required|numeric|min:0.1",
			"items.*.fat_persentase" => "required|numeric",
			"items.*.snf_persentase" => "required|numeric",
        ],
        [
        	"to_processing_plant_id.required" => "প্রসেসিং প্ল্যান্ট নির্বাচন করুন!",
        	"items.*.quantity.required" 		=> "দুধের পরিমানটা দিন!",
        	"items.*.quantity.min" 				=> "দুধের পরিমানটা দিন!",        	
        	"items.*.quantity_litre.required" 		=> "দুধের পরিমানটা (লিটার) দিন!",
        	"items.*.quantity_litre.min" 			=> "দুধের পরিমানটা (লিটার) দিন!",
        	"items.*.density.required" 			=> "দুধের ঘনত্ব দি!",
        	"items.*.density.min" 				=> "দুধের ঘনত্ব দি!",
        	"items.*.fat_persentase.required" 	=> "দুধের ফ্যাট পার্সেন্টেজ(%) দিন!",
        	"items.*.snf_persentase.required" 	=> "দুধের স.এন.ফ পার্সেন্টেজ(%) দিন!",
        ]);
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}

        $challan = [
			'date' 					   => $request->date ?? date('Y-m-d'),
	        'sender_id' 			   => $request->user()->id,
	        'to_processing_plant_id'   => $request->to_processing_plant_id,
	        'from_processing_plant_id' => $request->user()->processing_plant_id,
	        'voucher_no' 			   => time(),
        ];
        $challan = ProductStockTransfer::create($challan);


        //
        $data = collect($request->items)->map(function($item) use ($challan){
        	//
        	$item = collect($item)->only('quantity_litre', 'quantity_kg', 'fat_kg', 'snf_kg', 'quantity', 'density', 'snf_persentase', 'fat_persentase', 'unit_id', 'product_id')->toArray();
        	$item['trx_id'] = $challan->id;
        	ProductStockTransferItem::create($item);
        });
        //
        return response()->json($challan);

    }


    /**
     * Update a specific item resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function updateProductTransaction(MilkStockTransfer $milk_stock_transfer, Request $request, $transfer_id=null)
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
    static function productTransactionReceiveConfirm(Request $request, ProductStockTransfer $challan, $trx_id=null)
    {
        $challan = ProductStockTransfer::where(["id"=>$trx_id, "is_receive"=>0])->with("items");
        //
        if($challan->exists() && $items = $challan->first()->items)
        {
            foreach($items as $item)
            {
                $where_stock = [
                    "product_id"  => $item->product_id,
                    "unit_id"     => $item->unit_id,
                ];

                $stock = ProcessingPlant::find($request->user()->processing_plant_id)
                ->productStock()
                ->where($where_stock)
                ->first();

                ProcessingPlant::find($request->user()->processing_plant_id)
                ->productStock()
                ->updateOrCreate(
                    $where_stock,
                    array_merge($where_stock,["quantity" => ($item->quantity + ($stock->quantity ?? 0))])
                );
            }
            $challan->update([
                "receiver_id" => $request->user()->id,
                "is_receive" => 1,
                "receive_date" => date("Y-m-d")
            ]);
            //
            return response()->json(1);
        }
        else {
            return response()->json(["errors"=>["অনুরোধটি গ্রহণ করা যাচ্ছে না"]], 200);
        }
    }

    /**
     * Update a specific item resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function productTransactionReceiveList(Request $request, ProductStockTransfer $challan)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){$challan = $challan->select($request->select);}

        // 
        if(isRoleSlug('superadmin')) {$where['to_processing_plant_id'] = $request->user()->processing_plant_id;};

        // MAKE PAGINATED DATA
        $data = paginate($challan, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productStockDetails (ProductStockTransfer $record, Request $request, $transfer_id=null)
    {
    	if(!$request->transfer_id && $transfer_id==null)
    		return response(['errors' => ['ট্রান্সফার আইডি সঠিক নয়']], 200);
    	//
    	$record = $record->whereId(($request->transfer_id ?? $transfer_id))->with(['sender', 'receiver', 'items'])->first();
    	//
    	return response()->json($record);
    }


}
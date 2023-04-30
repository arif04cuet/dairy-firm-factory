<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\FinishProductQCBulk;
use App\Models\Product\FinishProductQCBulkItem;
use App\Models\Product\Product, DB;
use App\Models\ProcessingPlant;
use App\Models\Product\ProductStock;
use App\Http\Resources\ProductCollection;
use App\Traits\ProductTrait;

class FinishProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, FinishProductQCBulk $bulk_model)
    {
        if($request->select){
            $bulk_model = $bulk_model->select($request->select);
        }
        // 
        $where = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($bulk_model, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    //
	public function makeProductionItem(Request $request)
	{
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "unit_id"    => "required|exists:product_units,id",
            "product_id" => "required|exists:products,id",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        //
        return response()->json(ProductTrait::finishProductFormat($request->product_id, $request->unit_id));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FinishProductQCBulk $bulk_model)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "items"                  => "required",
            "items.*.product_id"     => "required",
            "items.*.unit_id"        => "required",
            "items.*.quantity"       => "required|numeric|min:1",
            "items.*.pro_liter"      => "required|numeric|min:1",
            "items.*.density"        => "required|numeric|min:1",
            "items.*.fat_persentase" => "required|numeric|min:1",
            "items.*.snf_persentase" => "required|numeric|min:1",
        ], 
        [
            "items.*.quantity.min"     => "Quantity number should be at least 1",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //

        if($request->user()->processing_plant_id && (is_array($request->items) && count($request->items) > 0))
        {
            $finish_data = [
                "processing_plant_id" => $request->user()->processing_plant_id,
                "voucher_no" => mkVoucherNo($bulk_model),
                "user_id"    => $request->user()->id,
                "date"       => date("Y-m-d")
            ];
            $finish_data = FinishProductQCBulk::create($finish_data);
            //
            foreach($request->items as $item)
            {

                $item['pro_kg'] = ($item['pro_liter'] * $item['density']);
                $item['fat_kg'] = (($item['pro_kg'] / 100) * $item['fat_persentase']);
                $item['snf_kg'] = (($item['pro_kg'] / 100) * $item['snf_persentase']);

                $item_data = [
                    "processing_plant_id" => $request->user()->processing_plant_id,
                    "qc_bulk_id" => $finish_data->id,
                    "user_id"    => $request->user()->id,
                    "date"       => date("Y-m-d"), 
                    //
                    "product_id"     => $item['product_id'],
                    "unit_id"        => $item['unit_id'],
                    "quantity"       => $item['quantity'],
                    "pro_liter"      => $item['pro_liter'],
                    "density"        => $item['density'],
                    "fat_persentase" => $item['fat_persentase'],
                    "snf_persentase" => $item['snf_persentase'],
                    //
                    "pro_kg" => $item["pro_kg"],
                    "fat_kg" => $item["fat_kg"],
                    "snf_kg" => $item["snf_kg"],
                ];
                //
                FinishProductQCBulkItem::create($item_data);
                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                $stock = ProductStock::where([
                    'stockable_type' => "finish-product", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'product_id'     => $item['product_id'],
                    'unit_id'        => $item['unit_id'],
                ]);
                //
                ProductStock::updateOrCreate(
                    [
                        'stockable_type' => "finish-product", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $item['product_id'],
                        'unit_id'        => $item['unit_id'],
                    ],
                    [
                        'stockable_type' => "finish-product", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'quantity'   => (+($stock->first()->quantity ?? 0) + (0+$item['quantity'])),
                        'product_id' => $item['product_id'],
                        'unit_id'    => $item['unit_id'],
                    ]
                );
                // ** //
            };
            return $finish_data->id;
        }
        else return response()->json(['errors'=>['আপনি অনুমোদিত ব্যবহারকারী নন!!']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinishProductQCBulk $bulk_model, $bulk_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "items"                  => "required",
            "items.*.product_id"     => "required",
            "items.*.unit_id"        => "required",
            "items.*.quantity"       => "required|numeric|min:1",
            "items.*.pro_liter"      => "required|numeric|min:1",
            "items.*.density"        => "required|numeric|min:1",
            "items.*.fat_persentase" => "required|numeric|min:1",
            "items.*.snf_persentase" => "required|numeric|min:1",
        ], 
        [
            "items.*.quantity.min"     => "Quantity number should be at least 1",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //


        if($request->user()->processing_plant_id && $bulk_id && (is_array($request->items) && count($request->items) > 0))
        {
            if(FinishProductQCBulk::whereId($bulk_id)->exists())
            {
                /* 
                 * *****************
                 * MILK STOCK OUT
                 * *************** */
                $old_items = FinishProductQCBulkItem::where('qc_bulk_id', $bulk_id)->get();
                foreach($old_items as $row){
                    /* 
                     * *****************
                     * MILK STOCK OUT
                     * *************** */
                    $stock = ProductStock::where([
                        'stockable_type' => "finish-product", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $row->product_id,
                        'unit_id'        => $row->unit_id,
                    ]);
                    //
                    ProductStock::updateOrCreate(
                        [
                            'stockable_type' => "finish-product", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'product_id'     => $row->product_id,
                            'unit_id'        => $row->unit_id,
                        ],
                        [
                            'stockable_type' => "finish-product", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'quantity'       => (($stock->first()->quantity ?? 0)  - ($row->quantity)),
                            'product_id'     => $row->product_id,
                            'unit_id'        => $row->unit_id,
                        ]
                    );
                    // ** //
                }

                /* -------------------------------------------------------------------------------------------*/ 
                \DB::table("finish_product_q_c_bulk_items")->where('qc_bulk_id', $bulk_id)->delete();
                foreach($request->items as $item)
                {
                    $item['pro_kg'] = ($item['pro_liter'] * $item['density']);
                    $item['fat_kg'] = (($item['pro_kg'] / 100) * $item['fat_persentase']);
                    $item['snf_kg'] = (($item['pro_kg'] / 100) * $item['snf_persentase']);

                    $item_data = [
                        "processing_plant_id" => $request->user()->processing_plant_id,
                        "qc_bulk_id" => $bulk_id,
                        "user_id"    => $request->user()->id,
                        "date"       => date("Y-m-d"), 
                        //
                        "product_id"     => $item['product_id'],
                        "unit_id"        => $item['unit_id'],
                        "quantity"       => $item['quantity'],
                        "pro_liter"      => $item['pro_liter'],
                        "density"        => $item['density'],
                        "fat_persentase" => $item['fat_persentase'],
                        "snf_persentase" => $item['snf_persentase'],
                        //
                        "pro_kg" => $item["pro_kg"],
                        "fat_kg" => $item["fat_kg"],
                        "snf_kg" => $item["snf_kg"],
                    ];
                    //
                    FinishProductQCBulkItem::create($item_data);
                    /* 
                     * *****************
                     * MILK STOCK IN
                     * *************** */
                    $stock = ProductStock::where([
                        'stockable_type' => "finish-product", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $item['product_id'],
                        'unit_id'        => $item['unit_id'],
                    ]);
                    //
                    ProductStock::updateOrCreate(
                        [
                            'stockable_type' => "finish-product", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'product_id'     => $item['product_id'],
                            'unit_id'        => $item['unit_id'],
                        ],
                        [
                            'stockable_type' => "finish-product", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'quantity'   => (+($stock->first()->quantity ?? 0) + (0+$item['quantity'])),
                            'product_id' => $item['product_id'],
                            'unit_id'    => $item['unit_id'],
                        ]
                    );
                    // ** // 
                };
            }
            //
            return $bulk_id;
        }
        else return response()->json(['errors'=>['Something is Wrong!!']]);
    }   


    //
    public function view(Request $request, FinishProductQCBulk $bulk_model, $bulk_id)
    {
        if($bulk_id && $request->user()->processing_plant_id){
            //
            $where = [
                "processing_plant_id" => $request->user()->processing_plant_id,
                "id"                  => $bulk_id,
                "user_id"             => $request->user()->id,
            ];
            //
            $bulk_model = $bulk_model->where($where)->with("items")->first();

            $bulk = collect($bulk_model)->only('user_name', 'processing_plant_name', 'voucher_no', 'date', 'id');
            $bulk['items'] = collect($bulk_model->items)->map(function($item){
                unset($item['created_at']);
                unset($item['deleted_at']);
                unset($item['updated_at']);
                return $item;
            });
            //
            return response()->json($bulk);
        }
        else 
            return response()->json(["errors"=>["bulk_model id is required"]]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $qc_bulk_id)
    {
        $qc_bulk = FinishProductQCBulk::where([
            "user_id" => $request->user()->id,
            "id"      => $qc_bulk_id
        ]);
        //
        if($qc_bulk->exists())
        {
            $items = FinishProductQCBulkItem::where("qc_bulk_id", $qc_bulk->first()->id);
            //
            foreach($items->get() as $key=>$item)
            {
                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                $stock = ProductStock::where([
                    'stockable_type' => "finish-product", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'product_id'     => $item->product_id,
                    'unit_id'        => $item->unit_id,
                ]);
                //
                ProductStock::updateOrCreate(
                    [
                        'stockable_type' => "finish-product", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $item->product_id,
                        'unit_id'        => $item->unit_id,
                    ],
                    [
                        'stockable_type' => "finish-product", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'quantity'       => (($stock->first()->quantity ?? 0)  - ($item->quantity)),
                        'product_id'     => $item->product_id,
                        'unit_id'        => $item->unit_id,
                    ]
                );
                // ** //
                FinishProductQCBulkItem::whereId($item->id)->delete();
            }
            $qc_bulk->delete();
            return 1;
        }
        else {
            return response()->json(['errors'=>['Something is Wrong!!']]);
        }
    }

    public function itemDelete(Request $request, $item_id)
    {
        $where = [
            "processing_plant_id" => $request->user()->processing_plant_id,
            "id"=>$item_id
        ];
        //
        $item = FinishProductQCBulkItem::where($where);
        //
        if($item->exists()){
            $item = $item->first();
            /* 
             * ************
             * MILK STOCK 
             * *************** */
            $stock = ProductStock::where([
                'stockable_type' => "finish-product", 
                'stockable_id'   => $request->user()->processing_plant_id,
                'product_id'     => $item->product_id,
                'unit_id'        => $item->unit_id,
            ]);
            //
            ProductStock::updateOrCreate(
                [
                    'stockable_type' => "finish-product", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'product_id'     => $item->product_id,
                    'unit_id'        => $item->unit_id,
                ],
                [
                    'stockable_type' => "finish-product", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'quantity'       => (($stock->first()->quantity ?? 0)  - ($item->quantity)),
                    'product_id'     => $item->product_id,
                    'unit_id'        => $item->unit_id,
                ]
            );
            // ** //
            FinishProductQCBulkItem::where($where)->delete();
            return $item_id;
        }
    }
}
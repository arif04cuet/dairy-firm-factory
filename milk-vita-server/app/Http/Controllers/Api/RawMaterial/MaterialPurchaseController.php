<?php

namespace App\Http\Controllers\Api\RawMaterial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Product\Product, DB;
use App\Models\RawMaterial\UAPBulk;
use App\Models\RawMaterial\UAPBulkItem;
use App\Models\ProcessingPlant;
use App\Models\Product\ProductStock;

class MaterialPurchaseController extends Controller
{
    public function makePurchaseItem(Request $request)
    {
        // --------------------------------------------
        $validator_field = ["unit_id" => "required|exists:product_units,id"];
        // --------------------------------------------
        if($request->product_code) 
            $validator_field['product_code'] = "required|exists:products,product_code";
        else 
            $validator_field['product_id'] = "required|exists:products,id";
        // --------------------------------------------

        // DATA VALIDATION
        $validator = Validator::make($request->all(), $validator_field);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $proudct = Product::whereId($request->product_id)
        ->select(
            "*",
            "id as product_id",
            DB::raw("(SELECT id FROM product_units WHERE id = {$request->unit_id}) as unit_id"),
            DB::raw("(SELECT unit_name FROM product_units WHERE id = {$request->unit_id}) as unit_name")
        )
        ->first();
        //
        return response()->json($proudct);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, UAPBulk $purchase_model)
    {
        if($request->select){
            $purchase_model = $purchase_model->select($request->select);
        }
        // 
        $where = where($request->where);
        $where['type'] = 'purchase';
        // MAKE PAGINATED DATA
        $data = paginate($purchase_model, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UAPBulk $purchase_model)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "items"              => "required",
            "items.*.product_id" => "required",
            "items.*.unit_id"    => "required",
            "items.*.quantity"   => "required|numeric|min:1",
            "items.*.price"      => "required|numeric",
        ], 
        [
            "items.*.quantity.min" => "Quantity number should be at least 1",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //

        if($request->user()->processing_plant_id && (is_array($request->items) && count($request->items) > 0))
        {
            $purchase_data = [
                "processing_plant_id" => $request->user()->processing_plant_id,
                "voucher_no" => mkVoucherNo($purchase_model),
                "user_id"    => $request->user()->id,
                "date"       => date("Y-m-d")
            ];
            $purchase_data = UAPBulk::create($purchase_data);
            //
            foreach($request->items as $item)
            {
                $item_data = [
                    "bulk_id" => $purchase_data->id,
                    "processing_plant_id" => $request->user()->processing_plant_id,
                    "user_id"       => $request->user()->id,
                    "product_id"    => $item['product_id'],
                    "unit_id"       => $item['unit_id'],
                    "quantity"      => $item['quantity'],
                    "price"         => $item['price'],
                    "date"          => date("Y-m-d"), 
                ];
                //
                UAPBulkItem::create($item_data);
                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                $stock = ProductStock::where([
                    'stockable_type' => "raw-material", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'product_id'     => $item['product_id'],
                    'unit_id'        => $item['unit_id'],
                ]);
                //
                ProductStock::updateOrCreate(
                    [
                        'stockable_type' => "raw-material", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $item['product_id'],
                        'unit_id'        => $item['unit_id'],
                    ],
                    [
                        'stockable_type' => "raw-material", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'quantity'   => (0+($stock->first()->quantity ?? 0) + (0+$item['quantity'])),
                        'product_id' => $item['product_id'],
                        'unit_id'    => $item['unit_id'],
                    ]
                );
                // ** //
            };
            return $purchase_data->id;
        }
        else return response()->json(['errors'=>['Something is Wrong!!']]);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UAPBulk $purchase_model, $bulk_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "items"              => "required",
            "items.*.product_id" => "required",
            "items.*.unit_id"    => "required",
            "items.*.quantity"   => "required|numeric|min:1",
            "items.*.price"      => "required|numeric",
        ], 
        [
            "items.*.quantity.min"     => "Quantity number should be at least 1",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //


        if($request->user()->processing_plant_id && $bulk_id && (is_array($request->items) && count($request->items) > 0))
        {
            if(UAPBulk::whereId($bulk_id)->exists())
            {
                /* 
                 * *****************
                 * MILK STOCK OUT
                 * *************** */
                $old_items = UAPBulkItem::where('bulk_id', $bulk_id)->get();
                foreach($old_items as $row){
                    /* 
                     * ************
                     * MILK STOCK 
                     * *************** */
                    $stock = ProductStock::where([
                        'stockable_type' => "raw-material", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $row->product_id,
                        'unit_id'        => $row->unit_id,
                    ]);
                    //
                    ProductStock::updateOrCreate(
                        [
                            'stockable_type' => "raw-material", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'product_id'     => $row->product_id,
                            'unit_id'        => $row->unit_id,
                        ],
                        [
                            'stockable_type' => "raw-material", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'quantity'       => (($stock->first()->quantity ?? 0)  - ($row->quantity)),
                            'product_id'     => $row->product_id,
                            'unit_id'        => $row->unit_id,
                        ]
                    );
                    // ** //
                }
                //
                \DB::table("u_a_p_bulk_items")->where('bulk_id', $bulk_id)->delete();
                foreach($request->items as $item)
                {
                    $item_data = [
                        "processing_plant_id" => $request->user()->processing_plant_id,
                        "bulk_id"   => $bulk_id,
                        "user_id"       => $request->user()->id,
                        "product_id"    => $item['product_id'],
                        "unit_id"       => $item['unit_id'],
                        "quantity"      => $item['quantity'],
                        "price"         => $item['price'],
                        "date"          => date("Y-m-d"), 
                    ];
                    //
                    UAPBulkItem::create($item_data);
                    /* 
                     * ************
                     * MILK STOCK 
                     * *************** */
                    $stock = ProductStock::where([
                        'stockable_type' => "raw-material", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $item['product_id'],
                        'unit_id'        => $item['unit_id'],
                    ]);
                    //
                    ProductStock::updateOrCreate(
                        [
                            'stockable_type' => "raw-material", 
                            'stockable_id'   => $request->user()->processing_plant_id,
                            'product_id'     => $item['product_id'],
                            'unit_id'        => $item['unit_id'],
                        ],
                        [
                            'stockable_type' => "raw-material", 
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
    public function view(Request $request, UAPBulk $purchase_model, $bulk_id)
    {
        if($bulk_id && $request->user()->processing_plant_id){
            //
            $where = [
                "processing_plant_id" => $request->user()->processing_plant_id,
                "id"                  => $bulk_id,
                "user_id"             => $request->user()->id,
            ];
            //
            $purchase = $purchase_model->where($where)->with("items")->first();
            //
            return response()->json(collect($purchase)->only('items', 'user_name', 'processing_plant_name', 'voucher_no', 'date', 'id'));
        }
        else 
            return response()->json(["errors"=>["Purchase id is required"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $bulk_id)
    {
        $purchase = UAPBulk::where([
            "user_id" => $request->user()->id,
            "id"      => $bulk_id
        ]);
        //
        if($purchase->exists())
        {
            $items = UAPBulkItem::where("bulk_id", $purchase->first()->id);

            foreach($items->get() as $key=>$item)
            {
                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                $stock = ProductStock::where([
                    'stockable_type' => "raw-material", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'product_id'     => $item->product_id,
                    'unit_id'        => $item->unit_id,
                ]);
                //
                ProductStock::updateOrCreate(
                    [
                        'stockable_type' => "raw-material", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'product_id'     => $item->product_id,
                        'unit_id'        => $item->unit_id,
                    ],
                    [
                        'stockable_type' => "raw-material", 
                        'stockable_id'   => $request->user()->processing_plant_id,
                        'quantity'       => (($stock->first()->quantity ?? 0)  - ($item->quantity)),
                        'product_id'     => $item->product_id,
                        'unit_id'        => $item->unit_id,
                    ]
                );
                // ** //
                UAPBulkItem::whereId($item->id)->delete();
            }
            $purchase->delete();
            return 1;
        }
        else 
            return response()->json(['errors'=>['Something is Wrong!!']]);
    }

    public function itemDelete(Request $request, $item_id)
    {
        $where = [
            "processing_plant_id" => $request->user()->processing_plant_id,
            "id"=>$item_id
        ];
        //
        $item = UAPBulkItem::where($where);
        //
        if($item->exists()){
            $item = $item->first();
            /* 
             * ************
             * MILK STOCK 
             * *************** */
            $stock = ProductStock::where([
                'stockable_type' => "raw-material", 
                'stockable_id'   => $request->user()->processing_plant_id,
                'product_id'     => $item->product_id,
                'unit_id'        => $item->unit_id,
            ]);
            //
            ProductStock::updateOrCreate(
                [
                    'stockable_type' => "raw-material", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'product_id'     => $item->product_id,
                    'unit_id'        => $item->unit_id,
                ],
                [
                    'stockable_type' => "raw-material", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'quantity'       => (($stock->first()->quantity ?? 0) - ($item->quantity)),
                    'product_id'     => $item->product_id,
                    'unit_id'        => $item->unit_id,
                ]
            );
            // ** //
            UAPBulkItem::where($where)->delete();
        }
        return $item_id;
    }
}

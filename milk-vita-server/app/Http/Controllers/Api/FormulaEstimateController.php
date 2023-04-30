<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\FormulationEstimate;
use App\Models\FormulationEstimateItem;
use App\Models\MilkStock;
use App\Models\Department;
//
class FormulaEstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, FormulationEstimate $chilling_plant)
    {
        $where   = where($request->where);

        if($request->user()->role_slug!='superadmin'){
            $where[] = ['user_id', '=', $request->user()->id];
        }

        // SELECTED ATTRIBUTE
        if($request->select){
            $chilling_plant = $chilling_plant->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($chilling_plant, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormulationEstimate $chilling_plant)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "product_id"     => "required",
            "total_mix"      => "required",
            "total_raw_mix"  => "required",
            "density"        => "required",
            "fat_percentage" => "required",

            "ingredient_items"                        => "required|array",
            "ingredient_items.*.product_id"           => "required",
            "ingredient_items.*.quantity"             => "required",
            "ingredient_items.*.material_percentage"  => "required",

            "packing_items"              => "required",
            "packing_items.*.product_id" => "required",
            "packing_items.*.quantity"   => "required",

            "production_items"            => "required",
            "production_items.*.unit_id"  => "required",
            "production_items.*.quantity" => "required",
            "production_items.*.no_of_product" => "required",

        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only('product_id', "total_mix", "total_raw_mix", "density", "fat_percentage", "was_in_stock", "formulation_density", "formulation_bran", "used_stock");




        /*
            STOCK MODULE
        */
        $stock_data = [
            'stockable_type' => 'App\Models\Department',
            'stockable_id'   => (Department::where('manager_id', $request->user()->id)->first()->id ?? 0)
        ];
        $stock = MilkStock::where($stock_data)->first();

        MilkStock::updateOrCreate($stock_data, array_merge($stock_data, [
            "amount"=>(($stock->amount ?? 0) - $request->used_stock)
        ]));


        $data = array_merge($data, [
            "user_id" => $request->user()->id,
            "date"    => date('Y-m-d'),
            "processing_plant_id" => $request->user()->processing_plant_id,
        ]);

        $estimate_id = FormulationEstimate::create($data)->id;
        //

        $request->collect("ingredient_items")->map(function($item) use ($request, $estimate_id)
        {
            $item = collect($item)->only('product_id', 'quantity', 'material_percentage', 'is_raw')->toArray();
            $item['estimate_id'] = $estimate_id;
            //
            FormulationEstimateItem::create($item);
        });



        $request->collect("packing_items")->map(function($item) use ($request, $estimate_id)
        {
            $item = collect($item)->only('unit_id', 'quantity', 'product_id')->toArray();
            $item['estimate_id'] = $estimate_id;
            $item['type'] = 'packing';

            FormulationEstimateItem::create($item);
        });

        $request->collect("production_items")->map(function($item) use ($request, $estimate_id)
        {
            $item = collect($item)->only('unit_id', 'quantity', 'no_of_product')->toArray();
            $item['estimate_id'] = $estimate_id;
            $item['type'] = 'production';

            FormulationEstimateItem::create($item);
        });

        
        return response()->json($estimate_id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormulationEstimate $chilling_plant, $plant_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "chilling_plant_name" => "required",
            'division_id'   => 'required|integer',
            'district_id'   => 'required|integer',
            'upazila_id'    => 'required|integer',
            'union_id'      => 'required|integer',
            "full_address"  => "required",
            "stock_capacity"=> "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "chilling_plant_name",
            "processing_plant_id",
            "division_id", 
            "district_id", 
            "upazila_id", 
            "union_id",
            "full_address",
            "stock_capacity",
        );
        //
        $data['location_details'] = json_encode(
        [
            "division_id" => locationFromDashboard(['location_id'=>$request->division_id]),
            "district_id" => locationFromDashboard(['location_id'=>$request->district_id]),
            "upazila_id"  => locationFromDashboard(['location_id'=>$request->upazila_id]),
            "union_id"    => locationFromDashboard(['location_id'=>$request->union_id]),

        ]);
        // 
        return response()->json($chilling_plant->whereId($plant_id)->update($data));
    }
    /*
     * *********************
     *  STOCK CALCULATION
     * *********************
    */
    public function stock(Request $request, FormulationEstimate $plant)
    {
        $stock = null;
        if( $request->user()->chilling_plant_id){
            $stock = $plant->where('id', $request->user()->chilling_plant_id)->first()->milkStock()->first();
        }
        return response()->json($stock ?? ['amount'=>0]);
    }


    /* *********************
     *  STOCK CALCULATION
     * ********************* */
    public function details(Request $request, FormulationEstimate $plant, $estimate_id)
    {
        $estimate = FormulationEstimate::whereId($estimate_id)->first()->toArray();

        $item = FormulationEstimateItem::where('estimate_id', $estimate_id)->get();

        $item = collect($item)->groupBy('type')->toArray();


        $estimate = array_merge($estimate, $item);


        //
        return response()->json($estimate);
    }

    //
    public function destroy(Request $request, FormulationEstimate $plant, $plant_id)
    {
        $plant = FormulationEstimate::whereId($plant_id);
        if($plant->exists())
        {
            return $plant->delete();
        }
        else return response()->json(['errors'=>['Something is Wrong!']]);
    }
}


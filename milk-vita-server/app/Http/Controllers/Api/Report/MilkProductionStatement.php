<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MilkChallanFromChillingPlant;
use App\Models\Product\FinishProductQCBulkItem;
use App\Models\ClosingMilkStock;
use Carbon\Carbon;


class MilkProductionStatement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function record(Request $request, MilkChallanFromChillingPlant $challan)
    {
        $opening_date = $re_opening_date = ClosingMilkStock::orderBy('id', 'desc')->first()->date;
        $opening_date = ($request->date ?? (new Carbon($opening_date))->addDays(1)->toDateString());

        $date     = $opening_date;
        $pre_date = (new Carbon($date))->subDays(1)->toDateString();
        //
        $products = FinishProductQCBulkItem::where('date', $date)->OrderBy('id', 'DESC')->get();
        //
        $products = collect($products)->map(function($product){
            return collect($product)->except('created_at', 'deleted_at', 'updated_at');
        });




        //
        $data = [
            'challans' => $challan->where('date', $date)->get(),
            'products' => $products,
            'where'    => where($request->where),
            'opening'  => collect(ClosingMilkStock::where('date', $pre_date)->first())->except('created_at', 'deleted_at', 'updated_at'),
            'closing'  => collect(ClosingMilkStock::where('date', $date)->first())->except('created_at', 'deleted_at', 'updated_at'),
            'opening_date' => (new Carbon($re_opening_date))->addDays(1)->toDateString(),
            'search_date'  => $opening_date,
        ];
        //
        return response()->json($data);
    }



    public function closingBalance(Request $request, MilkChallanFromChillingPlant $challan)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "pro_liter"       => "required|numeric",
            "density"         => "required|numeric",
            "pro_kg"          => "required|numeric",
            "fat_persentase"  => "required|numeric",
            "snf_persentase"  => "required|numeric",
            "fat_kg"          => "required|numeric",
            "snf_kg"          => "required|numeric",
            "toned_pro_liter" => "required|numeric",
            "toned_density"   => "required|numeric",
            "toned_pro_kg"    => "required|numeric",
            "toned_fat_kg"    => "required|numeric",
            "toned_snf_kg"    => "required|numeric",
            // 
            "toned_fat_persentase" => "required|numeric",
            "toned_snf_persentase" => "required|numeric",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}


        $opening_date = ClosingMilkStock::orderBy('id', 'desc')->first()->date;
        $closing_date = (new Carbon($opening_date))->addDays(1)->toDateString() ?? date('Y-m-d');

        //
        $record                        = $request->only("pro_liter", "density", "pro_kg", "fat_persentase", "snf_persentase", "fat_kg", "snf_kg", "toned_pro_liter", "toned_density", "toned_pro_kg", "toned_fat_kg", "toned_snf_kg", "toned_fat_persentase", "toned_snf_persentase",);
        $record['user_id']             = $request->user()->id;
        $record['processing_plant_id'] = $request->user()->processing_plant_id;
        $record['date']                = $closing_date;

        if($request->user()->processing_plant_id)
        {
            ClosingMilkStock::updateOrCreate(
            [
                "date" => $closing_date,
                "processing_plant_id" => $request->user()->processing_plant_id
            ], 
            $record);
        }
        else {
            return response()->json(['errors'=>['Unauthorized User']]);
        }

        return response()->json(1);
    }
}

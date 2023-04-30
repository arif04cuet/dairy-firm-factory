<?php

namespace App\Http\Controllers\Api\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChallanAssociationToChillingPlant;
use App\Models\Association;
use Illuminate\Support\Facades\Validator;

class ChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function challanList(Request $request, ChallanAssociationToChillingPlant $challan)
    {
        $where = where($request->where);
        if(isRoleSlug('association-manager')) $where[] = ['association_id', '=', $request->user()->association_id];

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $challan = $challan->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($challan, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    //
    public function challanSubmit(Request $request, ChallanAssociationToChillingPlant $challan)
    {
        if(isRoleSlug('association-manager'))
        {
            $validator = Validator::make($request->all(), [
                "shift"              => "required",
                "noni"               => "required",
                "snf"                => "required",
                "full_can"           => "required",
                "half_can"           => "required",
                "lectometer_reading" => "required",
                "amount_of_milk"     => "required",
                "temperature"        => "required",
            ]);
            //
            if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}

            $data = $request->only("shift", "noni", "snf", "full_can", "half_can", "lectometer_reading", "amount_of_milk", "temperature", "remark");
            //
            $data['date']               = date('Y-m-d');
            $data['asso_manager_id']    = $request->user()->id;
            $data['voucher_no']         = mkVoucherNo((new ChallanAssociationToChillingPlant()), 'voucher_no');
            $data['association_id']     = $request->user()->association_id;
            $data['chilling_plant_id']  = Association::whereId($request->user()->association_id)->first()->chilling_plant_id;

            /* 
             * ************
             * MILK STOCK 
             * *************** */
            $stock = Association::whereId($request->user()->association_id)->first()->milkStock();
            $stock->updateOrCreate(
                ['stockable_type'=>'App\Models\Association','stockable_id'=> $request->user()->association_id],
                ['amount'=> (($stock->first()->amount ?? 0) - (+$request->amount_of_milk))]
            ); 
            // ** //
            return $challan->create($data);
        }
        else {
            return response()->json(['errors'=>['আপনার অনুরোধটি গ্রহণ করা যাচ্ছে না']]);
        }
    }
    public function challanUpdate(Request $request, ChallanAssociationToChillingPlant $challan, $challan_id=null)
    {
        if($challan_id){
            
            if(isRoleSlug('association-manager'))
            {
                $challan = $challan->where('id', $challan_id);

                $validator = Validator::make($request->all(), [
                    "shift"              => "required",
                    "noni"               => "required",
                    "snf"                => "required",
                    "full_can"           => "required",
                    "half_can"           => "required",
                    "lectometer_reading" => "required",
                    "amount_of_milk"     => "required",
                    "temperature"        => "required",
                ]);
                //
                if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
                //
                $data = $request->only("shift", "noni", "snf", "full_can", "half_can", "lectometer_reading", "amount_of_milk", "temperature", "remark");
                //
                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                $stock        = Association::whereId($request->user()->association_id)->first()->milkStock();
                $milk         = ($challan->first()->amount_of_milk - $request->amount_of_milk);
                $stocked_milk = +($stock->first()->amount ?? 0);

                if(($milk > 0) || ($stocked_milk >= abs($milk))){
                    /* *************** */
                    $stock = Association::whereId($request->user()->association_id)->first()->milkStock();
                    $stock->updateOrCreate(
                        ['stockable_type'=>'App\Models\Association','stockable_id'=> $request->user()->association_id],
                        ['amount'=> ($stocked_milk + ($challan->first()->amount_of_milk - $request->amount_of_milk))]
                    ); 
                    // ** //
                    return $challan->update($data);
                }
                else{return response()->json(['errors'=>['আপনার স্টক এ পর্যাপ্ত দুধ নেই']]);}
            }
            else{return response()->json(['errors'=>['আপনার অনুরোধটি গ্রহণ করা যাচ্ছে না']]);}
        }
        else{
            return response()->json(['errors'=>['Challan id is required']]);
        }
    }

    //
    public function destroy(Request $request, ChallanAssociationToChillingPlant $challan, $challan_id=null)
    {
        if($challan_id){
            return $challan->find($challan_id)->delete();
        }
        else {
            return response()->json(['errors'=>['Challan id is required']]);
        }
    }

    /*
     * *********************
     *  STOCK CALCULATION
     * *********************
    */
    public function stock(Request $request, Association $association)
    {
        $stock = null;
        if( $request->user()->association_id){
            $stock = $association->where('id', $request->user()->association_id)->first()->milkStock()->first();
        }
        return response()->json($stock ?? ['amount'=>0]);
    }
}












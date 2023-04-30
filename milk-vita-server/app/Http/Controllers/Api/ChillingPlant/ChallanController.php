<?php

namespace App\Http\Controllers\Api\ChillingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Facades\MilkStock;
use App\Models\{ChallanAssociationToChillingPlant, ChillingPlant, MilkChallanFromChillingPlant};

class ChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, MilkChallanFromChillingPlant $challan)
    {
        $where = where($request->where);
        if(isRoleSlug('chilling-plant-manager')) $where[] = ['chilling_plant_id', '=', $request->user()->chilling_plant_id];

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $challan = $challan->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($challan->with('bulk'), $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MilkChallanFromChillingPlant $challan, $challan_id=null)
    {
        if(isRoleSlug('chilling-plant-manager') && $challan_id){
            $validator = Validator::make($request->all(), [
                "clpt_liter"            => "required|numeric|min:1",
                "clpt_density"          => "required|numeric|min:1",
                "clpt_fat_percentage"   => "required|numeric|min:1",
                "clpt_snf_percentage"   => "required|numeric|min:1",
            ]);
            //
            if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
            //
            $data = $request->only("clpt_liter", "clpt_density", "clpt_kg", "clpt_fat_percentage", "clpt_fat_kg", "clpt_snf_percentage", "clpt_snf_kg");

            /*
            $data['clpt_kg']     = ($request->clpt_liter * $request->clpt_density);
            $data['clpt_fat_kg'] = (($data['clpt_kg']/100) * $request->clpt_fat_percentage);
            $data['clpt_snf_kg'] = (($data['clpt_kg']/100) * $request->clpt_snf_percentage);
            */


            //
            $data['date']   = date('Y-m-d');
            $data['chilling_plant_manager_id'] = $request->user()->id;
            $data['chilling_plant_id']         = $request->user()->chilling_plant_id;
            $data['status']                    = 'submited';
            $data['is_submit']                 = 1;


            /* 
             * ************
             * MILK STOCK 
             * *************** */
            MilkStock::CPlant($request->user()->chilling_plant_id)->out($request->clpt_liter);

            // ** //
            $challan->whereId($challan_id)->update($data);
            //
            return $challan->whereId($challan_id)->first();
        }
        else {
            return response()->json(['errors'=>['Something is wrong!! please try again']]);
        }

        return response()->json($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MilkChallanFromChillingPlant $challan, $challan_id=null)
    {
        if(isRoleSlug('chilling-plant-manager') && $challan_id)
        {            

            $validator = Validator::make($request->all(), [
                "clpt_liter"            => "required|numeric|min:1",
                "clpt_density"          => "required|numeric|min:1",
                "clpt_fat_percentage"   => "required|numeric|min:1",
                "clpt_snf_percentage"   => "required|numeric|min:1",
            ]);
            //
            if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
            //
            $data                = $request->only("clpt_liter", "clpt_density", "clpt_fat_percentage", "clpt_snf_percentage");
            $data['clpt_kg']     = ($request->clpt_liter * $request->clpt_density);
            $data['clpt_fat_kg'] = (($data['clpt_kg']/100) * $request->clpt_fat_percentage);
            $data['clpt_snf_kg'] = (($data['clpt_kg']/100) * $request->clpt_snf_percentage);


            //
            $data['date']   = date('Y-m-d');
            $data['chilling_plant_manager_id'] = $request->user()->id;
            $data['chilling_plant_id']         = $request->user()->chilling_plant_id;
            $data['status']                    = 'submited';
            $data['is_submit']                 = 1;


            $challan = $challan->whereId($challan_id);
            /* 
             * ************
             * MILK STOCK 
             * *************** */
            $stock        = ChillingPlant::whereId($request->user()->chilling_plant_id)->first()->milkStock();
            $milk         = ($challan->first()->clpt_liter - $request->clpt_liter);
            $stocked_milk = +($stock->first()->amount ?? 0);
            //
            $stock = ChillingPlant::whereId($request->user()->chilling_plant_id)->first()->milkStock();
            $stock->updateOrCreate(
                ['stockable_type'=>'App\Models\ChillingPlant','stockable_id'=> $request->user()->chilling_plant_id],
                ['amount'=> ($stocked_milk + ($challan->first()->clpt_liter - $request->clpt_liter))]
            ); 
            // ** //
            $challan->update($data);
        }
        else {
            return response()->json(['errors'=>['Something is wrong!! please try again']]);
        }

        return response()->json($challan_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MilkChallanFromChillingPlant $challan, $challan_id=null)
    {
        if($challan_id){
            return $challan->find($challan_id)->delete();
        }
        else {
            return response()->json(['errors'=>['Challan id is required']]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AssociationChallanList(Request $request, ChallanAssociationToChillingPlant $assoChallan)
    {
        $where = where($request->where);
        if(isRoleSlug('chilling-plant-manager')) $where[] = ['chilling_plant_id', '=', $request->user()->chilling_plant_id];

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $assoChallan = $assoChallan->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($assoChallan, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function AssociationChallanReceive(Request $request, ChallanAssociationToChillingPlant $challan, $challan_id=null)
    {
        if($challan_id)
        {
            if(isRoleSlug('chilling-plant-manager'))
            {
                $validator = Validator::make($request->all(), [
                    "milk_amount_kg_in_plant"    => "required",
                    "milk_amount_liter_in_plant" => "required",
                    "specific_gravity_in_plant"  => "required",
                    "noni_in_plant"              => "required",
                    "total_can_return"           => "required",
                    "milk_cat_id"                => "required",
                ]);
                //
                if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}

                $data = $request->only(
                    "sour_milk_sample_no",
                    "total_can_return",
                    "milk_amount_kg_in_plant",
                    "milk_amount_liter_in_plant",
                    "specific_gravity_in_plant",
                    "snf_in_plant",
                    "noni_in_plant",
                    "milk_difference",
                    "milk_cat_id",
                );

                $data['entry_no'] = ((
                    $challan->where(
                        [
                            'chilling_plant_id'=>$request->user()->chilling_plant_id, 
                            'entry_no'=>0,
                            'date'=>date('Y-m-d')
                        ]
                    )->count('id') ?? 0) + 1);
                // 
                $data['chilling_plant_manager_id'] = $request->user()->id;
                $data['status'] = 'received';


                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                \Log::info($request->user()->chilling_plant_id);
                MilkStock::CPlant($request->user()->chilling_plant_id)->add($request->milk_amount_liter_in_plant ?? 0);

                return $challan->whereId($challan_id)->update($data);
            }
            else {
                return response()->json(['erros'=>['Something is wrong!! please try again']]);
            }
        }
        else {
            return response()->json(['errors'=>['Challan id is required']]);
        }
    }

    //
    public function getVouchar(Request $request, MilkChallanFromChillingPlant $challan)
    {   

        $where = [
            'is_done'           => 0, 
            'chilling_plant_id' => $request->user()->chilling_plant_id,
            'is_submit'         => 0,
        ];

        if($request->type && $request->type=='edit'){
            $where['is_submit'] = 1;
            $where['is_driver_receive'] = 0;
        }

        $challan = $challan->where($where)
        ->with('bulk')
        ->orderBy('id', 'DESC')
        ->first();
        //
        return response()->json($challan); 
    }
}

<?php

namespace App\Http\Controllers\Api\ProcessingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request, DB, Auth;
use App\Facades\MilkStock;
use App\Models\{
    MilkChallanBulk, MilkChallanFromChillingPlant, 
    TestResult, MilkChallanCategoryWise,
    MilkChallanStockRecord, MilkStock as DMilkStock
};

class ChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, MilkChallanFromChillingPlant $challan, MilkChallanBulk $bulk)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){$challan = $challan->select($request->select);}

        // 
        if(Auth::isRoleSlug('driver-processing-plant')) {$where['driver_id'] = $request->user()->id;};
        if(Auth::isRoleSlug('superadmin')) {$where['processing_plant_id'] = $request->user()->processing_plant_id;};

        // MAKE PAGINATED DATA
        $data = paginate($challan->with('bulk'), $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function sampleSubmit(Request $request, MilkChallanFromChillingPlant $challan)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "challan_id"       => "required",
            "receive_quantity" => "required|numeric",
            'sample_quantity'  => 'required|numeric',
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = [
            "sample_quantity" => $request->sample_quantity,
            "prpt_liter"      => $request->receive_quantity,
            "status"          => "qc_pending",
            "sand_qc_date"    => date('Y-m-d'),
            "is_send_qc"      => 1,
        ];
        //
        $challan = $challan->where('id', $request->challan_id);
        $challan->update($data);
        $challan = $challan->first();
        //
        $is_processing = MilkChallanFromChillingPlant::where(
            [
                'bulk_id' => $challan->bulk_id,
                'is_send_qc' => 0
            ]
        ); 
        //
        if($is_processing->get()->isEmpty())
        {
            MilkChallanBulk::whereId($challan->bulk_id)->update(['is_receive'=>1]);
        }
        //
        return 1;
    }
    //
    public function reportSubmit(Request $request, MilkChallanFromChillingPlant $challan)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "challan_id"           => "required",
            "prpt_density"         => "required|numeric",
            'prpt_fat_percentage'  => 'required|numeric',
            'prpt_snf_percentage'  => 'required|numeric',
            'reports'              => 'required|array',
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $data = $request->only('prpt_density', 'prpt_kg', 'prpt_fat_percentage', 'prpt_fat_kg', 'prpt_snf_percentage', 'prpt_snf_kg', 'QCPMFATP', 'QCPMMP');
        //
        $challan = MilkChallanFromChillingPlant::whereId($request->challan_id)->first();
        //
        $data = array_merge($data, [
            "is_qc"         => 1,
            "status"        => "qc_done",
            "qc_manager_id" => $request->user()->id,
            "qc_date"       => date("Y-m-d"),
        ]);
        //
        MilkChallanFromChillingPlant::whereId($request->challan_id)->update($data);

        //
        DB::table('test_results')->where([
            "testable_id"   => $request->challan_id,
            "testable_type" => MilkChallanFromChillingPlant::class,
        ])->delete();

        //
        foreach($request->reports as $key=>$row){
            if($row['result'])
            TestResult::create([
                "result"        => $row['result'],
                "test_id"       => $row['test_id'],
                "testable_id"   => $request->challan_id,
                "tested_by"     => $request->user()->id,
                "testable_type" => MilkChallanFromChillingPlant::class,
            ]);   
        }
        //
        return response()->json($request->challan_id);
    }

    // 
    public function standardization(Request $request, $challan_id=null)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            'AFP'   => 'required|numeric|min:1',
            'SFP'   => 'required|numeric|min:1',
            'RFK'   => 'required|numeric|min:1',
            'RSNFK' => 'required|numeric|min:1',
            'SML'   => 'required|numeric|min:1',
        ], 
        [
            "AFP.required"   => "মোটা ফ্যাট পার্সেন্টেজ দিয়া হয়নি!",
            "SFP.required"   => "ফ্যাট পার্সেন্টেজে দিয়া হয়নি!",
            "RFK.required"   => "ফ্যাট কেজি দিয়া হয়নি!",
            "RSNFK.required" => "রিসিভ SNF দিয়া হয়নি!",
            "AFP.min"        => "মোটা ফ্যাট পার্সেন্টেজ দিয়া হয়নি!",
            "SFP.min"        => "ফ্যাট পার্সেন্টেজে দিয়া হয়নি!",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //

        if($challan_id = $challan_id ?? $request->challan_id)
        {
            //
            $stock = (MilkStock::PPlant(Auth::requestUser()->processing_plant_id)->read()->amount ?? 0);
            MilkStock::PPlant(Auth::requestUser()->processing_plant_id)->update($request->SML ?? 0);

            $data = $request->only("AFP", "SFP", "RFK", "RSNFK");
            $data['pre_stock'] = $stock;

            return MilkChallanFromChillingPlant::whereId($challan_id)->update($data);
        }
        else
            return response(['errors'=>['চালানটি খুঁজে পাওয়া যায়নি!']]);
    }

    //
    public function categoryWiseMilkSubmit(Request $request, $challan_id=null)
    {
        $challan_id = $challan_id ?? $request->challan_id;

        if($challan_id)
        {
            // DATA VALIDATION
            $validator = Validator::make($request->all(), [
                "milk_categories"                  => "required|array",
                'milk_categories.*.category_id'    => 'required|numeric',
                'milk_categories.*.density'        => 'required|numeric',
                'milk_categories.*.fat_percentage' => 'required|numeric',
                'milk_categories.*.snf_percentage' => 'required|numeric',
                'milk_categories.*.quantity'       => 'required|numeric',
            ], 
            [
                "milk_categories.*.category_id.required" => "ক্যাটাগরি নির্বাচন করে চেষ্টা করুন !"
            ]);
            if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

            //
            DB::table('milk_challan_category_wises')->where('challan_id', $challan_id)->delete();
            
            //
            foreach($request->milk_categories as $key=>$category){
                //
                MilkChallanCategoryWise::create([
                    "challan_id"        => $challan_id,
                    "category_id"       => $category['category_id'],
                    "density"           => $category['density'],
                    "quantity"          => $category['quantity'],
                    "kg"                => $category['kg'],
                    "fat_percentage"    => $category['fat_percentage'],
                    "fat_kg"            => $category['fat_kg'],
                    "snf_percentage"    => $category['snf_percentage'],
                    "snf_kg"            => $category['snf_kg'],
                    "date"              => date('Y-m-d'),
                ]);
            }
            return response()->json(MilkChallanCategoryWise::where('challan_id', $challan_id)->get());
        }
        return response()->json(['errors'=>['Challan id is required']]);
    }


    public function departmentWiseMilkSubmit(Request $request, $challan_id=null)
    {
        $challan_id = $challan_id ?? $request->challan_id;
        //
        if($challan_id)
        {
            // DATA VALIDATION
            $validator = Validator::make($request->all(), [
                "departments"                 => "required|array",
                'departments.*.department_id' => 'required|numeric',
                'departments.*.quantity'      => 'required|numeric',
            ], 
            [
                "departments.*.department_id.required" => "ডিপার্টমেন্ট নির্বাচন করে চেষ্টা করুন !"
            ]);
            if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
            //
            DB::table('milk_challan_stock_records')->where('challan_id', $challan_id)->delete();
            //
            foreach($request->departments as $key=>$department)
            {
                MilkChallanStockRecord::create([
                    "challan_id"          => $challan_id,
                    "department_id"       => $department['department_id'],
                    "processing_plant_id" => $request->user()->processing_plant_id,
                    "category_id"         => $department['category_id'],
                    //
                    "quantity"          => $department['quantity'],
                    "density"           => $department['density'],
                    "kg"                => $department['kg'],
                    "fat_percentage"    => $department['fat_percentage'],
                    "fat_kg"            => $department['fat_kg'],
                    "snf_percentage"    => $department['snf_percentage'],
                    "snf_kg"            => $department['snf_kg'],
                    //
                    "date"              => date('Y-m-d'),
                ]);

                MilkStock::PPlant(Auth::requestUser()->processing_plant_id)->out($department['quantity']);
                MilkStock::Department($department['department_id'])->add($department['quantity']);
            }
            //
            return response()->json(MilkChallanStockRecord::where('challan_id', $challan_id)->get());
        }
        return response()->json(['errors'=>['Challan id is required']]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receive(Request $request, MilkChallanFromChillingPlant $challan, $challan_id=null)
    {
        if($challan_id)
        {
            $challan = MilkChallanFromChillingPlant::whereId($challan_id)->update(['is_driver_receive'=>1, 'status'=>'received']);
            return response()->json($challan);
        }
        return response()->json(['errors'=>['Challan id is required']]);
    }

    /**
     * view the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, MilkChallanFromChillingPlant $challan, $challan_id=null)
    {
        $challan_id = ($challan_id ?? $request->challan_id);

        if($challan_id)
        {
            $where = ["id" => $challan_id];

            // 
            if($request->user()->role_slug!='superadmin') {$where['processing_plant_id'] = $request->user()->processing_plant_id;};


            // 
            $challan  = MilkChallanFromChillingPlant::where($where)->with(['bulk', 'category_wise_milk', 'department_wise_milk'])->first();
            $PPlantId = Auth::requestUser()->processing_plant_id;

            // 
            $previous_record = MilkChallanFromChillingPlant::where([['processing_plant_id', $PPlantId]]) // ['id', '<', $challan_id]
            ->orderBy('id', 'DESC')
            ->select('prpt_fat_percentage as FP', 'prpt_snf_percentage as SNFP', 'prpt_density as DENSITY')
            ->first();


            // 
            $previous_record = collect($previous_record)->only('FP', 'SNFP', 'DENSITY')->toArray();
            $previous_record['amount'] = (MilkStock::PPlant($PPlantId)->read()->amount ?? 0);

            // 
            return response()->json([
                "stock"                => $previous_record,
                "challan"              => $challan,
                "reports"              => $challan->test_results,
                "category_wise_milk"   => $challan->category_wise_milk,
                "department_wise_milk" => $challan->department_wise_milk,
            ]);
        }
        return response()->json(['errors'=>['Something is Wrong!!']]);
    }
}

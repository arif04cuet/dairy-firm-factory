<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request, DB;
use App\Models\{DepartmentWiseProduct, Department, User, MilkChallanStockRecord, MilkStock};


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Department $department)
    {
        if($request->select){
            $department = $department->select($request->select);
        }
        // 
        $where = where($request->where);

        if($request->user()->role_slug!='superadmin'){
            $department = $department->where('processing_plant_id', ($request->user()->processing_plant_id ?? -1));
        }
        // MAKE PAGINATED DATA
        $data = paginate($department, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Department $department)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "processing_plant_id"    => "required",
            "department_name_bn"   => "required",
            "department_name_en"   => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "department_name_en",
            "department_name_bn",
            "processing_plant_id",
        );
        // 
        return response()->json($department->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department, $id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "processing_plant_id"  => "required",
            "department_name_bn"   => "required",
            "department_name_en"   => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "department_name_en",
            "department_name_bn",
            "processing_plant_id",
        );
        // 
        return response()->json($department->where('id', $id)->update($data));
    }


    public function config(Request $request, Department $department, $department_id=null)
    {   
        $department = Department::whereId($department_id)->with('product')->first();
        return response()->json([
            "department"   => $department,
            "manager_id"   => ($department->manager_id ?? ''),
            "product_list" => $department->product,
            "users"        => User::where(
                [
                    'role_id' => roleId('department-manager'), 
                    'processing_plant_id' => (DepartmentToProcessingPlat($department_id)->id ?? -1)
                ]
            )->select('id', 'name_en', 'name_bn')->get(),
        ]);
    }
    public function configSetup(Request $request, Department $department, $department_id=null)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "department_id" => "required|exists:departments,id",
            "product_ids"   => "required|array",
            "manager_id"    => "required|numeric",
        ],
        [
            "manager_id.required" => "ম্যানেজার নির্বাচন করে চেষ্টা করুন"
        ]
        );
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        //
        Department::whereId($request->department_id)->update(['manager_id'=>$request->manager_id]);

        //
        DB::table('department_wise_products')->where('department_id', $request->department_id)->delete();
        foreach($request->product_ids as $key=>$id){
            if($id)
            DepartmentWiseProduct::updateOrCreate(
                [
                    "department_id" => $request->department_id,
                    "product_id"    => $id,
                ],
                [
                    "department_id" => $request->department_id,
                    "product_id"    => $id,
                ]
            );
        }

        //
        return response()->json(DepartmentWiseProduct::where('department_id', $request->department_id)->get());
    }


    public function stock(Request $request)
    {
        if($department = Department::where('manager_id', $request->user()->id)->with('stock')->first())
        {
            $record = MilkChallanStockRecord::where('department_id', $department->id)
            ->select("density","snf_percentage","fat_percentage")
            ->orderBy('id', 'DESC')->first();

            $record['stock_quantity'] = $department->stock->amount ?? 0;
            $record = collect($record)->only('stock_quantity', 'snf_percentage', 'fat_percentage', 'density');

            return response($record);
        }
        return response(['errors'=>['Record Not Found']]);
    }
}

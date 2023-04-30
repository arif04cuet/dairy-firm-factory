<?php

namespace App\Http\Controllers\Api\ProcessingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\MilkChallanBulk;
use App\Models\MilkChallanFromChillingPlant;
use App\Notifications\ChallanNotification;
use App\Models\Product\ProductStock;
use App\Models\User;
use App\Models\Role;
use App\Models\ProcessingPlant;
use App\Models\Product\Product;
use Notification;

class BulkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, MilkChallanBulk $bulk)
    {
        $where = $this->where($request);
        //
        if($request->type && $request->type=='qc'){$where['is_receive'] = 1;}

        //
        $bulk['processing_plant_id'] = $request->user()->id;

        // SELECTED ATTRIBUTE
        if($request->select) {
            $bulk = $bulk->select($request->select);
        }

        //
        $bulk = $bulk->with('challans');

        // MAKE PAGINATED DATA
        $data = paginate($bulk, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }
    /**
     * Display details of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, MilkChallanBulk $bulk, $bulk_id=null)
    {
        if($bulk_id)
        {
            $where = where($request->where);
            $where['id'] = $bulk_id;
            if($request->user()->role_slug=='chilling-plant-manager') $where[] = ['chilling_plant_id', '=', $request->user()->chilling_plant_id];

            // SELECTED ATTRIBUTE
            if ($request->select) {
                $bulk = $bulk->select($request->select);
            }
            $data = $bulk->with('challans')->where($where)->first();

            // RETURN RESPOONSE
            return response()->json($data);
        }
        return response()->json(['errors'=>['Something is Wrong!!']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "chilling_plant_ids" => "required",
            "vehicle_id"         => "required",
            "driver_id"          => "required",
        ]);
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
        //
        if(is_array($request->chilling_plant_ids) && (count($request->chilling_plant_ids) > 0)) {
             // MAKE A BULK 
            $bulk = MilkChallanBulk::create([
                "processing_plant_id" => $request->user()->processing_plant_id,
                "user_id"             => $request->user()->id,
                "vehicle_id"          => $request->vehicle_id,
                "driver_id"           => $request->driver_id,
                "date"                => date('Y-m-d')
            ]);


            $total  = count($request->chilling_plant_ids);
            $role   = Role::where('slug', 'chilling-plant-manager')->first();
            $driver = User::whereId($request->driver_id)->first();

            // CREATE NOTIFICATION FOR DRIVER
            Notification::send($driver,
                new ChallanNotification(
                    [
                        'title' => "নতুন বাল্ক তৈরী হয়েছে",
                        'body'  => "মোট {$total} টি সমিতির জন্য চালান তৈরী হয়েছে",
                    ]
                )
            );

            //
            foreach($request->chilling_plant_ids as $id){
                $voucher_no = mkVoucherNo((new MilkChallanFromChillingPlant()), 'voucher_no');
                // CHREATE CHALLANS FOR CHILLING PLANTS
                MilkChallanFromChillingPlant::create([
                    "bulk_id"                   => $bulk->id,
                    "driver_id"                 => $request->driver_id,
                    "chilling_plant_id"         => $id,
                    "processing_plant_id"       => $request->user()->processing_plant_id,
                    "chilling_plant_manager_id" => $request->user()->id,
                    "voucher_no"                => $voucher_no,
                    "date"                      => date('Y-m-d'),
                ]);

                // CREATE NOTIFICATION FOR CHILLING PLANT MANAGER
                $asso_manager = User::where([
                    'chilling_plant_id'=>$id,
                    'role_id'          =>$role->id
                ]);
                if(!$asso_manager->get()->isEmpty()){
                    Notification::send(
                        $asso_manager->first(), new ChallanNotification(
                            [
                                'title' => "নতুন চালান তৈরী হয়েছে",
                                'body'  => "চালকের নামঃ\n{$driver->name_bn}\nচালান আই.ডি {$voucher_no}\nঅনুগ্রহপূর্বক দুধ প্রস্তুত রাখবেন",
                            ]
                        )
                    );
                }

            }
            // CREATE NOTIFICATION FOR CURRENT USER
            Notification::send(
                User::whereId($request->user()->id)->first(), new ChallanNotification(
                    [
                        'title' => "নতুন বাল্ক তৈরী হয়েছে",
                        'body'  => "মোট {$total} টি সমিতির জন্য চালান তৈরী হয়েছে",
                    ]
                )
            );
            //
            return 1;

        }
        else return response()->json(['errors'=>['Something is Wrong!! Please try again']]);
    }

    public function receive(Request $request, MilkChallanBulk $bulk, $bulk_id=null)
    {
        if($bulk_id){
            return $bulk->whereId($bulk_id)->update(['is_receive'=>1, 'receive_date'=>date('Y-m-d')]);
        }
        else return response()->json(['errors'=>['Bulk Id is required']]);
    }

    public function where($request){
        //
        $conditions = $request->where;
        $where = [];
        if(is_array($conditions)){
            foreach($conditions as $key=>$value){
                if(is_array($value)==false && $value!=''){
                    $where[] = [$key, $value];
                }
                else if($key=='date' && is_array($value))
                {   
                    foreach($value as $entity=>$date){
                        //
                        if($request->type && $request->type=='qc')
                        {
                            if($date!='' && $entity=='from')
                                $where[] = ['receive_date', '>=', $value];
                            if($date!='' && $entity=='to')
                                $where[] = ['receive_date', '<=', $value];
                        }
                        //
                        else {
                            if($date!='' && $entity=='from')
                                $where[] = ['date', '>=', $value];
                            if($date!='' && $entity=='to')
                                $where[] = ['date', '<=', $value];
                        }
                    }
                }
            }
        }
        return $where;
    }

    //
    public function qcReportStore(Request $request, ProcessingPlant $proPlant)
    {
        $validator = Validator::make($request->all(), 
            [
                "qc_cat_id"         => "required", 
                "qc_milk_amount"    => "required", 
                "bulk_id"           => "required", 
                "bulk_id"           => "required", 
                "reports"           => "required|array|min:1",
                "reports.*.result"  => "required",
                "reports.*.test_id" => "required",
                "challans.*.id"                     => "required",
                "challans.*.prpt_liter"             => "required",
                "challans.*.prpt_density"           => "required",
                "challans.*.prpt_fat_persentase"    => "required",
                "challans.*.prpt_snf_persentase"    => "required",
            ],
            [
                'bulk_id.required'           => 'বাল্ক আইডি প্রয়োজন',
                'reports.min'                => 'অন্তত একটি রিপোর্ট দিতে হবে',
                'reports.*.result.required'  => 'টেস্টার ফলাফল দিয়ে চেষ্টা করুন',
                'reports.*.test_id.required' => 'টেস্ট নির্বাচন করুন',
            ]
        );
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
        //
        $bulk    = MilkChallanBulk::whereId($request->bulk_id);
        if($bulk->where('is_qc', 0)->exists())
        {
            $bulk = $bulk->first();
            //
            if(is_array($request->reports)){
                foreach($request->reports as $key=>$row)
                {
                    $bulk->milkTest()->create([
                        "test_id"   => $row['test_id'],
                        "result"    => $row['result'],
                        "tested_by" => $request->user()->id,
                    ]);
                }
            }

            if(is_array($request->challans)){
                foreach($request->challans as $key=>$row)
                {
                    $challan_info                = $row;
                    $challan_info['prpt_kg']     = ($challan_info['prpt_liter'] * $challan_info['prpt_density']);
                    $challan_info['prpt_fat_kg'] = (($challan_info['prpt_kg']/100) * $challan_info['prpt_fat_persentase']);
                    $challan_info['prpt_snf_kg'] = (($challan_info['prpt_kg']/100) * $challan_info['prpt_snf_persentase']);
                    //
                    MilkChallanFromChillingPlant::where('id', $row['id'])->update($challan_info);
                }
            }

            /* 
             * *****************
             *  MILK STOCK IN
             * *************** */
            $stock = ProductStock::where([
                'stockable_type' => "raw-milk", 
                'stockable_id'   => $request->user()->processing_plant_id,
                'category_id'    => $request->qc_cat_id,
            ]);
            //
            ProductStock::updateOrCreate(
                [
                    'stockable_type' => "raw-milk", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'category_id'    => $request->qc_cat_id,
                ],
                [
                    'stockable_type' => "raw-milk", 
                    'stockable_id'   => $request->user()->processing_plant_id,
                    'quantity'       => ((float)($stock->first()->quantity ?? 0) + (float)$request->qc_milk_amount),
                    'category_id'    => $request->qc_cat_id,
                ]
            );
            // ** //
            
            $bulk->update([
                'is_qc'          => 1,
                'qc_cat_id'      => $request->qc_cat_id,
                'qc_milk_amount' => $request->qc_milk_amount,
                'qc_date'        => date('Y-m-d'),
                'qc_manager_id'  => $request->user()->id,
            ]);

            //
            return 1;
        }
        else {
            return response(['errors' => ['Something is wrong! Please try again']], 200);
        }
    }

    //
    public function qcReportUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                "bulk_id"           => "required", 
                "reports"           => "required|array|min:1",
                "reports.*.result"  => "required",
                "reports.*.test_id" => "required",
            ],
            [
                'bulk_id.required'           => 'বাল্ক আইডি প্রয়োজন',
                'reports.min'                => 'অন্তত একটি রিপোর্ট দিতে হবে',
                'reports.*.result.required'  => 'টেস্টার ফলাফল দিয়ে চেষ্টা করুন',
                'reports.*.test_id.required' => 'টেস্ট নির্বাচন করুন',
            ]
        );
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}
        //
        $bulk = MilkChallanBulk::whereId($request->bulk_id);
        //
        if($bulk->where('is_qc', 1)->exists())
        {
            $bulk = $bulk->first();
            $bulk->milkTest()->limit(1000)->delete();
            if(is_array($request->reports)){
                foreach($request->reports as $key=>$row)
                {
                    $bulk->milkTest()->create([
                        "test_id"   => $row['test_id'],
                        "result"    => $row['result'],
                        "tested_by" => $request->user()->id,
                    ]);
                }
            }
            //
            return 1;
        }
        else {
            return response(['errors' => ['Something is wrong! Please try again']], 200);
        }
    }
    //
    public function qcReportList(Request $request, MilkChallanBulk $bulk, $bulk_id=null)
    {
        if($bulk_id)
        {
            return response()->json($bulk->whereId($bulk_id)->first()->milkTest()->get());
        }
    }
}

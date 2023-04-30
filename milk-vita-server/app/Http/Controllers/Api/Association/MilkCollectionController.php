<?php

namespace App\Http\Controllers\Api\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MilkCollectionInAssociation;
use Illuminate\Support\Facades\Validator;
use App\Models\TestResult;
use App\Models\Association;
use App\Models\AssociationMilkStock;
use App\Models\AssociationMember;

class MilkCollectionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, MilkCollectionInAssociation $milkCollection)
    {
        $where   = where($request->where);
        if($request->user()->role_slug=="association-manager"){
            $where[] = ['association_id', '=', $request->user()->association_id];
        }

        // SELECTED ATTRIBUTE
        if ($request->select) $milkCollection = $milkCollection->select($request->select);

        //
        $milkCollection = $milkCollection->with(['association:id,association_name', 'member:id,member_name', 'testResults']);

        // MAKE PAGINATED DATA
        $data = paginate($milkCollection, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MilkCollectionInAssociation $milkCollection)
    {
        $validator = Validator::make($request->all(), [
            'memberMilkCollections.*.association_id' => 'required',
            'memberMilkCollections.*.member_id'      => 'required',
            'memberMilkCollections.*.shift'          => 'required',
            'memberMilkCollections.*.amount_of_milk' => 'required',
            'memberMilkCollections.*.temperature'    => 'required',
        ]);
        //
        if($validator->fails()){return response(['errors' => $validator->errors()->all()], 200);}

        // if(MilkCollectionInAssociation::where())
        if($request->memberMilkCollections && is_array($request->memberMilkCollections)) 
        {
            foreach ($request->memberMilkCollections as $memberMilkCollection)
            {
                $is_available = MilkCollectionInAssociation::where([
                    'member_id' => $memberMilkCollection['member_id'],
                    'shift'     => $memberMilkCollection['shift'],
                    'date'      => date('Y-m-d'),
                ]);
                if($is_available->exists()){
                    $member = (AssociationMember::whereId($memberMilkCollection['member_id'])->first()->member_name ?? '');
                    return response()->json(['errors'=>"{$member}, সদস্যের দুধ নিয়া হয়েছে"]);
                }
            }
        }

        //
        if($request->memberMilkCollections && is_array($request->memberMilkCollections)) 
        {
            foreach ($request->memberMilkCollections as $memberMilkCollection)
            {
                $dataMilkCollection = [
                    'association_id'    => $request->user()->association_id,
                    'member_id'         => $memberMilkCollection['member_id'],
                    'shift'             => $memberMilkCollection['shift'],
                    'amount_of_milk'    => $memberMilkCollection['amount_of_milk'],
                    'temperature'       => $memberMilkCollection['temperature'],
                    'date'              => date('Y-m-d'),
                ];
                //
                $milkCollection = MilkCollectionInAssociation::create($dataMilkCollection);

                /* 
                 * ************
                 * MILK STOCK 
                 * *************** */
                $stock = Association::whereId($request->user()->association_id)->first()->milkStock();
                //
                $stock->updateOrCreate(
                    [
                        'stockable_type'=> 'App\Models\Association',
                        'stockable_id'  => $request->user()->association_id
                    ],
                    [
                        'amount'=> (($stock->first()->amount ?? 0) + $memberMilkCollection['amount_of_milk'])
                    ]
                );


                /**********************************************************/
                if($milkCollection){
                    //
                    $testResults = $memberMilkCollection['testResult'];
                    //
                    foreach($testResults as $testResultData)
                    {
                        if($testResultData['result']!='' && $testResultData['test_id']!='' )
                        {
                            $testResult = new TestResult();
                            $testResult['test_id']      = $testResultData['test_id'];
                            $testResult['result']       = $testResultData['result'];
                            $testResult['tested_by']    = $request->user()->id;
                            $testResult['testable_id']  = $milkCollection->id;
                            // return response()->json($testResult);
                            //
                            $milkCollection->testResults()->save($testResult);
                        }
                    }
                }
            }
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
    public function update(Request $request, MilkCollectionInAssociation $milkCollection, $id)
    {
        //
        $validator = Validator::make($request->all(), 
        [
            'association_id'    => 'required',
            'member_id'         => 'required',
            'shift'             => 'required',
            'amount_of_milk'    => 'required',
            'temperature'       => 'required',
        ]);
        //
        if ($validator->fails()) {
            return response([' errors ' => $validator->errors()->all()], 200);
        }

        $milkCollection = $milkCollection->whereId($id);

        if (!$milkCollection->get()->isEmpty()) {

            $dataMilkCollection = [
                'association_id'    => $request['association_id'],
                'member_id'         => $request['member_id'],
                'shift'             => $request['shift'],
                'amount_of_milk'    => $request['amount_of_milk'],
                'temperature'       => $request['temperature'],
            ];

            $old_collection = $milkCollection->first();

            /* 
             * ************
             * MILK STOCK 
             * *************** */
            if($old_collection->amount_of_milk!=$request['amount_of_milk'])
            {
                //
                $stock = Association::whereId($request->user()->association_id)->first()->milkStock();
                //
                $stock->updateOrCreate(
                    [
                        'stockable_type'=> 'App\Models\Association',
                        'stockable_id'  => $request->user()->association_id
                    ],
                    [
                        'amount'=> (($stock->first()->amount ?? 0) + ($request['amount_of_milk'] - (0 + $old_collection->amount_of_milk)))
                    ]
                );  
            }
            /* UPDATE COLLECTION */
            $updateStatus = $milkCollection->update($dataMilkCollection);

            // ****************************************** //
            if ($updateStatus) 
            {
                $testResults = $request['test_results'];
                $firstItem   = true;

                foreach ($testResults as $testResultData) {
                    if($testResultData['test_id']!='' && $testResultData['result']!='')
                    {
                        $testResult = new TestResult;
                        //
                        if ($firstItem === true && isset($testResultData['testable_id'])) {
                            $testResult->where('testable_id', $testResultData['testable_id'])->delete();
                            $firstItem = false;
                        }
                        //
                        $testResult['test_id']      = $testResultData['test_id'];
                        $testResult['result']       = $testResultData['result'];
                        $testResult['tested_by']    = $request->user()->id;
                        $testResult['testable_id']  = $request['id'];
                        //
                        $milkCollection->find($id)->testResults()->save($testResult);
                    }
                }
                return response()->json($milkCollection);
            } 
            else {
                return response([' errors ' => ['Something is wro ng!!please try again']], 200);
            }
        }
    }

    public function getSingleEntry(Request $request, MilkCollectionInAssociation $milkCollection)
    {
        $milkCollection = MilkCollectionInAssociation::where($request->where)
            ->with('testResults', 'member')
            ->get();
        //
        return response()->json($milkCollection);
    }

    public function getSingleTestResult($milkCollectionId)
    {
        $testResult = TestResult::whereHasMorph('testable', [MilkCollectionInAssociation::class])
            ->where('testable_id', $milkCollectionId)
            ->with(['test', 'testable'=>function($query){
                $query->with('member');
            }])
            ->get();
            //
        return response()->json($testResult);
    }
}

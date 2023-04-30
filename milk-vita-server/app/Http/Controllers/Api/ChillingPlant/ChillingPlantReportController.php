<?php

namespace App\Http\Controllers\Api\ChillingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Association, DB;
use App\Models\ChallanAssociationToChillingPlant;
use App\Models\AssociationBillDetails;
use App\Models\AssociationBillRecord;

class ChillingPlantReportController extends Controller
{
	public function list(Request $request, AssociationBillRecord $record)
	{
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $record = $record->select($request->select);
        }
        // MAKE PAGINATED DATA
        $data = paginate($record, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastMilkCollectionList(Request $request, Association $challan)
    {
    	$association = DB::table('association_control_flows')
	    	->join('associations', 'associations.id', '=', 'association_control_flows.association_id')
	    	->join('milk_collection_in_associations', 'milk_collection_in_associations.association_id', '=', 'associations.id')
	    	->where('association_control_flows.chilling_plant_id', $request->user()->chilling_plant_id);


	    $association = $association
	    ->select(
	    	"associations.id as association_id",
	    	"associations.association_name",
	    	"associations.association_code",
	    	DB::raw("
	    	(
	    		SELECT 
	    			to_date 
	    		FROM 
	    			association_bill_records 
	    		WHERE 
	    			association_bill_records.association_id = associations.id
	    		ORDER BY id DESC LIMIT 1
	    	) 
	    	as last_recorded_date"),
	    	DB::raw("
	    	(
	    		SELECT 
	    			date 
	    		FROM 
	    			milk_collection_in_associations 
	    		WHERE 
	    			milk_collection_in_associations.association_id = associations.id
	    		ORDER BY id ASC LIMIT 1
	    	) 
	    	as first_collected_date"),
	    )
	    ->groupBy('associations.id')->get();


    	return response()->json($association);
    }


    //
    public function GenerateAssociationBillBecord(Request $request, Association $challan)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "associations" => "required|array",
            "nameassociations.*.association_id" => "required|exists:associations,id",
            "nameassociations.*.from_date" => "required",
            "nameassociations.*.to_date" => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        
        foreach($request->associations as $key=>$row)
        {
        	$collections = ChallanAssociationToChillingPlant::where(
        		[
        			['association_id', '=', $row['association_id']],
        			['date', '>=', $row['from_date']],
        			['date', '<=', $row['to_date']],
	        	]
	        )
        	->select(
        		"association_id",
        		"shift",
        		"snf_in_plant as snf",
        		"specific_gravity_in_plant as specific_gravity",
        		"noni_in_plant as fat",
        		"milk_amount_liter_in_plant as litre",
        		"date as milk_collection_date"
        	);


        	if($collections->exists())
        	{
        		// AssociationBillDetails
				// AssociationBillRecord

				$record = AssociationBillRecord::updateOrCreate(
				[
					"chilling_plant_id" => $request->user()->chilling_plant_id,
			        "association_id"    => $row['association_id'],
			        "date"				=> date('Y-m-d')
				],
				[
					"chilling_plant_id" => $request->user()->chilling_plant_id,
			        "association_id"    => $row['association_id'],
			        "user_id"			=> $request->user()->id,
			        "from_date" 		=> $row['from_date'],
			        "to_date"			=> $row['to_date'],
			        "date"				=> date('Y-m-d')
				]);

				foreach($collections->get() as $key=>$collection)
				{
					AssociationBillDetails::updateOrCreate(
					[
				        "association_id"        => $row['association_id'],
				        "date"					=> date('Y-m-d'),
					],
					[
				        "bill_id" 				=> $record->id,
				        "association_id"        => $row['association_id'],
				        "shift"  				=> $collection->shift,
				        "milk_collection_date"  => $collection->milk_collection_date,
				        "litre"  				=> $collection->litre,
				        "specific_gravity"		=> $collection->specific_gravity,
				        "fat"					=> $collection->fat,
				        "snf"					=> $collection->snf,
				        "unit_price"			=> 0,
				        "date"					=> date('Y-m-d'),
					]);
				}

        	}
        }

        // 

    	return 1;
    }

    //
    public function view(Request $request, AssociationBillRecord $record, $bill_id=null)
    {
    	$record = AssociationBillRecord::where('id', $bill_id);

    	if($bill_id && $record->exists())
    	{
    		return response()->json([
    			'record' 	  => $record->first(),
    			'collections' => AssociationBillDetails::where('bill_id', $bill_id)->get()
    		]);
    	}
    	return response()->json(['errors'=>['Something is Wrong! Please Try Again']]);
    }
}












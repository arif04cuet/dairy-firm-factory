<?php

namespace App\Http\Controllers\Api\HeadOffice;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ChillingPlant, DB;
use App\Models\Application\BankAplicationForAssociationPayment;
use App\Models\Application\BankAplicationForAssociationPaymentDetails;

class BankForwardingApplicationController extends Controller
{
    public function applicationList(Request $request, BankAplicationForAssociationPayment $application)
    {
        $where   = where($request->where);
        // $where[] = ['user_id', '=', $request->user()->id];

        // SELECTED ATTRIBUTE
        if($request->select){
            $application = $application->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($application, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    //
    public function chillingPlantRecord (Request $request, ChillingPlant $chilling_plant, $chilling_plant_id=null)
    {
    	$chilling_plant = $chilling_plant->whereId($chilling_plant_id);
    	//
        if($chilling_plant_id && $chilling_plant->exists())
        {
        	return response()->json(
        		[
        			"chilling_plant" => $chilling_plant->first(),
        			"associations" 	 => DB::table('association_control_flows')
					->join('associations', 'associations.id', '=', 'association_control_flows.association_id')
					->join('association_bank_infos', 'association_bank_infos.association_id', '=', 'association_control_flows.association_id')
					->where([
						'association_control_flows.chilling_plant_id' => $chilling_plant_id,
						'association_control_flows.is_approved_chilling_plant_manager' => 1,
						'association_bank_infos.type' => 'bill_account'
					])
					->select('associations.id as association_id', 'associations.association_name', 'associations.association_code', 'association_bank_infos.account_no', 'association_bank_infos.bank_name')
					->groupBy('associations.id')
					->get()
	        	]
	        );
        }
        return 1;
    }


    //
    public function applicationSubmit(Request $request, BankAplicationForAssociationPayment $application)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "chilling_plant_id" => "required",
            "to"                => "required",
            "subject"           => "required",
            "body"              => "required",
            "associations"      => "required|array",
            //
            "associations.*.association_id" => "required",
            "associations.*.account_no"     => "required",
            "associations.*.bank_name"      => "required",
            "associations.*.amount"         => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $record = $request->only( "chilling_plant_id", "to", "subject", "body");
        //
        $record['user_id'] = $request->user()->id;
        $record['memo_no'] = mkVoucherNo($application, 'memo_no');
        $record['date']    = date('Y-m-d');
        //
        $application = BankAplicationForAssociationPayment::create($record);
        //
        foreach($request->associations as $key=>$row)
        {
            BankAplicationForAssociationPaymentDetails::create([
                'application_id' => $application->id,
                'association_id' => $row['association_id'],
                'account_no'     => $row['account_no'],
                'bank_name'      => $row['bank_name'],
                'amount'         => $row['amount'],
                'date'           => date('Y-m-d'),
            ]);
        }
        return $application->id;
    }

    //
    public function applicationUpdate(Request $request, BankAplicationForAssociationPayment $application, $app_id=null)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "chilling_plant_id" => "required",
            "to"                => "required",
            "subject"           => "required",
            "body"              => "required",
            "associations"      => "required|array",
            //
            "associations.*.association_id" => "required",
            "associations.*.account_no"     => "required",
            "associations.*.bank_name"      => "required",
            "associations.*.amount"         => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $application = BankAplicationForAssociationPayment::whereId($app_id);
        //
        if($application->exists())
        {
            $record = $request->only( "chilling_plant_id", "to", "subject", "body");
            $application->update($record);
            $application = $application->first();
            //
            DB::table('bank_aplication_for_association_payment_details')->where('application_id', $app_id)->delete();
            foreach($request->associations as $key=>$row)
            {
                BankAplicationForAssociationPaymentDetails::create([
                    'application_id' => $application->id,
                    'association_id' => $row['association_id'],
                    'account_no'     => $row['account_no'],
                    'bank_name'      => $row['bank_name'],
                    'amount'         => $row['amount'],
                    'date'           => $application->date,
                ]);
            }
            //
            return $application->id;
        }
        return response()->json(['errors'=>['Something is Wrong!']]);
    }

    //
    public function applicationView(Request $request, BankAplicationForAssociationPayment $application, $application_id=null)
    {
        $application = BankAplicationForAssociationPayment::whereId($application_id);
        //
        if($application_id && $application->exists())
        {
            return response()->json($application->with(['details'])->first());
        }
        else return response()->json(['errors'=>['Something is Wrong!']]);
    }
}

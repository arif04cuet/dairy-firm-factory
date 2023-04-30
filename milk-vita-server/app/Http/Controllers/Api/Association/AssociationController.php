<?php

namespace App\Http\Controllers\Api\Association;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator, DB;
use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\AssociationMember;
use App\Models\AssociationRoadType;
use App\Models\AssociationControlFlow;
use App\Models\AssociationHistory;
use App\Models\AssociationCommiteeMember;
use App\Models\AssociationBankInfo;
use App\Models\Role;
use App\Models\User, Hash;

class AssociationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Association $association)
    {
        return $this->associationQuery($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fieldOfficerAppliedList(Request $request, Association $association)
    {
        //
        $request->merge([
            'is_applied' => 1,
            'where'      => array_merge(($request->where ?? []), ['user_id' => $request->user()->id])
        ]);
        //
        return $this->associationQuery($request);
    }

    public function associationQuery($request)
    {
        $association = (new Association())->with(['members', 'road_types', 'commitee_members', 'control_flow', 'manager', 'bank_infos']);
        $where       = where($request->where);

        if($request->user()->role_slug=='field-officer'){
            $where['user_id'] = $request->user()->id;
        }

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $association = $association->select($request->select);
        }

        //
        if ($request->type == 'application-list') {
            $association = $association->where(function ($q) use ($request) {
                //
                $ids = DB::table('association_control_flows')->where(
                    [
                        ["field_officer_id", $request->user()->id],
                        ["chilling_plant_id", '!=', 0]
                    ]
                );
                //
                $q->whereIn('id', $ids->pluck('association_id')->toArray());
            });
        }

        //
        if ($request->type == 'verified-resolution-list') {
            $association = $association->where(function ($q) use ($request) {
                //
                $ids = DB::table('association_control_flows')->where(
                    [
                        ["field_officer_id", $request->user()->id],
                        ["is_approved_chilling_plant_manager", 1],
                        ["chilling_plant_manager_id", '!=', 0],
                        ["is_resolution", 0],
                    ]
                );
                //
                $q->whereIn('id', $ids->pluck('association_id')->toArray());
            });
        }        

        //
        if ($request->type == 'chairman-approve-list'){
            // 
            $association = $association->where(function ($q) use ($request) {
                // 
                $ids = DB::table('association_control_flows')->where(
                    [
                        ["field_officer_id", '=', $request->user()->id],
                        ["is_approved_chilling_plant_manager", 1],
                        ["is_approved_milkvita_officer", 1]
                    ]
                );
                //
                $q->whereIn('id', $ids->pluck('association_id')->toArray());
            });
        }

        //
        if ($request->type == 'application-review-list') {
            $association = $association->where(function ($q) use ($request) {
                //
                $ids = DB::table('association_control_flows')->where(
                    [
                        ["chilling_plant_id", $request->user()->chilling_plant_id],
                        ["chilling_plant_manager_id", 0],
                        ["is_resolution", 0],
                    ]
                );
                //
                $q->whereIn('id', $ids->pluck('association_id')->toArray());
            });
        }

        //
        if ($request->type == 'correction-list') {
            $association = $association->where(function ($q) use ($request) {
                //
                $ids = DB::table('association_control_flows')->where(
                    [
                        ["field_officer_id", $request->user()->id],
                        ["is_forward_for_correction", 1],
                        ["chilling_plant_manager_id", '!=', 0],
                        ["is_resolution", 0],
                    ]
                );
                //
                $q->whereIn('id', $ids->pluck('association_id')->toArray());
            });
        }

        //
        if ($request->type == 'survey-list') {
            $association = $association->where(function ($q) use ($request) {
                $q->whereNotIn('id', DB::table('association_control_flows')->where('field_officer_id', $request->user()->id)->pluck('association_id')->toArray());
            });
        }

        //
        if ($request->type == 'chilling-manager-application-list') {
            $association = $association->where(function ($q) use ($request) {
                $q->whereIn(
                    'id',
                    DB::table('association_control_flows')
                        ->where(
                            [
                                ['chilling_plant_manager_id', $request->user()->id],
                                ['is_resolution', 1],
                            ]
                        )->pluck('association_id')->toArray()
                );
            });
        }

        //
        if ($request->type == 'field-officer-reject-list') {
            $association = $association->where(function ($q) use ($request) {
                $q->whereIn(
                    'id',
                    DB::table('association_control_flows')
                        ->where('field_officer_id', $request->user()->id)
                        ->where(function ($query) {
                            $query->where('is_reject_chilling_plant_manager', 1)
                                ->orWhere('is_reject_milkvita_officer', 1)
                                ->orWhere('is_reject_cooperative_officer', 1);
                        })
                        ->pluck('association_id')->toArray()
                );
            });
        }

        //
        if ($request->type == 'chilling-officer-application-list') {
            $association = $association->where(function ($q) use ($request) {
                $q->whereIn(
                    'id',
                    DB::table('association_control_flows')
                        ->where(
                            [
                                // ["chilling_plant_id", $request->user()->chilling_plant_id],
                                ["is_forward_chilling_plant_manager", 1],
                                ["is_resolution", 1],
                            ]
                        )->pluck('association_id')->toArray()
                );
            });
        }

        //
        else if ($request->is_applied == 1) {
            $association = $association->where(function ($q) use ($request) {
                //
                $ids = DB::table('association_control_flows')->where('chilling_plant_id', $request->user()->chilling_plant_id);
                //
                if ($request->is_correction == 1)
                    $ids = $ids->where('is_forward_for_correction', 1);
                else
                    $ids = $ids->where('is_forward_for_correction', 0);
                //
                $q->whereIn('id', $ids->pluck('association_id')->toArray());
            });
        }

        //
        else if ($request->type == 'for-application') {
            $association = $association->where(function ($q) use ($request) {
                $ids = DB::table('association_control_flows')
                    ->where(['field_officer_id' => $request->user()->id])->pluck('association_id')->toArray();

                //
                $q->whereNotIn('id', $ids)
                    ->whereIn(
                        'id',
                        DB::table('associations')->where('associations.user_id', $request->user()->id)
                            ->join('association_members', 'association_members.association_id', '=', 'associations.id')
                            ->groupBy('associations.id')
                            ->havingRaw("COUNT(association_members.id) >= 2")
                            ->pluck('associations.id')->toArray()
                    );
            });
        }

        // MAKE PAGINATED DATA
        $data = paginate($association, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Association $association)
    {
        $data = $request->only('name_of_dairy_area', 'association_name', 'working_area_of_association');
        $data['user_id'] = $request->user()->id;
        // CREATE ASSOCIATION
        $association = $association->create($data);
        //
        AssociationHistory::create([
            'date'           => date('Y-m-d'),
            'user_id'        => $request->user()->id,
            'association_id' => $association->id,
            'status'         => 'সমিতিটি তৈরী হয়েছে',
        ]);
        //
        return response()->json($association);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Association $association, $id)
    {
        $data = $request->only('name_of_dairy_area', 'association_name', 'working_area_of_association');
        $association = $association->whereId($id);
        //
        if (!$association->get()->isEmpty()) {
            // UPDATE INFORMATIVE FORM
            return response()->json($association->update($data));
        } else {
            return response()->json(['erros' => ['Something is wrong!! please try again']]);
        }
    }

    //
    public function application(Request $request, Association $association, $association_id)
    {
        $validator = Validator::make($request->all(), [
            "milk_area_division_id"         => 'required',
            "milk_area_district_id"         => 'required',
            "milk_area_upazila_id"          => 'required',
            "milk_area_union_id"            => 'required',
            "milk_area_village"             => 'required',
            "association_division_id"       => 'required',
            "association_district_id"       => 'required',
            "association_upazila_id"        => 'required',
            "association_union_id"          => 'required',
            "association_village"           => 'required',
            "association_name"              => 'required',
            "association_code"              => 'required',
            "name_of_dairy_area"            => 'required',
            "working_area_of_association"   => 'required',
            "total_present_member"          => 'required',
            "distance_of_working_area_to_adjoining_area" => 'required',
            "distance_of_factory_to_association_center"  => 'required',
        ]);
        // 
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }
        // 
        $data = $request->only(
            "milk_area_division_id",
            "milk_area_district_id",
            "milk_area_upazila_id",
            "milk_area_union_id",
            "milk_area_village",
            "association_division_id",
            "association_district_id",
            "association_upazila_id",
            "association_union_id",
            "association_village",
            "association_name",
            "association_code",
            "name_of_dairy_area",
            "working_area_of_association",
            "distance_of_working_area_to_adjoining_area",
            "distance_of_factory_to_association_center",
            "total_present_member",
            "longitude",
            "latitude",
        );
        $data['milk_area_location_details'] = json_encode(
        [
            "division" => locationFromDashboard(['location_id'=>$request->milk_area_division_id]),
            "district" => locationFromDashboard(['location_id'=>$request->milk_area_district_id]),
            "upazila"  => locationFromDashboard(['location_id'=>$request->milk_area_upazila_id]),
            "union"    => locationFromDashboard(['location_id'=>$request->milk_area_union_id]),

        ]);
        
        $data['association_location_details'] = json_encode(
        [
            "division" => locationFromDashboard(['location_id'=>$request->association_division_id]),
            "district" => locationFromDashboard(['location_id'=>$request->association_district_id]),
            "upazila"  => locationFromDashboard(['location_id'=>$request->association_upazila_id]),
            "union"    => locationFromDashboard(['location_id'=>$request->association_union_id]),

        ]);
        //
        $association = $association->whereId($association_id)->update($data);

        // ASSOCIATION ROAD TYPE
        AssociationRoadType::where(['association_id' => $association_id])->limit(1000)->delete();
        if ($request->road_type && is_array($request->road_type)) {
            foreach ($request->road_type as $row) {
                $row = (object) $row;
                if ($row->road_type_id)
                    AssociationRoadType::create([
                        'association_id' => $association_id,
                        'road_type_id'   => $row->road_type_id,
                        'distance'       => $row->distance,
                        'unit'           => $row->unit
                    ]);
            }
        }

        //
        AssociationControlFlow::updateOrCreate(
            ['association_id'   => $association_id],
            [
                'association_id'            => $association_id,
                'field_officer_id'          => $request->user()->id,
                'chilling_plant_id'         => $request->user()->chilling_plant_id,
                'chilling_plant_manager_id' => 0,
                'is_forward_for_correction' => 0,
                'remark'                    => '',
            ]
        );

        AssociationHistory::create([
            'date'           => date('Y-m-d'),
            'user_id'        => $request->user()->id,
            'association_id' => $association_id,
            'status'         => ($request->re_appllication ? 'চিলিং প্ল্যান্ট অফিসারের নিকট আবেদন পুনরায় প্রেরণ করা হয়েছে' : 'চিলিং প্ল্যান্ট অফিসারের নিকট আবেদন প্রেরণ করা হয়েছে'),
            'remark'         => ($request->re_appllication ? 'মাঠ কর্মকর্তা চিলিং প্লান্ট কর্মকর্তার নিকট আবেদন পুনরায় প্রেরণ করেছেন।' : 'মাঠ কর্মকর্তা চিলিং প্লান্ট কর্মকর্তার নিকট আবেদন প্রেরণ করেছেন।'),
        ]);

        return response()->json($association);
    }

    public function mkHistory($request, $type, $association_id)
    {
        $log = [];

        if ($type == 'plant-manager-approved') 
        {
            $log  = [
                'status' => 'চিলিং প্লান্ট ম্যানেজার আবেদনটি অনুমোদন করেছেন', 
                'remark' => ''
            ];
        } 
        else if ($type == 'forward') 
        {
            $log  = [
                'status' => 'মিল্ক ভিটা চেয়ারম্যানের নিকট আবেদন প্রেরণ করা হয়েছে', 
                'remark' => 'চিলিং প্লান্ট ম্যানেজার মিল্ক ভিটা চেয়ারম্যানের নিকট আবেদন প্রেরণ করেছেন।'
            ];
        } 
        else if ($type == 'resolution-submit') 
        {
            $log  = [
                'status' => 'মিটিং রেজুলেশন সাবমিট করা হয়েছে', 
                'remark' => 'চিলিং প্লান্ট ম্যানেজারের নিকট মিটিং রেজুলেশন পাঠানো হয়েছে'
            ];
        } 
        else if ($type == 'forward-for-correction') 
        {
            $log  = [
                'status' => 'সংশোধনের জন্য ফিল্ড অফিসারের নিকট পাঠানো হয়েছে', 
                'remark' => $request->remark
            ];
        }
        else if ($type == 'plant-manager-reject') 
        {
            $log  = [
                'status' => 'চিলিং প্লান্ট ম্যানেজার আবেদনটি বাতিল করেছেন ', 
                'remark' => $request->remark
            ];
        }
        else if ($type == 'plant-officer-reject') 
        {
            $log  = [
                'status' => 'মিল্ক ভিটা চেয়ারম্যান আবেদনটি বাতিল করেছেন', 
                'remark' => $request->remark
            ];
        }

        else if ($type == 'plant-officer-approved') 
        {
            $log  = [
                'status' => 'মিল্ক ভিটা চেয়ারম্যান আবেদনটি অনুমোদন করেছেন', 
                'remark' => ''
            ];
        } 
        //
        $log = array_merge($log, [
            'date'           => date('Y-m-d'),
            'user_id'        => $request->user()->id,
            'association_id' => $association_id
        ]);
        //
        AssociationHistory::create($log);
    }

    public function statusUpdate(Request $request, AssociationControlFlow $controlFlow, $association_id)
    {
        $status = $controlFlow->where('association_id', $association_id);
        //
        if ($request->type == 'plant-manager') {
            if ($request->status == 'approve') {
                $status->update([
                    "chilling_plant_manager_id"          => $request->user()->id,
                    "is_approved_chilling_plant_manager" => 1,
                    "is_reject_chilling_plant_manager"   => 0,
                    "is_forward_chilling_plant_manager"  => 0,
                    "is_forward_for_correction"          => 0,
                    "is_resolution"                      => 0,
                    "remark"                             => '',
                ]);
                $this->mkHistory($request, 'plant-manager-approved', $association_id);
            } 
            else if ($request->status == 'reject') {
                $status->update([
                    "chilling_plant_manager_id"          => $request->user()->id,
                    "is_approved_chilling_plant_manager" => 0,
                    "is_reject_chilling_plant_manager"   => 1,
                    "is_forward_chilling_plant_manager"  => 0,
                    "is_forward_for_correction"          => 0,
                    "is_resolution"                      => 0,
                    "remark"                             => $request->remark,
                ]);
                $this->mkHistory($request, 'plant-manager-reject', $association_id);
            } 
            else if ($request->status == 'correction') {
                $status->update([
                    "chilling_plant_manager_id"          => $request->user()->id,
                    "is_approved_chilling_plant_manager" => 0,
                    "is_reject_chilling_plant_manager"   => 0,
                    "is_forward_chilling_plant_manager"  => 0,
                    "is_forward_for_correction"          => 1,
                    "is_resolution"                      => 0,
                    "remark"                             => $request->remark,
                ]);
                $this->mkHistory($request, 'forward-for-correction', $association_id);
            } 
            else if ($request->status == 'forward') {
                $status->update([
                    "chilling_plant_manager_id"          => $request->user()->id,
                    "is_approved_chilling_plant_manager" => 1,
                    "is_reject_chilling_plant_manager"   => 0,
                    "is_forward_chilling_plant_manager"  => 1,
                    "is_forward_for_correction"          => 0,
                    "is_resolution"                      => 1,
                    "remark"                             => '',
                ]);
                $this->mkHistory($request, 'forward', $association_id);
            }
        }
        //
        if ($request->type == 'plant-officer') {
            if ($request->status == 'approve') {
                $status->update([
                    "milkvita_officer_id"           => $request->user()->id,
                    "is_approved_milkvita_officer"  => 1,
                    "is_reject_milkvita_officer"    => 0,
                ]);
                $this->mkHistory($request, 'plant-officer-approved', $association_id);
                
                // ASSOCIATION DATA SEND TO DASHBOARD
                SYNCAssociation($association_id, 'temporary_approved');
            } 
            else if ($request->status == 'reject') {
                $status->update([
                    "milkvita_officer_id"           => $request->user()->id,
                    "is_approved_milkvita_officer"  => 0,
                    "is_reject_milkvita_officer"    => 1,
                    "remark"                        => $request->remark,
                ]);
                $this->mkHistory($request, 'plant-officer-reject', $association_id);
            }
        }
        //
        return 1;
    }

    //
    public function resolutionSubmit(Request $request, AssociationControlFlow $controlFlow, $association_id)
    {
        $validator_field = [
            "dairy_storage_area"    => 'required',
            "committee_members"     => 'required',
            "bank_infos"            => 'required',
            "manager_infos"         => 'required',
            "manager_infos.email"   => 'required|unique:users,email',
            "manager_infos.mobile"  => 'required|unique:users,mobile',
        ];
        //
        $validator = Validator::make($request->all(), $validator_field);
        if($validator->fails()){ return response(['errors' => $validator->errors()->all()], 200);}


        // GET ASSOCIATION INFO
        $association = Association::whereId($association_id)->first();


        // GET ALL ASSOCIATION MEMBERS AND MAKE LOGIN ACCESS
        $members = AssociationMember::where('association_id', $association_id)
        ->select(
            'member_name as name_bn',
            'member_name as name_en',
            'member_code as username',
            'association_id',
            'email',
            'mobile',
            'nid as nid_no',
            'id as asso_member_id',
        )
        ->get()->makeHidden(['designation','total_cattle']);

        $role = Role::where('slug', 'association-member')->first();

        $collection = collect($members)->map(function($row, $key) use ($role)
        {
            $row->password = Hash::make(123456);
            $row->role_id  = ($role->id ?? 0);
            User::create($row->toArray())->roles()->sync([$role->id]);
            return $row->toArray();
        });

        // User::insert($collection->toArray());


        // UPDATE MEMBER GEO LOCATION
        // AssociationMember::where('association_id', $association_id)->update([
        //     'division_id' => $association->association_division_id,
        //     'district_id' => $association->association_district_id,
        //     'upazila_id'    => $association->association_thana_id,
        // ]);

        // ASSOCIATION MODULE UPDATE
        Association::whereId($association_id)->update(['dairy_storage_area' => $request->dairy_storage_area]);

        // MAKE ACCESS FOR ASSOCIATION MANGER
        if($request->manager_infos && $request->type!='re-submit')
        {
            $role = Role::where('slug', 'association-manager')->first();
            $manager = (Object)$request->manager_infos;
            //
            User::create([
                "association_id" => $association_id,
                "role_id"        => ($role->id ?? 0),
                "entity_id"      => ($role->entity_id ?? 0),
                "name_bn"        => ($manager->name_bn ?? ''),
                "username"       => ($manager->mobile ?? ''),
                "mobile"         => ($manager->mobile ?? ''),
                "email"          => ($manager->email ?? ''),
                "nid_no"         => ($manager->nid_no ?? ''),
                "address"        => ($manager->address ?? ''),
                "password"       => Hash::make(123456),
                "type"           => 'association-manager',
            ])
            ->roles()->sync([$role->id]);
        }


        // COMMITTEE MEMBER UPDATE
        if($request->committee_members && is_array($request->committee_members)) {
            AssociationCommiteeMember::where(['association_id'=>$association_id])->limit(1000)->delete();
            foreach ($request->committee_members as $row) {
                //
                $row = (object)$row;
                AssociationCommiteeMember::create([
                    'member_id'      => $row->member_id,
                    'designation_id' => $row->designation_id,
                    'association_id' => $association_id,
                ]);
            }
        }

        // BANK INFO UPDATE
        if ($request->bank_infos && is_array($request->bank_infos)) {
            AssociationBankInfo::where(['association_id'=>$association_id])->limit(1000)->delete();
            foreach ($request->bank_infos as $key => $row) {
                //
                $row = (object)$row;
                AssociationBankInfo::create([
                    "association_id"    => $association_id,
                    "bank_name"         => $row->bank_name,
                    "branch_name"       => $row->branch_name,
                    "type"              => ($key == "commission_account" ? "commission_account" : "bill_account"),
                ]);
            }
        }
        //
        AssociationControlFlow::where("association_id", $association_id)->update([
            "is_resolution" => 1
        ]);
        $this->mkHistory($request, 'resolution-submit', $association_id);
        //
        return 1;
    }

    //
    public function log(Request $request, AssociationHistory $history, $association_id = null)
    {
        if($association_id){
            return response()->json($history->where('association_id', $association_id)->get()->toArray());
        } 
        else {
            return response(['errors' => ['Association ID is\'t valid!!']], 200);
        }
    }

    //  UPDATE BANK INFO
    public function updateBankInfo(Request $request, AssociationBankInfo $bank_info, $association_id = null)
    {
        $bank_info = $bank_info->where('association_id', $association_id);
        //
        if($association_id && !$bank_info->get()->isEmpty())
        {
            if($request->bank_infos && is_array($request->bank_infos)){
                foreach($request->bank_infos as $key=>$bank){
                    $bank = (Object)$bank;
                    if($key=='commission_account' || $key=='bill_account'){
                        AssociationBankInfo::where('association_id', $association_id)->where('type', $key)->update([
                            'account_no'  => $bank->account_no,
                            'holder_name' => $bank->holder_name,
                            'signatories' => json_encode($bank->signatories),
                        ]);
                    }
                }
            }
            return 1;
        }
        else return response()->json(['erros'=>['Something is wrong!!']]);
    }
}

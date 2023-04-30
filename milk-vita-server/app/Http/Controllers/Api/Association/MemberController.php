<?php

namespace App\Http\Controllers\Api\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\AssociationMember;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, AssociationMember $member)
    {
        $where = where($request->where); $total_member = 0;
        //
        if($request->user()->type=='association-manager') 
        {
            $where[]      = ['association_id', '=', $request->user()->association_id];
            $total_member = AssociationMember::where('association_id', '=', $request->user()->association_id)->count();
        }
        else if(isset($request->where['association_id']))
        {
            $total_member = AssociationMember::where('association_id', '=', $request->where['association_id'])->count();
        }


        // SELECTED ATTRIBUTE
        if ($request->select) {
            $member = $member->select($request->select);
        }
        //
        $member = $member->with(['division:id,bn_name', 'district:id,bn_name', 'thana:id,bn_name']);

        // MAKE PAGINATED DATA
        $data = paginate($member, $where, $request->per_page, $request->page_no);

        $data['total_member'] = $total_member;

        // RETURN RESPOONSE
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, AssociationMember $member)
    {
        $validator = Validator::make($request->all(), [
            'association_id'         => 'required',
            'members'                => 'required|array',
            'members.*.gender'       => 'required',
            'members.*.gender.id'    => 'required',
            'members.*.mobile'       => 'required',
            'members.*.geolocation'             => 'required|array',
            'members.*.geolocation.division_id' => 'required',
            'members.*.geolocation.district_id' => 'required',
            'members.*.geolocation.upazila_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }

        //
        $association = Association::whereId($request->association_id);
        if (!$association->get()->isEmpty()) {

            if ($request->members && is_array($request->members)) {
                foreach ($request->members as $row) 
                {
                    $data = collect($row)->only(
                        "member_name",
                        "spouse_name_en",
                        "village",
                        "age",
                        "mobile",
                        "amount_of_milk_produced",
                        "where_sales_are",
                        "total_gavi",
                        "total_bokna",
                        "total_bokon_bachor",
                        "total_are_bachor",
                        "total_shar",
                        "total_bolod",
                        "total_mohish",
                        "remark",
                    )->toArray();

                    $data['spouse_name_bn'] = $data['spouse_name_en'];

                    //
                    $data = array_merge($data, 
                    [
                        "association_id" => $request->association_id,
                        "user_id"        => $request->user()->id,
                        "gender_id"      => $row['gender']['id'],
                        "gender_details" => json_encode($row['gender']),
                        //
                        "division_id" => $row['geolocation']['division_id'],
                        "district_id" => $row['geolocation']['district_id'],
                        "upazila_id"  => $row['geolocation']['upazila_id'],
                        //
                        "location_details" => json_encode([
                            "division" => locationFromDashboard(['location_id'=>$row['geolocation']['division_id']]),
                            "district" => locationFromDashboard(['location_id'=>$row['geolocation']['district_id']]),
                            "upazila"  => locationFromDashboard(['location_id'=>$row['geolocation']['upazila_id']]),
                        ]),
                    ]);

                    $member->create($data);
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
    public function update(Request $request, AssociationMember $member, $member_id)
    {
        //
        $validator = Validator::make($request->all(), [
            'association_id'         => 'required',
            'gender'       => 'required',
            'gender.id'    => 'required',
            'mobile'       => 'required',
            'geolocation'             => 'required|array',
            'geolocation.division_id' => 'required',
            'geolocation.district_id' => 'required',
            'geolocation.upazila_id'  => 'required',
        ]);
        //
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }
        //
        $member = $member->whereId($member_id);
        //
        if (!$member->get()->isEmpty()) {
            $data = $request->only(
                "member_name",
                "spouse_name_en",
                "village",
                "age",
                "mobile",
                "amount_of_milk_produced",
                "where_sales_are",
                "total_gavi",
                "total_bokna",
                "total_bokon_bachor",
                "total_are_bachor",
                "total_shar",
                "total_bolod",
                "total_mohish",
                "remark",
            );
            if($request->spouse_name_en) $data['spouse_name_bn'] = $request->spouse_name_en;

            $data = array_merge($data, 
            [
                "gender_id"      => $request->gender['id'] ?? 0,
                "gender_details" => json_encode($request->gender),
                //
                "division_id" => $request->geolocation['division_id'],
                "district_id" => $request->geolocation['district_id'],
                "upazila_id"  => $request->geolocation['upazila_id'],
                //
                "location_details" => json_encode([
                    "division" => locationFromDashboard(['location_id'=>$request->geolocation['division_id']]),
                    "district" => locationFromDashboard(['location_id'=>$request->geolocation['district_id']]),
                    "upazila"  => locationFromDashboard(['location_id'=>$request->geolocation['upazila_id']]),
                ]),
            ]);
            return response()->json($member->update($data));
        } 

        else {
            return response(['errors' => ['Something is wrong!! please try again']], 200);
        }
    }

    public function memberProfile(Request $request, AssociationMember $member, $member_id)
    {
        $member = $member->find($member_id);

        return response()->json($member);
    }

    public function updateProfile(Request $request, AssociationMember $member, $member_id)
    {
        $member = $member->find($member_id);
        //
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'association_id' => 'required',
        ]);
        //
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 200);
        }

        if (!$member->get()->isEmpty()) {

            $data = $request->only(
                'user_id',
                'association_id',
                'member_name',
                'member_name_en',
                'member_code',
                'age',
                'nid',
                'date_of_birth',
                'membership_date',
                'bkash_account_number',
                'bank_address',
                'religion',
                'gender',
                'occupation',
                'educational_qualification',
                'email',
                'mobile',
                'father_name_en',
                'father_name_bn',
                'mother_name_en',
                'mother_name_bn',
                'spouse_name_en',
                'spouse_name_bn',
                'village',
                'post_office',
                'division_id',
                'district_id',
                'thana_id',
            );
            return response()->json($member->update($data));
        } else {
            return response(['errors' => ['Something is wrong!! please try again']], 200);
        }
    }
}

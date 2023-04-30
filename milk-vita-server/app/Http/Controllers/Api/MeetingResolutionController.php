<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AssociationMeetingResolution;
use App\Models\AssociationCommiteeMember;
use App\Models\Role;
use App\Models\User, Hash;

class MeetingResolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, AssociationMeetingResolution $AMResolution)
    {
        $where   = where($request->where);

        // SELECTED ATTRIBUTE
        if($request->select){
            $AMResolution = $AMResolution->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($AMResolution->with('manager', 'commitee_members')->orderBy('is_done', 'ASC'), $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function store(Request $request, AssociationMeetingResolution $AMResolution)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "association_id"    => "required",
            "meeting_date"      => "required",
            "meeting_title"     => "required",
        ]);
        if($validator->fails()){return response(['errors'=>$validator->errors()->all()], 200);}
        //
        $data = $request->only("association_id", "meeting_date", "meeting_title");
        $data['field_officer_id'] = $request->user()->id;
        //
        return response()->json($AMResolution->create($data));
    }

    //
    public function resolutionSubmit(Request $request, AssociationMeetingResolution $AMResolution, $resolution_id=null)
    {
        if($resolution_id && $request->type=='general')
        {
            // DATA VALIDATION
            $validator = Validator::make($request->all(), [
                "association_id"     => "required",
                "meeting_resolution" => "required",
            ]);
            if($validator->fails()){return response(['errors'=>$validator->errors()->all()], 200);}

            //
            $record = $AMResolution->where([
                'association_id'=>$request->association_id,
                'id'=>$resolution_id,
                'is_done'=>0
            ]);

            //
            if(!$record->get()->isEmpty()){
                $record->update([
                    'meeting_resolution' => $request->meeting_resolution,
                    'type' => $request->type,
                    'is_done'=>1
                ]);
                return 1;
            }
            else{
                return response()->json(['errors'=>['Something is Wrong!!']]);
            }
        }

        elseif($resolution_id && $request->type=='manager-change')
        {
            // DATA VALIDATION
            $validator = Validator::make($request->all(), [
                "association_id"     => "required",
                "meeting_resolution" => "required",
                "manager_name"       => "required",
                "manager_address"    => "required",
                "manager_mobile"     => "required|unique:users,mobile",
                "manager_mobile"     => "required|unique:users,username",
                "manager_email"      => "required|unique:users,email",
                "manager_nid_no"     => "required|unique:users,nid_no",
            ]);
            //
            if($validator->fails()){return response(['errors'=>$validator->errors()->all()], 200);}

            // GET REQUESTED DATA AND REPLACE KEY OF ARRAY //
            $role = Role::where('slug', 'association-manager')->first();
            $data = [
                'association_id' => $request->association_id,
                "role_id"        => ($role->id ?? 0),
                "entity_id"      => ($role->entity_id ?? 0),
                'type'           => 'association-manager',
                'name_bn'        => $request->manager_name,
                'mobile'         => $request->manager_mobile,
                'email'          => $request->manager_email,
                'nid_no'         => $request->manager_nid_no,
                'address'        => $request->manager_address,
                'name_bn'        => $request->manager_name,
                'username'       => $request->manager_mobile,
                'password'       => Hash::make(123456),
            ];

            // HERE DISABLED OLD ASSOCIATON MANAGER AND CREATE A NEW MANAGER
            User::where([
                'type'=>'association-manager',
                'association_id'=>$request->association_id,
            ])
            ->update(['trash'=>1]);
            User::create($data);


            /********************************************************************/
            $record = $AMResolution->where([
                'association_id'=>$request->association_id,
                'id'=>$resolution_id,
                'is_done'=>0
            ]);

            //
            if(!$record->get()->isEmpty()){
                $record->update([
                    'meeting_resolution' => $request->meeting_resolution,
                    'type'    =>$request->type,
                    'is_done' =>1
                ]);
                return 1;
            }
            else{
                return response()->json(['errors'=>['Something is Wrong!!']]);
            }
        }


        if($resolution_id && $request->type=='committee-change')
        {
            // DATA VALIDATION
            $validator = Validator::make($request->all(), [
                "association_id"     => "required",
                "meeting_resolution" => "required",
                "commitee_members"   => "required",
            ]);

            if($validator->fails()){return response(['errors'=>$validator->errors()->all()], 200);}

            //
            $record = $AMResolution->where([
                'association_id'    => $request->association_id,
                'id'                => $resolution_id,
                'is_done'           => 0
            ]);

            //
            if($request->commitee_members && is_array($request->commitee_members))
            {
                AssociationCommiteeMember::where('association_id', $request->association_id)->limit(10000)->update(['trash'=>1]);
                //
                foreach ($request->commitee_members as $key => $row)
                {
                    $row = (Object)$row;
                    AssociationCommiteeMember::create([
                        'member_id'      => $request->association_id,
                        'member_id'      => $row->member_id,
                        'designation_id' => $row->designation_id,
                    ]);
                }
            }

            //
            if(!$record->get()->isEmpty()){
                $record->update([
                    'meeting_resolution' => $request->meeting_resolution,
                    'type'               => $request->type,
                    'is_done'            => 1
                ]);
                return 1;
            }
            else{
                return response()->json(['errors'=>['Something is Wrong!!']]);
            }
        }
        else {
            return response()->json(['errors'=>['Something is Wrong!!.']]);
        }
    }

}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ZoneMap;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Cache;

class AuthController extends Controller
{
    public function register (Request $request) 
    {
        /* ********************
        *   DATA VALIDATION
        * ******************* */
        $validate = [
            'name_bn'       => 'required|string|max:255',
            'username'      => 'required|string|unique:users,username',
            'mobile'        => 'required|string|max:255|unique:users,mobile',
            'division_id'   => 'required',
            'district_id'   => 'required',
            'thana_id'      => 'required',
            'password'      => 'required|string|min:6|confirmed',
        ];
        //
        if($request->email){
            $validate['email'] = 'required|string|email|max:255|unique:users,email';
        }
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200); }
        /* ********************
        *   DATA VALIDATION
        * ******************* */
        $data = $request->only(
            'name_bn',
            'username',
            'mobile',
            'email',
            'photo',
            'entity_id',
            'association_id',
            'chilling_plant_id',
            'processing_plant_id',
            'role_id',
            'designation_id',
            'division_id',
            'district_id',
            'thana_id',
        );
        $data['password']       = Hash::make($request['password']);
        $data['remember_token'] = Str::random(10);
        //
        $sso_data = [
            "name"      => $request->name_bn,
            "username"  => $request->username,
            "email"     => $request->email,
            "password"  => $request->password,
            "profile"   => [
                "nid"   => $request->nid,
                "tin"   => "1234"
            ]
        ];
        //
        $url        = curl_init(config("app.dashboard_url")."/api/v1/user");
        $header     = ['Content-Type:application/json'];
        //
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($sso_data));
        //
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = (Array)json_decode($resultdata, true);

        $data['sso_user_id'] = $response['id'] ?? 0;



        return response(User::create($data), 200);
    }

    public function login(Request $request) 
    {
        if($request->token){
            // LOOKING FOR ASSO USER
            $user = User::getSSOUser($request->token);

            if($user){
                if($request->user()){
                    // REVOKE OLD TOKEN
                    $request->user()->token()->revoke();
                }
                // GENERATE A NEW TOKEN
                return response()->json($user->createToken('milk-vita')->accessToken);
            }
            else 
                return response()->json(['errors'=>['User Not Found']]);
            //
        }
        else {
            $validator = Validator::make($request->all(), [
                'username'  => 'required|string|max:255',
                'password'  => 'required|string|min:6',
            ]);

            if ($validator->fails()){
                return response(['errors'=>$validator->errors()->all()], 200);
            }
            //
            $user = User::where('username', $request->username)->first();
            //
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token    = $user->createToken('milk-vita')->accessToken;
                    $response = ['token' => $token];
                    //
                    Cache::put('user'.$user->id, [
                        'token'     => $token,
                        'details'   => $user
                    ]);
                    //
                    return response($response, 200);
                } 
                else { return response(["errors" => ["Your credentials does not match in our records"]], 200); }
            } 
            else { return response(["errors" =>['Your credentials does not match in our records']], 200); }
        }
    }

    public function update(Request $request, $user_id){
        if($user_id){
            $old_record = User::where('id', $user_id)->first();

            // USER PROFILE PHOTO
            if($request->photo){
                if(file_exists($old_record->photo_path))
                    unlink($old_record->photo_path);
                //
                User::where('id', $user_id)->update([
                    'photo_path'=>imageUpload('photo', $request->photo, time())
                ]);
            }

            // USER SIGNATURE
            if($request->signature){
                if(file_exists($old_record->signature_path))
                    unlink($old_record->signature_path);
                //
                User::where('id', $user_id)->update([
                    'signature_path'=>imageUpload('signature', $request->signature, time())
                ]);
            }
            //
            $data = $request->only(
                'name_bn',
                'name_en',
                'mobile',
                'email',
                'entity_id',
                'association_id',
                'chilling_plant_id',
                'processing_plant_id',
                'role_id',
                'designation_id',
                'division_id',
                'district_id',
                'thana_id',
                'fathers_name_bn',
                'fathers_name_en',
                'mothers_name_bn',
                'mothers_name_en',
                'husband_or_wife_name_bn',
                'husband_or_wife_name_en',
                'date_of_birth',
                'religion',
                'sex',
                'nid_no',
            );

            if($data){

                /* ********************
                *   DATA VALIDATION
                * ******************* */
                $validate = [
                    'name_bn' => 'required|string|max:255',
                ];

                // OPTIONAL VALIDATION
                if($old_record->mobile != $request->mobile)
                    $validate['mobile'] = 'required|string|max:255|unique:users,mobile';
                if($request->password)
                    $validate['password'] = 'required|string|min:6|confirmed';
                if($old_record->email != $request->email)
                    $validate['email'] = 'required|string|email|max:255|unique:users,email';
                $validator = Validator::make($request->all(), $validate);
                if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200); }
                /* ********************
                *   END DATA VALIDATION
                * ******************* */


                \DB::table('zone_maps')->where('user_id', $user_id)->delete();
                //
                if($request->zone_ids && is_array($request->zone_ids)){
                    $request->collect('zone_ids')->each(function($value) use ($user_id)
                    {
                        ZoneMap::create([
                            "zone_id" => $value,
                            "user_id" => $user_id
                        ]);
                    });
                }

                
                // PASSWORD RESET
                if($request->password){
                    $data['password'] = Hash::make($request['password']);
                }
                User::where('id', $user_id)->update($data);
            }


            $user = User::where('id', $user_id)->first();
            //
            $cache = Cache::get('user'.$user_id);
            //
            $cache['details'] = $user;
            
            Cache::put('user'.$user_id, $cache);

            return response($user, 200);
        }
        else {
            return response(['errors'=>'Something is wrong!!'], 200);
        }
    }

    public function logout (Request $request) 
    {

        $user        = Cache::get('user'.($request->user()->id));
        //
        $accessToken = auth()->user()->token();
        $request->user()->tokens->find($accessToken)->revoke();
        //


        $url = curl_init("http://dashboard.rdcd.orangebd.com/api/v1/logout");
        $header = array(
            'Content-Type:application/json',
            "Authorization: Bearer ".$user['token']
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $sso_user_data = json_decode(curl_exec($url), true);
        curl_close($url);
        $request->user()->token()->revoke();


        Cache::clear();

        return response()->json(1);
    }

    public function ForgotPassword(Request $request)
    {
        if(!(Hash::check($request->old_password, $request->user()->password))){
            return response(['errors'=>['আপনার পুরানো পাসওয়ার্ড ভুল']], 200);
        }
        //
        $validator = Validator::make($request->all(), ['password'=>'required|string|min:6|confirmed']);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
        //
        User::whereId($request->user()->id)->update(['password'=>Hash::make($request->password)]);
        //
        return 1;
    }
}

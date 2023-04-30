<?php


//
if(!function_exists('ConnectDashboard')){
	function ConnectDashboard()
	{	
		$sso_data = [
            "grant_type" 	=> "client_credentials",
            "client_id" 	=> config('app.dashboard_client'),
            "client_secret" => config('app.dashboard_secret'),
        ];

        $url    = curl_init(config("app.dashboard_url")."/api/v1/oauth/token");
        $header = ['Content-Type:application/json'];
        //
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($sso_data));
        //
        $response = (Array)json_decode(curl_exec($url), true);
        curl_close($url);
        return $response;
        //
        if(array_key_exists('error', $response)) return false; else return $response;
	}
}



if(!function_exists('SendToDashboard')){
	function SendToDashboard($uri, $data=[], $method='POST')
	{	
        $conne = ConnectDashboard();
        
        if(!empty($conne['access_token'])){
	        $token = $conne['access_token'];
	        //
	        $url    = curl_init(config('app.dashboard_url').'/api/v1/'.$uri);
	        $header = [
	            'Content-Type:application/json',
	            'Accept:application/json',
	            'Authorization: Bearer '.$token
	        ];
	        //
	        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($url, CURLOPT_CUSTOMREQUEST, $method);
	        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($data));
	        //
	        $response = json_decode(curl_exec($url), true);
	        curl_close($url);
	        //
	        return $response;
        }
        return false;
	}
}



if(!function_exists('ReadDashboardOffices')){
	function ReadDashboardOffices($dhoptop_id=null)
	{	
        $conne = ConnectDashboard();
        if($conne){
	        $token = $conne['access_token'];
	        //
	        $url    = curl_init(config('app.dashboard_url').'/api/v1/organogram/doptors/'.($dhoptop_id).'/allchildren');
	        $header = [
	            'Content-Type:application/json',
	            'Accept:application/json',
	            'Authorization: Bearer '.$token
	        ];
	        //
	        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
	        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
	        //
	        $response = json_decode(curl_exec($url), true);
	        curl_close($url);

	        return $response;
        }
	}
}



if(!function_exists('locationFromDashboard')){
	function locationFromDashboard($niddle=[])
	{	
		$url = config('app.dashboard_url')."/api/v1/geo/types";
		//
		if($niddle && array_key_exists('type_id', $niddle))
		{
			$url = config('app.dashboard_url')."/api/v1/geo/types/{$niddle['type_id']}/locations";
		}
		else if($niddle && array_key_exists('location_id', $niddle))
		{
			$url = config('app.dashboard_url')."/api/v1/geo/locations/{$niddle['location_id']}";
		}
		else if($niddle && array_key_exists('type_child_id', $niddle))
		{
			$url = config('app.dashboard_url')."/api/v1/geo/locations/{$niddle['type_child_id']}/children";
		}
		else if($niddle && array_key_exists('type', $niddle))
		{
			$url = config('app.dashboard_url')."/api/v1/geo/types/1/locations";

			if($niddle['type']=='children' && array_key_exists('id', $niddle))
			{
				$url = config('app.dashboard_url')."/api/v1/geo/locations/{$niddle['id']}/children";
			}
			else if ($niddle['type']=='division') 
			{
				$url = config('app.dashboard_url')."/api/v1/geo/types/1/locations";
			}
			else if ($niddle['type']=='district') 
			{
				$url = config('app.dashboard_url')."/api/v1/geo/types/2/locations";
			}
			else if ($niddle['type']=='upazila') 
			{
				$url = config('app.dashboard_url')."/api/v1/geo/types/3/locations";
			}
			else if ($niddle['type']=='union') 
			{
				$url = config('app.dashboard_url')."/api/v1/geo/types/4/locations";
			}
		}

		$connection = ConnectDashboard();
		$token 		= $connection['access_token'];
		//
        $url    = curl_init($url);
        $header = [
        	'Content-Type:application/json',
        	'Authorization: Bearer '.$token
        ];
        //
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        //
        $response = json_decode(curl_exec($url), true);
        curl_close($url);

        //
        if(array_key_exists('data', $response))
        {
        	return collect($response['data'])->map(function($row) use ($niddle)
        	{
        		if(array_key_exists('localization', $niddle))
        		(!empty($row['name'][$niddle['localization']]) ? ($row['name'] = $row['name'][$niddle['localization']]) : '');
        		//
        		return $row;
        	});
        }
        return $response;
	}
}



if(!function_exists('SYNCAssociation'))
{
	function SYNCAssociation($association_id=null, $status="pending")
	{	
		if($association_id)
        {
            $data = (array) \DB::table('associations')->where('id', $association_id)->select(
                "id",
                "id as local_id",
                "association_name as name_en",
                "association_name as name_bn",
                "association_code as code",
                //
                "association_division_id as geo_division_id",
                "association_district_id as geo_district_id",
                "association_upazila_id as geo_upazila_id",
                "association_union_id as geo_union_id",
                "association_village as detail_address",

            )->first();

            //
            $members = \DB::table("association_members")->where('association_id', $association_id)->select(
                "id as local_id",
                "member_name as name_bn",
                "member_name_en as name_en",
                "member_code as code",
                "mobile",
                "gender_id",
                "division_id as geo_division_id",
                "district_id as geo_district_id",
                "upazila_id as geo_upazila_id",
                "village",
            )->get()->toArray();

            //
            $members = collect($members)->map(function($row)
            {
                $row               = (array) $row;
                $row['name_en']    = ($row['name_en'] ? $row['name_en'] : $row['name_bn']);
                $row['user']       = (array) \DB::table('users')->where('asso_member_id', $row['local_id'])->select('id', 'role_id')->first();
                $row['addresses']  = [
                    [
                        "address_type"    => "PRE",
                        "geo_division_id" => $row['geo_division_id'],
                        "geo_district_id" => $row['geo_district_id'],
                        "geo_upazila_id"  => $row['geo_upazila_id'],
                        "detail_address"  => $row['village']
                    ],
                    [
                        "address_type"    => "PER",
                        "geo_division_id" => $row['geo_division_id'],
                        "geo_district_id" => $row['geo_district_id'],
                        "geo_upazila_id"  => $row['geo_upazila_id'],
                        "detail_address"  => $row['village']
                    ]
                ];

                unset($row['geo_division_id']);
                unset($row['geo_district_id']);
                unset($row['geo_upazila_id']);
                unset($row['village']);

                return $row;

            })->toArray();



            /*
			 * ***********************
			 * ASSOCIATION MANAGER
			 * ********************
            */
            $asso_manager = (array) \DB::table('users')->where(['association_id'=>$association_id, 'type'=>'association-manager'])
            ->join('associations', 'associations.id', '=', 'users.association_id')
            ->orderBy('id', 'DESC')
            ->select(
                "users.id",
                "users.id as local_id",
                "users.name_en",
                "users.name_bn",
                "users.mobile",
                "associations.association_code as code",
                "associations.association_village as village",
                "associations.association_division_id as division_id",
                "associations.association_district_id as district_id",
                "associations.association_upazila_id as upazila_id",

            )->first();

            $manger_role_id = (\DB::table('roles')->where('slug', 'association-manager')->select('id')->first()->id ?? false);

            if($asso_manager && $manger_role_id)
            {
	            $asso_manager['user'] = [
	            	'id' 	  => $asso_manager['local_id'],
	            	'role_id' => $manger_role_id,
	            ];
	            $asso_manager['addresses']  = [
	                [
	                    "address_type"    => "PRE",
	                    "geo_division_id" => $asso_manager['division_id'],
	                    "geo_district_id" => $asso_manager['district_id'],
	                    "geo_upazila_id"  => $asso_manager['upazila_id'],
	                    "detail_address"  => $asso_manager['village']
	                ],
	                [
	                    "address_type"    => "PER",
	                    "geo_division_id" => $asso_manager['division_id'],
	                    "geo_district_id" => $asso_manager['district_id'],
	                    "geo_upazila_id"  => $asso_manager['upazila_id'],
	                    "detail_address"  => $asso_manager['village']
	                ]
	            ];

	            $asso_manager['name_en'] = $asso_manager['name_en'] ?? $asso_manager['name_bn'];
	            $asso_manager['name_bn'] = $asso_manager['name_bn'] ?? $asso_manager['name_en'];
	            //
	            unset($asso_manager['division_id']);
	            unset($asso_manager['district_id']);
	            unset($asso_manager['upazila_id']);
	            unset($asso_manager['village']);
	            //
	            $members[] = $asso_manager;
	        }

            //
            $data = array_merge($data, 
                [
                    "number_of_share"  => 0,
                    "per_share_price"  => 0,
                    "origin_doptor_id" => 10,
                    "status"           => $status ?? '',
                    "members"          => $members
                ]
            );
            //
            return SendToDashboard('associations', $data);
        }
		return false;

	}
}










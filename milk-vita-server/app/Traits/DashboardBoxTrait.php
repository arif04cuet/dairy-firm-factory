<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductCategory, DB;
use Illuminate\Http\Request;

trait DashboardBoxTrait
{
	static function milkCollection($slugs=[])
	{
		$user    	  = self::$user;
		$query   	  = [];
		$fd_week 	  = date("Y-m-d", strtotime("last week saturday"));
		$current_date = date("Y-m-d");


		//
		foreach($slugs as $slug)
		{
			switch($slug){
				case 'total_milk_collection':
					$query[] = DB::raw("(SELECT SUM(amount_of_milk) FROM milk_collection_in_associations WHERE association_id = {$user->association_id}) as total_collection");
					$query[] = DB::raw("(SELECT SUM(amount_of_milk) FROM milk_collection_in_associations WHERE association_id = {$user->association_id} AND date >= '{$fd_week}' AND date <= '{$current_date}') as last_week_collections");
					break;

				case 'total_cattle':
					$query[] = DB::raw("(SELECT sum(total_gavi + total_bokna +  total_bokon_bachor +  total_are_bachor +  total_shar +  total_bolod +  total_mohish) FROM association_members WHERE association_id = {$user->association_id}) as total_cattle");
					break;

				case 'total_association_member':
					$query[] = DB::raw("(SELECT count(id) FROM association_members WHERE association_id = {$user->association_id}) as total_asso_member");
					break;

				case 'total_primary_servey':
					$query[] = DB::raw("(SELECT COUNT(id) FROM associations where user_id = users.id AND id NOT IN (SELECT id FROM association_control_flows WHERE field_officer_id = {$user->id})) as total_primary_survey");
					break;

				case 'total_pending_application':
					$query[] = DB::raw("(
		                SELECT 
		                	COUNT(associations.id) 
		                FROM 
		                	association_control_flows
		                JOIN 
		                	associations 
		                ON 
		                	associations.id = association_control_flows.association_id
		                where 
		                	associations.user_id = {$user->id}
		                AND 
		                	association_control_flows.is_approved_milkvita_officer = 0) as total_pending_application
		            ");
		            break;


		        case 'total_primary_association':
		            $query[] = DB::raw("(
		                SELECT 
		                    COUNT(associations.id) 
		                FROM 
		                    association_control_flows
		                JOIN 
		                    associations 
		                ON
		                    associations.id = association_control_flows.association_id
		                where 
		                    associations.user_id = {$user->id}
		                AND 
		                    association_control_flows.is_approved_milkvita_officer = 1
		                AND 
		                    association_control_flows.is_approved_cooperative_officer = 0
		                ) 
		                as total_primary_association
			        ");
					break;
			}
		}
		//
		self::$info_boxes = DB::table('users')->whereId($user->id)
		->select($query)->first();
	}
}
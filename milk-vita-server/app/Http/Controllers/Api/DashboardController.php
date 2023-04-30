<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\ProductStock, DB;
use App\Models\{
    ChallanAssociationToChillingPlant,
    AssociationMeetingResolution,
    MilkChallanFromChillingPlant,
    MilkCollectionInAssociation,
    AssociationControlFlow,
    DistributorDemand,
    MilkChallanBulk,
    Association,
    MilkStock,
    ShopOrder,
    TaskSchedule,
};
use App\Traits\{
    DashboardBoxTrait,
    DashboardModuleTrait,
};



class DashboardController extends Controller
{
    static $info_boxes   = [];
    static $info_modules = [];
    static $user         = '';

    use DashboardBoxTrait;
    use DashboardModuleTrait;

    public function dashboard(Request $request)
    {
        self::$user = $request->user();
        //
        if($request->slugs && is_array($request->slugs)) 
            $this->milkCollection($request->slugs);

        if($request->modules && is_array($request->modules)) 
        {
            foreach ($request->modules as $module) {
                switch ($module) {
                    case 'milk-collection':
                        $this->milkCollection();
                        break;
                }
            }
        }

        return response([
            'info_boxes'   => self::$info_boxes,
            'info_modules' => self::$info_modules,
        ]);


        /*
            $role_slug = $request->user()->role_slug;
            //
            if($role_slug=='association-manager'){
                return $this->associationManager($request);
            }
            else if($role_slug=='chilling-plant-manager'){
                return $this->chillingPlantManager($request);
            }
            else if($role_slug=='field-officer'){
                return $this->fieldOfficer($request);
            }
            else if($role_slug=='processing-plant-manager'){
                return $this->processingPlantManager($request);
            }
            else if($role_slug=='distributor'){
                return $this->distributor($request);
            }
            else if($role_slug=='delivery-man'){
                return $this->delivery($request);
            }
            else if($role_slug=='qc-manager-processing-plant'){
                return $this->qcManager($request);
            }
            else if($role_slug=='superadmin'){
                return $this->superAdmin($request);
            }
            else if($role_slug=='chilling-plant-officer'){
                return $this->milkVitaOfficer($request);
            }
            else if($role_slug=='zone-supervisor'){
                return $this->zoneSupervisor($request);
            }
            else if($role_slug=='vehicle-manager-processing-plant'){
                return $this->verhicleManager($request);
            }
            else if($role_slug=='driver-processing-plant'){
                return $this->DriverPP($request);
            }
            //
            return '';
        */
    }


    public function DriverPP ($request)
    {
        $user_id = $request->user()->id;
        //
        $total_challan = $total_complete = $total_in_process = MilkChallanFromChillingPlant::where('driver_id', $user_id);
        //
        return response()->json(
        [
            "total_challan"     => ($total_challan->count() ?? 0),
            "total_complete"    => ($total_complete->where('is_qc', 1)->count() ?? 0),
            "total_in_process"  => ($total_in_process->where('is_qc', 0)->count() ?? 0),
        ]);
    }

    //
    public function verhicleManager($request)
    {   
        $processing_plant_id = $request->user()->processing_plant_id;

        $driver = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.processing_plant_id', $processing_plant_id);

        $challan = DB::table('milk_challan_from_chilling_plants')->where('processing_plant_id', $processing_plant_id);

        $total_challan = 0;
        $total_pending_challan = 0;
        //
        return response()->json(
        [
            "total_driver"          => ($driver->count() ?? 0),
            "total_vehicle"         => (DB::table('vehicles')->where('processing_plant_id', $processing_plant_id)->count() ?? 0),
            "total_challan"         => ($challan->count() ?? 0),
            "total_pending_challan" => ($challan->where('is_send_qc', 0)->count() ?? 0),
        ]);

    }

    //
    public function zoneSupervisor()
    {
        $total_demand         = DistributorDemand::count();
        $total_challan        = DistributorDemand::where(['status'=>'challan'])->count();
        $total_pending_demand = DistributorDemand::where(['status'=>'pending'])->count();
        //
        return response()->json(
        [
            "total_demand"          => ($total_demand ?? 0),
            "total_challan"         => ($total_challan ?? 0),
            "total_pending_demand"  => ($total_pending_demand ?? 0),
        ]);
    }

    //
    public function milkVitaOfficer($request)
    {
        $com_condi = [
            'is_forward_chilling_plant_manager'=>1,
            'milkvita_officer_id'=>$request->user()->id,
        ];
        $total_pending = AssociationControlFlow::where(array_merge($com_condi, ['is_approved_milkvita_officer'=>0, 'is_reject_milkvita_officer'=>0]))->count();
        $total_reject  = AssociationControlFlow::where(array_merge($com_condi, ['is_reject_milkvita_officer'=>1]))->count();
        $total_approve = AssociationControlFlow::where(array_merge($com_condi, ['is_reject_milkvita_officer'=>0, 'is_approved_milkvita_officer'=>1]))->count();
        //
        return response()->json(
        [
            "total_pending"  => ($total_pending ?? 0),
            "total_reject"   => ($total_reject ?? 0),
            "total_approve"  => ($total_approve ?? 0),
        ]);
    }

    //
    public function superAdmin()
    {
        $total_user = DB::table('users')->count();
        $total_chilling_plat = DB::table('chilling_plants')->count();
        $total_processing_plant = DB::table('processing_plants')->count();
        $total_zone = DB::table('zones')->count();
        //
        return response()->json(
        [
            "total_user"             => ($total_user ?? 0),
            "total_chilling_plat"    => ($total_chilling_plat ?? 0),
            "total_processing_plant" => ($total_processing_plant ?? 0),
            "total_zone"             => ($total_zone ?? 0),
        ]);
    }

    public function qcManager($request)
    {
        $where = [
            'processing_plant_id' => $request->user()->processing_plant_id,
            'qc_manager_id'       => $request->user()->id,
        ];
        //
        $total_challan = MilkChallanFromChillingPlant::where(['processing_plant_id' => $request->user()->processing_plant_id])->count();
        //
        $total_pending = MilkChallanFromChillingPlant::where($where)->where('is_qc', 0)->count();
        //
        $total_complete = MilkChallanFromChillingPlant::where($where)->where('is_qc', 1)->count();
        //
        return response()->json(
        [
            "total_qc"          => ($total_challan ?? 0),
            "total_complete_qc" => ($total_complete ?? 0),
            "total_pending_qc"  => ($total_pending ?? 0),
            "user"              => $request->user()
        ]);
    }

    public function delivery($request) 
    {
        $total_shop_order = ShopOrder::where([
            'user_id' => $request->user()->id,
            'status'  => 'pending'
        ])
        ->count();
        //
        return response()->json(
        [
            "total_shop_order" => ($total_shop_order ?? 0)
        ]);
    }

    public function distributor($request)
    {
        $total_shop_order = ShopOrder::whereIn(
            'shop_id', 
            DB::table('distributor_shop_maps')->where('distributor_id', $request->user()->id)->pluck('shop_id')
        )
        ->where('status', 'pending')
        ->count();

        //
        $total_delivery = DistributorDemand::where('distributor_id', $request->user()->id)->where('status', 'challan')->count();
        $total_demand   = DistributorDemand::where('distributor_id', $request->user()->id)->where('status', 'pending')->count();

        //
        return response()->json(
        [
            "total_shop_order" => $total_shop_order,
            "total_delivery"   => ($total_delivery ?? 0),
            "total_demand"     => ($total_demand ?? 0),
        ]);
    }

    //
    public function chillingPlantManager($request)
    {
        $milk_stock_quantity = MilkStock::where(
        [
            "stockable_type" => "App\Models\ChillingPlant",
            "stockable_id"   => $request->user()->chilling_plant_id,
        ])
        ->sum('amount');

        //
        $total_incomplete_challan = ChallanAssociationToChillingPlant::where(
        [
            "chilling_plant_id" => $request->user()->chilling_plant_id,
            ["status", "!=", "received"]
        ])
        ->count();

        //
        $total_pending_milk_challan = MilkChallanFromChillingPlant::where(
        [
            "chilling_plant_id" => $request->user()->chilling_plant_id,
            "is_submit"         => 0,
        ])
        ->count();

        //
        $total_applied_application = DB::table("associations")
        ->join("association_control_flows", "association_control_flows.association_id", "=", "associations.id")
        ->where([
            "association_control_flows.chilling_plant_id" => $request->user()->chilling_plant_id
        ])
        ->count();

        return response()->json(
        [
            "milk_stock_quantity"         => ($milk_stock_quantity ?? 0),
            "total_incomplete_challan"    => ($total_incomplete_challan ?? 0),
            "total_pending_milk_challan"  => ($total_pending_milk_challan ?? 0),
            "total_applied_application"   => ($total_applied_application ?? 0),
        ]);
    }

    //
    public function processingPlantManager($request)
    {

        $milk_stock_quantity = ProductStock::where(
        [
            "stockable_type" => 'raw-milk',
            "stockable_id"   => $request->user()->processing_plant_id,
        ])
        ->groupBy('stockable_type')
        ->sum('quantity');

        //
        $total_incomplete_challan = MilkChallanFromChillingPlant::where(
            [
                "processing_plant_id" => $request->user()->processing_plant_id,
                "is_submit"           => 0,
                "is_driver_receive"   => 0,
            ]
        )
        ->count();

        //
        $total_pending_demand = DistributorDemand::where(['status'=>'pending'])->orWhere('status', '!=', 'challan')->count();
        //
        $total_finish_product = ProductStock::where([
            "stockable_type"  => "finish-product",
            "stockable_id"    => $request->user()->processing_plant_id,
        ])->count();

        return response()->json(
        [
            "milk_stock_quantity"      => ($milk_stock_quantity ?? 0),
            "total_incomplete_challan" => ($total_incomplete_challan ?? 0),
            "total_pending_demand"     => ($total_pending_demand ?? 0),
            "total_finish_product"     => ($total_finish_product ?? 0),
        ]);
    }

    //
    public function associationManager($request)
    {
        $association = Association::whereId($request->user()->association_id)
        ->with([
            'members', 
            'milkCollections'=>function($query){
                $query->limit(10);
            }
        ])->first();

        $first_date_of_last_week = date("Y-m-d", strtotime("last week saturday"));

        $last_week_collections = MilkCollectionInAssociation::where(
        [
            ['association_id', $request->user()->association_id],
            ['date', '>=', $first_date_of_last_week],
            ['date', '<=', date('Y-m-d')]

        ])->sum('amount_of_milk');

        //
        return response()->json([
            "total_member"           => ($association->total_members ?? 0),
            "total_cattle"           => $association->members->sum("total_cattle"),
            "last_week_collections"  => $last_week_collections,
            "today_milk_collections" => $association->milkCollections,
        ]);
    }

    //
    public function fieldOfficer($request)
    {
        $data = DB::table('users')
        ->where('id', $request->user()->id)
        ->select(
            DB::raw("(
                SELECT 
                    COUNT(id) 
                FROM 
                    associations 
                where 
                    user_id = users.id
                AND 
                   id NOT IN (SELECT id FROM association_control_flows WHERE field_officer_id = {$request->user()->id})
            ) 
            as total_survey"),
            DB::raw("(
                SELECT 
                    COUNT(associations.id) 
                FROM 
                    association_control_flows
                JOIN 
                    associations 
                ON
                    associations.id = association_control_flows.association_id
                where 
                    associations.user_id = {$request->user()->id}
                AND 
                    association_control_flows.is_approved_milkvita_officer = 0
                ) 
                as total_pending_app
            "),
            DB::raw("(
                SELECT 
                    COUNT(associations.id) 
                FROM 
                    association_control_flows
                JOIN 
                    associations 
                ON
                    associations.id = association_control_flows.association_id
                where 
                    associations.user_id = {$request->user()->id}
                AND 
                    association_control_flows.is_approved_milkvita_officer = 1
                AND 
                    association_control_flows.is_approved_cooperative_officer = 0
                ) 
                as total_primary_asso
            "),
            DB::raw("(
                SELECT 
                    SUM(
                        association_members.total_gavi +
                        association_members.total_bokna +
                        association_members.total_bokon_bachor +
                        association_members.total_are_bachor +
                        association_members.total_shar +
                        association_members.total_bolod +
                        association_members.total_mohish
                    ) 
                FROM 
                    associations
                JOIN 
                    association_members
                ON
                    association_members.association_id = associations.id
                JOIN
                    association_control_flows
                ON
                    associations.id = association_control_flows.association_id
                WHERE 
                    associations.user_id = {$request->user()->id}
                AND
                    association_control_flows.is_approved_chilling_plant_manager = 1
                )
                as total_cattle
            "),
        )
        ->first();

        $meetings = AssociationMeetingResolution::where([
            "field_officer_id" => $request->user()->id,
            "is_done"          => 0,
        ])
        ->select(
            'id', 
            'meeting_date as start', 
            'meeting_title as details',
            DB::raw("(SELECT association_name FROM associations WHERE id = association_meeting_resolutions.association_id) as title")
        )
        ->get()->toArray();


        $tasks = TaskSchedule::where([
            "user_id" => $request->user()->id,
            "is_complete" => 0
        ])
        ->select(
            "id",
            "subject as title",
            "description as details",
            "start_date as start",
            "end_date as end",
            "type",
        )
        ->get()->toArray();



        $data = (array) $data;
        $data['meetings'] = array_merge($meetings, $tasks);

        //
        return response()->json($data);
    }
}

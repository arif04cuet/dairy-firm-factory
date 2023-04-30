<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Reset extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();
        DB::table('role_user')->truncate();
        // DB::table('association_road_types')->truncate();

        DB::table('associations')->truncate();
        DB::table('association_members')->truncate();
        DB::table('association_bank_infos')->truncate();
        DB::table('association_commitee_members')->truncate();
        DB::table('association_control_flows')->truncate();
        DB::table('association_histories')->truncate();
        DB::table('association_meeting_resolutions')->truncate();
        DB::table('milk_collection_in_associations')->truncate();

        DB::table('bank_aplication_for_association_payments')->truncate();
        DB::table('bank_aplication_for_association_payment_details')->truncate();

        DB::table('challan_association_to_chilling_plants')->truncate();

        DB::table('finish_product_q_c_bulks')->truncate();
        DB::table('finish_product_q_c_bulk_items')->truncate();

        DB::table('milk_challan_bulks')->truncate();
        DB::table('milk_challan_from_chilling_plants')->truncate();
        DB::table('milk_challan_category_wises')->truncate();
        DB::table('milk_challan_stock_records')->truncate();
        DB::table('milk_stock_transfers')->truncate();

        DB::table('milk_stocks')->truncate();
        DB::table('test_reports')->truncate();
        DB::table('test_results')->truncate();

        DB::table('shop_orders')->truncate();
        DB::table('shop_order_items')->truncate();

        DB::table('demands')->truncate();
        DB::table('demand_items')->truncate();
        DB::table('demand_details')->truncate();

        DB::table('distributor_demands')->truncate();
        DB::table('distributor_demand_items')->truncate();

        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();

        DB::table('bank_aplication_for_association_payment_details')->truncate();
        DB::table('bank_aplication_for_association_payments')->truncate();
        DB::table('finish_product_q_c_bulks')->truncate();
        DB::table('formula_packing_items')->truncate();

        DB::table('transfer_milk_to_cold_room_items')->truncate();
        DB::table('transfer_milk_to_cold_rooms')->truncate();

        DB::table('u_a_p_bulk_items')->truncate();
        DB::table('u_a_p_bulks')->truncate();
        DB::table('applications')->truncate();

        DB::table('association_bill_records')->truncate();
        DB::table('association_bill_details')->truncate();
        
        DB::table('closing_milk_stocks')->truncate();
        DB::table('notifications')->truncate();
        DB::table('product_stocks')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
    }
}

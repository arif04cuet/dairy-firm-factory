<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB, Hash;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        //
        DB::table('roles')->insert([
            [
                'id'          => 1,
                'is_system'   => 1,
                'entity_id'   => 0,
                'role_name'   => 'SuperAdmin',
                'slug'        => 'superadmin',
            ],
            [
                'id'          => 2,
                'is_system'   => 1,
                'entity_id'   => 1,
                'role_name'   => 'Chilling Plant Officer',
                'slug'        => 'chilling-plant-officer',
            ],
            [
                'id'          => 3,
                'is_system'   => 1,
                'entity_id'   => 1,
                'role_name'   => 'Field Officer',
                'slug'        => 'field-officer',
            ],
            [
                'id'          => 4,
                'is_system'   => 1,
                'entity_id'   => 1,
                'role_name'   => 'Chilling Plant Manager',
                'slug'        => 'chilling-plant-manager',
            ],
            [
                'id'          => 5,
                'is_system'   => 1,
                'entity_id'   => 2,
                'role_name'   => 'Association Manager',
                'slug'        => 'association-manager',
            ],
            [
                'id'          => 6,
                'is_system'   => 1,
                'entity_id'   => 3,
                'role_name'   => 'Processing Plant Manager',
                'slug'        => 'processing-plant-manager',
            ],
            [
                'id'          => 7,
                'is_system'   => 1,
                'entity_id'   => 3,
                'role_name'   => 'Driver(processing-plant)',
                'slug'        => 'driver-processing-plant',
            ],
            [
                'id'          => 8,
                'is_system'   => 1,
                'entity_id'   => 3,
                'role_name'   => 'Vehicle Manager(processing-plant)',
                'slug'        => 'vehicle-manager-processing-plant',
            ],
            [
                'id'          => 9,
                'is_system'   => 1,
                'entity_id'   => 2,
                'role_name'   => 'Association Member',
                'slug'        => 'association-member',
            ],
            [
                'id'          => 10,
                'is_system'   => 1,
                'entity_id'   => 3,
                'role_name'   => 'QC Manager (processing-plant)',
                'slug'        => 'qc-manager-processing-plant',
            ],
            [
                'id'          => 11,
                'is_system'   => 1,
                'entity_id'   => 3,
                'role_name'   => 'Distributor',
                'slug'        => 'distributor',
            ],
            [
                'id'          => 12,
                'is_system'   => 1,
                'entity_id'   => 3,
                'role_name'   => 'Delivery Man',
                'slug'        => 'delivery-man',
            ],
            [
                'id'          => 13,
                'is_system'   => 1,
                'entity_id'   => 4,
                'role_name'   => 'Central Stock Manager',
                'slug'        => 'central-stock-manager',
            ]
        ]);

        // 
        DB::table('users')->insert([
            [
                "name_bn"               => "শামীম হক",
                "name_en"               => "Shamim Haque",
                "username"              => "01983667657",
                "mobile"                => "01983667657",
                "email"                 => "shamim.haque.dev@gmail.com",
                "entity_id"             => 0,
                "role_id"               => 1,
                "designation_id"        => 0,
                "password"              => Hash::make(12345678),
                "chilling_plant_id"     => 0,
                "association_id"        => 0,
                "processing_plant_id"  => 0,
            ],
        ]);

        //
        DB::table('role_wise_menus')->insert([
            [
                "role_id"       => 2,
                "menus"         => json_encode([14]),
                "sub_menus"     => '',
                "action_menus"  => json_encode([45,46,47,42,43,44]),
            ],
            [
                "role_id"       => 3,
                "menus"         => json_encode([1,4]),
                "sub_menus"     => '',
                "action_menus"  => json_encode([8,16,15,14,17,18,21]),
            ],
            [
                "role_id"       => 4,
                "menus"         => json_encode([13,16]),
                "sub_menus"     => '',
                "action_menus"  => json_encode([19]),
            ],
            [
                "role_id"       => 5,
                "menus"         => json_encode([17,18,26,25]),
                "sub_menus"     => '',
                "action_menus"  => json_encode([45,46,47,42,43,44]),
            ],
            [
                "role_id"       => 7,
                "menus"         => json_encode([]),
                "sub_menus"     => '',
                "action_menus"  => json_encode([]),
            ],
        ]);
        
        
        DB::table('milk_categories')->insert(
        [
            ["milk_category_name" => 'ভালো দুধ'],
            ["milk_category_name" => 'দধি দুধ'],
            ["milk_category_name" => 'টক দুধ'],
        ]);        
        
        //
        DB::table('product_price_labels')->insert(
        [
            ["label_name" => "Dealer Price", "slug"=>"dealer-price", "is_system"=>1],
            ["label_name" => "Shop Price", "slug"=>"shop-price", "is_system"=>1],
            ["label_name" => "Customer Price", "slug"=>"customer-price", "is_system"=>1],
        ]);
    }
}

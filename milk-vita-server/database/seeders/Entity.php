<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Entity extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('entities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

        DB::table('entities')->insert([
            [
                'id'          => 1,
                'parent_id'   => 0,
                'is_system'   => 1,
                'entity_name' => 'Chilling Plant',
                'slug'        => 'chilling-plant',
            ],
            [
                'id'          => 2,
                'parent_id'   => 1,
                'is_system'   => 1,
                'entity_name' => 'Association',
                'slug'        => 'association',
            ],
            [
                'id'          => 3,
                'parent_id'   => 0,
                'is_system'   => 1,
                'entity_name' => 'Processing Plant',
                'slug'        => 'processing-plant',
            ],
            [
                'id'          => 4,
                'parent_id'   => 0,
                'is_system'   => 1,
                'entity_name' => 'Central Stock',
                'slug'        => 'central-stock',
            ],
        ]);
    }
}

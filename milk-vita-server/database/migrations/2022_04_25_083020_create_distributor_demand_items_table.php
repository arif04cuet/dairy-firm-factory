<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorDemandItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_demand_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("demand_id");
            $table->unsignedBigInteger("unit_id");
            $table->unsignedBigInteger("cat_id");
            $table->unsignedBigInteger("product_id");
            $table->decimal("quantity", 10,2);
            $table->date("date");
            $table->decimal("challan_quantity", 10,2);
            $table->date("challan_date");
            $table->decimal("price", 10,2)->default(0);
            //
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributor_demand_items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulationEstimateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulation_estimate_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("estimate_id")->default(0);
            $table->unsignedBigInteger("product_id")->default(0);
            $table->unsignedBigInteger("unit_id")->default(0);
            $table->decimal("material_percentage", 10,2)->default(0);
            $table->string("quantity")->nullable();
            $table->string("no_of_product")->nullable();
            $table->set("type", ['ingredient', 'packing', 'production'])->default('ingredient');
            $table->tinyInteger('is_raw', 1)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulation_estimate_items');
    }
}

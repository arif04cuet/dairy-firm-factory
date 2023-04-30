<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulaPackingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formula_packing_items', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("material_product_id")->default(0)->comment('THIS IS THE PRODUCT ID OF THE PRODUCT TABLE');
            $table->decimal("material_percentase", 10,2)->default(0)->comment('IF NEED');
            $table->tinyInteger("is_raw")->default(0)->comment('IF NEED');
            $table->set("type", ['formula', 'packing']);
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
        Schema::dropIfExists('formula_packing_items');
    }
}

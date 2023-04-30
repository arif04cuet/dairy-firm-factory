<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUAPBulkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_a_p_bulk_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("bulk_id");
            $table->unsignedBigInteger("processing_plant_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("unit_id");
            $table->decimal("quantity", 10,2);
            $table->decimal("price", 10,2);
            $table->string("type")->default('purchase');
            $table->date("date");
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
        Schema::dropIfExists('u_a_p_bulk_items');
    }
}

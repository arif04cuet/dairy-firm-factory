<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("from_processing_plant_id");
            $table->unsignedBigInteger("to_processing_plant_id");
            $table->unsignedBigInteger("voucher_no");
            $table->unsignedBigInteger("sender_id");
            $table->unsignedBigInteger("receiver_id");
            $table->set("is_receive", [0, 1])->default(0);
            $table->string("remark");
            $table->date("date");
            $table->date("receive_date");
            $table->timestamps();
            $table->softDeletes();
            //
            $table->foreign('from_processing_plant_id')->references('id')->on('processing_plants')->onDelete('cascade');
            $table->foreign('to_processing_plant_id')->references('id')->on('processing_plants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock_transfers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishProductQCBulksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finish_product_q_c_bulks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("processing_plant_id");
            $table->unsignedBigInteger("user_id");
            $table->text("voucher_no");
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
        Schema::dropIfExists('finish_product_q_c_bulks');
    }
}

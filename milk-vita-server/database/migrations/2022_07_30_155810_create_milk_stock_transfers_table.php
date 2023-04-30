<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_stock_transfers', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger("from_processing_plant_id");
            $table->unsignedBigInteger("to_processing_plant_id");
            $table->unsignedBigInteger("sender_id");
            $table->unsignedBigInteger("receiver_id")->nullable();
            $table->text("voucher_no");
            $table->decimal("sdr_liter", 10,2);
            $table->decimal("sdr_density", 10,3);
            $table->decimal("sdr_kg", 10,2);
            $table->decimal("sdr_fat_persentase", 10,2);
            $table->decimal("sdr_fat_kg", 10,2);
            $table->decimal("sdr_snf_persentase", 10,2);
            $table->decimal("sdr_snf_kg", 10,2);
            $table->decimal("rvr_liter", 10,2);
            $table->decimal("rvr_density", 10,3);
            $table->decimal("rvr_kg", 10,2);
            $table->decimal("rvr_fat_persentase", 10,2);
            $table->decimal("rvr_fat_kg", 10,2);
            $table->decimal("rvr_snf_persentase", 10,2);
            $table->decimal("rvr_snf_kg", 10,2);
            $table->text("remark");
            $table->date("date");
            $table->date("receive_date");
            $table->tinyInteger("is_receive")->default(0);
            //
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
        Schema::dropIfExists('milk_stock_transfers');
    }
}

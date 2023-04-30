<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkChallanBulksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_challan_bulks', function (Blueprint $table)
        {
            $table->id();
            $table->string('voucher_no', 255)->nullable();
            $table->unsignedBigInteger('processing_plant_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->tinyInteger('is_receive')->default(0);
            $table->date('receive_date')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('milk_challan_bulks');
    }
}

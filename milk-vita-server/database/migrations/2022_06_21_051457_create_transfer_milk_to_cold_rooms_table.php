<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferMilkToColdRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_milk_to_cold_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("processing_plant_id");
            $table->date("date");
            $table->string("code_no")->nullable();
            $table->string("temperature")->nullable();
            $table->decimal("total", 10,2)->default(0);
            $table->decimal("total_cream_can", 10,2)->default(0);
            $table->decimal("total_cream", 10,2)->default(0);
            $table->decimal("bulk_milk", 10,2)->default(0);
            $table->decimal("grand_total", 10,2)->default(0);
            $table->decimal("total_crate", 10,2)->default(0);
            $table->decimal("total_packet", 10,2)->default(0);
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
        Schema::dropIfExists('transfer_milk_to_cold_rooms');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferMilkToColdRoomItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_milk_to_cold_room_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("transfer_id");
            $table->date("date")->nullable();
            $table->string("type")->nullable();
            $table->string("unit")->nullable();
            $table->string("full_column")->nullable();
            $table->string("partial_column")->nullable();
            $table->decimal("total_milk", 10,2)->nullable();
            $table->decimal("total_packet", 10,2)->nullable();
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
        Schema::dropIfExists('transfer_milk_to_cold_room_items');
    }
}

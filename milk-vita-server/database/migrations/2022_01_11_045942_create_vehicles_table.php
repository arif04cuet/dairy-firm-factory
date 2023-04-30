<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('model_no');
            $table->string('vat_no');
            $table->unsignedBigInteger('vehicle_category_id')->default(0);
            $table->unsignedBigInteger('processing_plant_id')->default(0);

            $table->foreign('vehicle_category_id')->references('id')->on('vehicle_categories')->onDelete('cascade');
            $table->foreign('processing_plant_id')->references('id')->on('processing_plants')->onDelete('cascade');
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
        Schema::dropIfExists('vehicles');
    }
}

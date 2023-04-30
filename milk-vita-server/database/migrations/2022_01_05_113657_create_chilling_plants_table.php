<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChillingPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chilling_plants', function (Blueprint $table) {
            $table->id();
            $table->string('chilling_plant_name', 255);
            $table->unsignedBigInteger('division_id')->default(0);
            $table->unsignedBigInteger('district_id')->default(0);
            $table->unsignedBigInteger('upazila_id')->default(0);
            $table->unsignedBigInteger('union_id')->default(0);
            $table->unsignedBigInteger('processing_plant_id')->default(0);
            $table->unsignedBigInteger('office_id')->default(0);
            $table->integer('longitude')->nullable();
            $table->integer('latitude')->nullable();
            $table->text('full_address')->nullable();
            $table->decimal('stock_capacity')->default(0);
            $table->text('location_details')->nullable();

            // FOREIGN KEY
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
        Schema::dropIfExists('chilling_plants');
    }
}

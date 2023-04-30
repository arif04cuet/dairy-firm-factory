<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessingPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processing_plants', function (Blueprint $table) {
            $table->id();
            $table->string('processing_plant_name', 255);
            $table->string('full_address', 255)->nullable();
            $table->unsignedBigInteger('division_id')->default(0);
            $table->unsignedBigInteger('district_id')->default(0);
            $table->unsignedBigInteger('upazila_id')->default(0);
            $table->unsignedBigInteger('union_id')->default(0);
            $table->unsignedBigInteger('office_id')->default(0);
            $table->float('longitude', 10, 8)->nullable();
            $table->float('latitude', 10, 8)->nullable();
            $table->text('location_details')->nullable();

            // $table->foreign('system_id')->references('id')->on('systems');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');

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
        Schema::dropIfExists('processing_plants');
    }
}

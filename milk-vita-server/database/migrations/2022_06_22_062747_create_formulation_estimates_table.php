<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulationEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulation_estimates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("processing_plant_id");

            $table->decimal("density", 10,4)->default(0);
            $table->decimal("fat_percentage", 10,4)->default(0);
            $table->decimal("was_in_stock", 10,2)->default(0);
            $table->decimal("total_raw_mix", 10,2)->default(0);
            $table->decimal("total_mix", 10,2)->default(0);
            $table->decimal("formulation_density", 10,2)->default(0);
            $table->decimal("formulation_bran", 10,2)->default(0);
            $table->decimal("used_stock", 10,2)->default(0);

            $table->date("date");
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
        Schema::dropIfExists('formulation_estimates');
    }
}

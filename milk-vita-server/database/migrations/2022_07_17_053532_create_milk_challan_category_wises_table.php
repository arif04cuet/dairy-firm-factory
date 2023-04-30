<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkChallanCategoryWisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_challan_category_wises', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger("challan_id");
            $table->unsignedBigInteger("category_id");
            $table->decimal("quantity", 10,2)->default(0);
            $table->decimal("density", 10,4)->default(0);
            $table->decimal("kg", 10,2)->default(0);
            $table->decimal("fat_percentage", 10,4)->default(0);
            $table->decimal("fat_kg", 10,2)->default(0);
            $table->decimal("snf_percentage", 10,4)->default(0);
            $table->decimal("snf_kg", 10,2)->default(0);
            $table->date("date");
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
        Schema::dropIfExists('milk_challan_category_wises');
    }
}

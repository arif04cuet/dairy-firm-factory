<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosingMilkStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closing_milk_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("processing_plant_id");
            $table->unsignedBigInteger("user_id");
            //
            $table->decimal("pro_liter", 10,2)->default(0);
            $table->decimal("density", 10,2)->default(0);
            $table->decimal("pro_kg", 10,2)->default(0);
            $table->decimal("fat_kg", 10,2)->default(0);
            $table->decimal("snf_kg", 10,2)->default(0);
            $table->decimal("fat_persentase", 10,2)->default(0);
            $table->decimal("snf_persentase", 10,2)->default(0);
            //
            $table->decimal("toned_pro_liter", 10,2)->default(0);
            $table->decimal("toned_density", 10,2)->default(0);
            $table->decimal("toned_pro_kg", 10,2)->default(0);
            $table->decimal("toned_fat_kg", 10,2)->default(0);
            $table->decimal("toned_snf_kg", 10,2)->default(0);
            $table->decimal("toned_fat_persentase", 10,2)->default(0);
            $table->decimal("toned_snf_persentase", 10,2)->default(0);
            $table->date("date")->default(0);
            
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
        Schema::dropIfExists('closing_milk_stocks');
    }
}

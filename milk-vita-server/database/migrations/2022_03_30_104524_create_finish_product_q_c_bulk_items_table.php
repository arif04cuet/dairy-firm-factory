<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishProductQCBulkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finish_product_q_c_bulk_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("qc_bulk_id");
            $table->unsignedBigInteger("processing_plant_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("unit_id");
            $table->decimal("quantity", 10,2);

            $table->decimal("pro_liter", 10,2)->default(0);
            $table->decimal("density", 10,2)->default(0);
            $table->decimal("pro_kg", 10,2)->default(0);
            $table->decimal("fat_kg", 10,2)->default(0);
            $table->decimal("snf_kg", 10,2)->default(0);
            $table->decimal("fat_persentase", 10,2)->default(0);
            $table->decimal("snf_persentase", 10,2)->default(0);

            $table->date("date");
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
        Schema::dropIfExists('finish_product_q_c_bulk_items');
    }
}

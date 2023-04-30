<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStockTransferItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("trx_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("unit_id");
            $table->decimal("quantity", 10,6)->default(0);
            $table->decimal("density", 10,6)->default(0);
            $table->decimal("quantity_kg", 10,6)->default(0);
            $table->decimal("quantity_litre", 10,6)->default(0);
            $table->decimal("fat_persentase", 10,6)->default(0);
            $table->decimal("snf_persentase", 10,6)->default(0);
            $table->decimal("fat_kg", 10,6)->default(0);
            $table->decimal("snf_kg", 10,6)->default(0);
            $table->timestamps();
            $table->softDeletes();
            //
            $table->foreign('trx_id')->references('id')->on('product_stock_transfers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('product_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock_transfer_items');
    }
}

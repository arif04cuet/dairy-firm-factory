<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("unit_id");
            $table->unsignedBigInteger("cat_id");
            $table->unsignedBigInteger("product_id");
            $table->decimal("quantity", 10,2);
            $table->tinyInteger("is_receive_as_demand")->default(0);
            $table->date("date");
            //
            $table->decimal("price", 10,2)->default(0);
            $table->date("delivery_date");
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
        Schema::dropIfExists('shop_order_items');
    }
}

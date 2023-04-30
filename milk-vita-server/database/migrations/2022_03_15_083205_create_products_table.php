<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('product_name')->default();
            $table->string('product_code');
            $table->tinyInteger('is_active')->default(1);
            $table->unsignedBigInteger('cat_id')->default(0);
            $table->decimal('formulation_density', 10,4)->default(0);
            $table->decimal('formulation_bran', 10,4)->default(0);
            $table->decimal('vat', 10,2)->default();
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
        Schema::dropIfExists('products');
    }
}

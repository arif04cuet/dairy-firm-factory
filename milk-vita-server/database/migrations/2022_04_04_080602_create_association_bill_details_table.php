<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_bill_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("bill_id");
            $table->unsignedBigInteger("association_id");
            $table->date("milk_collection_date");
            $table->string("shift");
            $table->decimal("litre", 10,2)->default(0);
            $table->decimal("specific_gravity", 10,2)->default(0);
            $table->decimal("fat", 10,2)->default(0);
            $table->decimal("snf", 10,2)->default(0);
            $table->decimal("unit_price", 10,2)->default(0);
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
        Schema::dropIfExists('association_bill_details');
    }
}

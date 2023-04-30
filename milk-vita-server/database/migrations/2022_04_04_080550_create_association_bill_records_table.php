<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationBillRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_bill_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("chilling_plant_id");
            $table->unsignedBigInteger("association_id");
            $table->unsignedBigInteger("user_id");
            $table->date("from_date");
            $table->date("to_date");
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
        Schema::dropIfExists('association_bill_records');
    }
}

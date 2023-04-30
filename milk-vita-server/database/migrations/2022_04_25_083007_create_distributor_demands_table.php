<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_demands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("distributor_id");
            $table->text("voucher_no");
            $table->date("date");
            //
            $table->tinyInteger("received_processing_plant_id")->default(0);
            $table->date("received_date_processing_plant")->nullable();
            //
            $table->tinyInteger("is_challan")->default(0);
            $table->unsignedBigInteger("challan_creator_id")->default(0);
            $table->date("challan_date")->nullable();
            //
            $table->tinyInteger("is_distributor_received")->default(0);
            $table->date("distributor_received_date")->nullable();
            //
            $table->string("status")->default('pending');
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
        Schema::dropIfExists('distributor_demands');
    }
}

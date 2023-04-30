<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAplicationForAssociationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_aplication_for_association_payments', function (Blueprint $table) {
            $table->id();
            $table->string("memo_no");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("chilling_plant_id");
            $table->string("to", 255)->nullable();
            $table->string("subject", 255)->nullable();
            $table->text("body")->nullable();
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
        Schema::dropIfExists('bank_aplication_for_association_payments');
    }
}

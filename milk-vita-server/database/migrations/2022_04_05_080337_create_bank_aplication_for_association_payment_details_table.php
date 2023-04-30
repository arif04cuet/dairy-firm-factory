<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAplicationForAssociationPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_aplication_for_association_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("application_id");
            $table->unsignedBigInteger("association_id");
            $table->string("account_no");
            $table->string("bank_name")->nullable();
            $table->decimal("amount", 10,2);
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
        Schema::dropIfExists('bank_aplication_for_association_payment_details');
    }
}

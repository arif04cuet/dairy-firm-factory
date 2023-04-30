<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationBankInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_bank_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('association_id');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('holder_name')->nullable();
            $table->string('account_no')->nullable();
            $table->text('signatories')->nullable();
            $table->text('type')->nullable();
            $table->timestamps();

            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
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
        Schema::dropIfExists('association_bank_infos');
    }
}

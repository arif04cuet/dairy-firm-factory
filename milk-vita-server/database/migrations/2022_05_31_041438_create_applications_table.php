<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string("name_en");
            $table->string("name_bn");
            $table->string("mobile");
            $table->string("email");
            $table->unsignedBigInteger("division_id");
            $table->unsignedBigInteger("district_id");
            $table->unsignedBigInteger("upazila_id");
            $table->unsignedBigInteger("union_id");
            $table->unsignedBigInteger("user_id")->default(0);
            $table->text("address_details");
            $table->string("remarks", 255);
            $table->set('status', ['pending', 'rejected', 'approved'])->default('pending');
            $table->set("type", ['shop', 'distributor', 'van_driver']);
            $table->timestamps();
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
        Schema::dropIfExists('applications');
    }
}

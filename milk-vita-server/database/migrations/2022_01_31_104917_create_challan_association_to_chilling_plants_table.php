<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanAssociationToChillingPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_association_to_chilling_plants', function (Blueprint $table) {
            $table->id();
            //
            $table->string('voucher_no');
            $table->unsignedBigInteger('milk_cat_id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('chilling_plant_id');
            $table->unsignedBigInteger('asso_manager_id');
            $table->unsignedBigInteger('chilling_plant_manager_id')->nullable();
            //
            $table->decimal('amount_of_milk', 10,2)->default(0)->comment('Unit Liter');
            $table->decimal('temperature', 10,2)->default(0);
            $table->decimal('lectometer_reading', 10,2)->default(0);
            $table->decimal('snf', 10,2)->default(0);
            $table->decimal('noni', 10,2)->default(0);
            //
            $table->decimal('milk_amount_kg_in_plant', 10,3)->default(0);
            $table->decimal('milk_amount_liter_in_plant', 10,3)->default(0);
            $table->decimal('specific_gravity_in_plant', 10,2)->default(0);
            $table->decimal('snf_in_plant', 10,2)->default(0);
            $table->decimal('noni_in_plant', 10,2)->default(0);
            $table->decimal('milk_difference', 10,2)->default(0);
            //
            $table->integer('full_can')->default(0);
            $table->integer('half_can')->default(0);
            $table->string('shift');
            $table->text('remark')->nullable();
            $table->string('driver_name')->nullable();
            $table->integer('entry_no')->default(0);
            $table->string('sour_milk_sample_no')->nullable();
            $table->integer('total_can_return')->default(0);
            //
            $table->date('date')->nullable();
            $table->dateTime('received_time')->nullable();
            //
            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('chilling_plant_id')->references('id')->on('chilling_plants')->onDelete('cascade');
            $table->foreign('asso_manager_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('challan_association_to_chilling_plants');
    }
}

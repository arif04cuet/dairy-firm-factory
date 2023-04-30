<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkChallanFromChillingPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_challan_from_chilling_plants', function (Blueprint $table) 
        {
            $table->id();
            //
            $table->unsignedBigInteger("bulk_id");
            $table->unsignedBigInteger("chilling_plant_id");
            $table->unsignedBigInteger("processing_plant_id");
            $table->unsignedBigInteger("chilling_plant_manager_id");
            $table->unsignedBigInteger("driver_id");
            $table->unsignedBigInteger("qc_manager_id")->default(0);
            // 
            $table->text("voucher_no");
            // 
            $table->decimal("clpt_liter", 10,2)->default(0);
            $table->decimal("clpt_density", 10,5)->default(0);
            $table->decimal("clpt_kg", 10,2)->default(0);
            $table->decimal("clpt_fat_percentage", 10,2)->default(0);
            $table->decimal("clpt_fat_kg", 10,2)->default(0);
            $table->decimal("clpt_snf_percentage", 10,2)->default(0);
            $table->decimal("clpt_snf_kg", 10,2)->default(0);
            // 
            $table->decimal("prpt_liter", 10,2)->default(0);
            $table->decimal("prpt_density", 10,3)->default(0);
            $table->decimal("prpt_kg", 10,2)->default(0);
            $table->decimal("prpt_fat_percentage", 10,2)->default(0);
            $table->decimal("prpt_fat_kg", 10,2)->default(0);
            $table->decimal("prpt_snf_percentage", 10,2)->default(0);
            $table->decimal("prpt_snf_kg", 10,2)->default(0);
            $table->decimal("sample_quantity", 10,2)->default(0);
            //  
            $table->decimal("QCPMFP", 10,3)->default(0)->comment("QC Powder Milk Fat Percentage in Processing Plant");
            $table->decimal("QCPMMP", 10,3)->default(0)->comment("QC Powder Milk Moisturizer Percentage in Processing Plant");
            $table->decimal("AFP", 10,5)->default(0)->comment("QC Accumulate Fat Percentage in Processing Plant");
            $table->decimal("SFP", 10,5)->default(0)->comment("QC Standard Fat Percentage in Processing Plant");
            $table->decimal("RFK", 10,3)->default(0)->comment("Receive Fat Kg in Processing Plant");
            $table->decimal("RSNFK", 10,3)->default(0)->comment("Receive SNF Kg in Processing Plant");
            // 
            $table->decimal("pre_stock", 10, 2)->default(0);
            $table->string("remark", 255)->nullable();
            $table->string("status")->default('pending');
            // 
            $table->tinyInteger("is_driver_receive")->default(0);
            $table->tinyInteger("is_submit")->default(0);
            $table->tinyInteger("is_done")->default(0);
            $table->tinyInteger('is_send_qc')->default(0);
            $table->tinyInteger('is_qc')->default(0);
            $table->date('sand_qc_date')->nullable();
            $table->date("qc_date")->nullable();
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
        Schema::dropIfExists('milk_challan_from_chilling_plants');
    }
}

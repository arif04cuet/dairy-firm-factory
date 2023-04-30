<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationControlFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_control_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('association_id')->unique();
            $table->unsignedBigInteger('chilling_plant_id')->nullable();
            $table->unsignedBigInteger('field_officer_id')->nullable();
            $table->tinyInteger('is_resolution')->default(0);
            
            $table->unsignedBigInteger('chilling_plant_manager_id')->default(0);
            $table->tinyInteger('is_approved_chilling_plant_manager')->default(0);
            $table->tinyInteger('is_reject_chilling_plant_manager')->default(0);
            $table->tinyInteger('is_forward_chilling_plant_manager')->default(0);
            $table->tinyInteger('is_forward_for_correction')->default(0);

            $table->unsignedBigInteger('milkvita_officer_id')->default(0);
            $table->tinyInteger('is_approved_milkvita_officer')->default(0);
            $table->tinyInteger('is_reject_milkvita_officer')->default(0);


            $table->tinyInteger('is_upazila_cooperative_officer')->default(0);
            $table->unsignedBigInteger('upazila_cooperative_officer_id')->default(0);
            $table->tinyInteger('is_approved_cooperative_officer')->default(0);
            $table->tinyInteger('is_reject_cooperative_officer')->default(0);


            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('field_officer_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('association_control_flows');
    }
}

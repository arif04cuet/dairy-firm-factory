<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationRoadTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_road_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('association_id')->nullable();
            $table->unsignedBigInteger('road_type_id')->nullable();
            $table->decimal('distance', 10, 2)->default(0);
            $table->string('unit')->default('কিঃ মিঃ');
            $table->timestamps();

            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('road_type_id')->references('id')->on('road_types')->onDelete('cascade');
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
        Schema::dropIfExists('association_road_types');
    }
}

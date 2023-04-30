<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("dairy_storage_area")->nullable();
            $table->integer("milk_area_division_id")->nullable();
            $table->integer("milk_area_district_id")->nullable();
            $table->integer("milk_area_upazila_id")->nullable();
            $table->integer("milk_area_union_id")->nullable();
            $table->string("milk_area_village")->nullable();
            $table->text("milk_area_location_details")->nullable();
            $table->string("association_name")->nullable();
            $table->string("association_code")->nullable();
            $table->string("name_of_dairy_area")->nullable();
            $table->string("working_area_of_association")->nullable();
            $table->integer("association_division_id")->nullable();
            $table->integer("association_district_id")->nullable();
            $table->integer("association_upazila_id")->nullable();
            $table->integer("association_union_id")->nullable();
            $table->string("association_village")->nullable();
            $table->text("association_location_details")->nullable();
            $table->integer("total_present_member")->nullable();
            $table->string("distance_of_working_area_to_adjoining_area")->nullable();
            $table->string("distance_of_factory_to_association_center")->nullable();
            $table->decimal("longitude", 10, 8)->nullable();
            $table->decimal("latitude", 10, 8)->nullable();
            $table->tinyInteger('temparary_approved')->default(0);
            $table->tinyInteger('permanent_approved')->default(0);
            $table->timestamps();
            // FOREIGN KEY
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('associations');
    }
}

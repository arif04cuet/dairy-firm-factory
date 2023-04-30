<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string("name_en")->nullable();
            $table->string('username')->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('email')->nullable()->nullable();

            $table->string("fathers_name_bn")->nullable();
            $table->string("fathers_name_en")->nullable();
            $table->string("mothers_name_bn")->nullable();
            $table->string("mothers_name_en")->nullable();
            $table->string("husband_or_wife_name_bn")->nullable();
            $table->string("husband_or_wife_name_en")->nullable();
            $table->date("date_of_birth")->nullable();
            $table->string("religion")->nullable();
            $table->string("sex")->nullable();
            $table->string("nid_no")->nullable();
            $table->string("address", 255)->nullable();

            $table->unsignedBigInteger('sso_user_id')->default(0);
            $table->unsignedBigInteger('entity_id')->default(0);
            $table->unsignedBigInteger('chilling_plant_id')->default(0);
            $table->unsignedBigInteger('association_id')->default(0);
            $table->unsignedBigInteger('asso_member_id')->default(0);
            $table->unsignedBigInteger('processing_plant_id')->default(0);
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable()->default(0);
            $table->unsignedBigInteger('division_id')->default(0);
            $table->unsignedBigInteger('district_id')->default(0);
            $table->unsignedBigInteger('upazila_id')->default(0);
            $table->unsignedBigInteger('union_id')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->text('photo_path')->nullable();
            $table->text('signature_path')->nullable();
            $table->string('type')->default('general');
            $table->tinyInteger('trash')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_members', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->unsignedBigInteger('association_id')->nullable();
            $table->string('member_name');
            $table->string('member_name_en')->nullable();
            $table->string('member_code')->nullable();
            $table->integer('age')->nullable();
            $table->string('nid', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('membership_date')->nullable();
            $table->string('bkash_account_number')->nullable();
            $table->string('bank_address', 255)->nullable();
            $table->string('religion')->nullable();
            $table->unsignedBigInteger('gender_id');
            $table->text('gender_details')->nullable();
            $table->string('occupation', 255)->nullable();
            $table->string('educational_qualification', 255)->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('father_name_en')->nullable();
            $table->string('father_name_bn')->nullable();
            $table->string('mother_name_en')->nullable();
            $table->string('mother_name_bn')->nullable();
            $table->string('spouse_name_en')->nullable();
            $table->string('spouse_name_bn')->nullable();
            $table->string('village', 255)->nullable();
            $table->string('post_office', 255)->nullable();
            $table->unsignedBigInteger('division_id')->default(0);
            $table->unsignedBigInteger('district_id')->default(0);
            $table->unsignedBigInteger('upazila_id')->default(0);
            $table->text('location_details')->nullable();
            $table->integer('amount_of_milk_produced')->default(0);
            $table->string('where_sales_are')->nullable();;
            $table->integer('total_gavi')->default(0);
            $table->integer('total_bokna')->default(0);
            $table->integer('total_bokon_bachor')->default(0);
            $table->integer('total_are_bachor')->default(0);
            $table->integer('total_shar')->default(0);
            $table->integer('total_bolod')->default(0);
            $table->integer('total_mohish')->default(0);
            $table->text('remark')->nullable();

            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            // $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            // $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            // $table->foreign('thana_id')->references('id')->on('thanas')->onDelete('cascade');

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
        Schema::dropIfExists('association_members');
    }
}

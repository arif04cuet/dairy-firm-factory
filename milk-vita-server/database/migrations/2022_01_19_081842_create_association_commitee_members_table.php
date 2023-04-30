<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationCommiteeMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_commitee_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('association_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->tinyInteger('trash')->default(0);
            $table->timestamps();
            //
            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('association_members')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
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
        Schema::dropIfExists('association_commitee_members');
    }
}

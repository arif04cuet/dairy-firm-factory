<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleWiseMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_wise_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->default(0);
            $table->longText('menus')->nullable();
            $table->longText('sub_menus')->nullable();
            $table->longText('action_menus')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('role_wise_menus');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->string('testable_type');
            $table->string('result');
            //
            $table->unsignedBigInteger('test_id')->nullable();
            $table->unsignedBigInteger('tested_by')->nullable();
            $table->unsignedBigInteger('testable_id');
            //
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('tested_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('test_results');
    }
}

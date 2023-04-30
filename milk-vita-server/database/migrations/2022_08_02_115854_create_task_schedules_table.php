<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_schedules', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger('user_id');
            $table->date("start_date");
            $table->date("end_date");
            $table->string("subject");
            $table->text("description");
            $table->tinyInteger("is_complete")->default(0);
            $table->date("complete_date")->nullable();
            $table->date("date");
            $table->set("type", ['schedule'])->default('schedule');
            //
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
        Schema::dropIfExists('task_schedules');
    }
}

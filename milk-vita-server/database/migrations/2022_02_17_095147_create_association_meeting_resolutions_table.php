<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationMeetingResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_meeting_resolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_officer_id');
            $table->unsignedBigInteger('association_id');
            $table->date('meeting_date');
            $table->string('meeting_title', 255);
            $table->text('meeting_resolution')->nullable();
            $table->tinyInteger('is_done')->default(0);
            $table->string('type')->default('general-meeting');
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
        Schema::dropIfExists('association_meeting_resolutions');
    }
}

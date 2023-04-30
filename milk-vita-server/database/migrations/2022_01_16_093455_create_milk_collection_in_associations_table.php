<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkCollectionInAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_collection_in_associations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('member_id');
            $table->decimal('amount_of_milk', 10, 3);
            $table->decimal('temperature', 10, 2)->default(0);
            $table->enum('shift', ['morning', 'evening']);
            $table->date('date')->nullable();

            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('association_members')->onDelete('cascade');

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
        Schema::dropIfExists('milk_collection_in_associations');
    }
}

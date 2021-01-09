<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_center_ride_item_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_center_id');
            $table->unsignedBigInteger('gcr_category_id');
            $table->unsignedBigInteger('gcr_category_item_id');
            $table->string('name');
            $table->string('image');
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ride_item_details');
    }
}

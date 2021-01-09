<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_center_ride_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_center_id');
            $table->unsignedBigInteger('gcr_category_id');
            $table->string('name');
            $table->integer('type');
            $table->string('cover');
            $table->string('banner');
            $table->text('content');
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
        Schema::dropIfExists('ride_items');
    }
}

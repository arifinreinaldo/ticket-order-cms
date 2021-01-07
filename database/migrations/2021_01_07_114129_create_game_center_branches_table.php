<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameCenterBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_center_branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_center_id');
            $table->unsignedBigInteger('game_center_location_id');
            $table->string('name');
            $table->string('title');
            $table->string('image');
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
        Schema::dropIfExists('game_center_branches');
    }
}

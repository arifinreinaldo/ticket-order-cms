<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('content');
            $table->timestamps();
        });
        DB::table('static_pages')->insert(
            array(
                'type' => 'Syarat & Ketentuan',
                'content' => '',
            )
        );
        DB::table('static_pages')->insert(
            array(
                'type' => 'Kebijakan Privacy',
                'content' => '',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_pages');
    }
}

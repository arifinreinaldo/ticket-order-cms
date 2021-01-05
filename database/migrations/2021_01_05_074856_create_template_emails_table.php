<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('head');
            $table->string('body');
            $table->string('footer');
            $table->timestamps();
        });
        DB::table('template_emails')->insert(
            array(
                'title' => 'Sukses Register',
                'head' => '',
                'body' => '',
                'footer' => '',
            )
        );
        DB::table('template_emails')->insert(
            array(
                'title' => 'Sukses Ganti Password',
                'head' => '',
                'body' => '',
                'footer' => '',
            )
        );
        DB::table('template_emails')->insert(
            array(
                'title' => 'Sukses Beli Barang',
                'head' => '',
                'body' => '',
                'footer' => '',
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
        Schema::dropIfExists('template_emails');
    }
}

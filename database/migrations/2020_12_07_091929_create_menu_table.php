<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('menu');
            $table->string('alias');
            $table->timestamps();
        });
        DB::table('menu')->insert(
            array(
                'menu' => 'User Admin Management',
                'alias' => 'muser'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'User Role Management',
                'alias' => 'mrole'
            )
        );

        DB::table('menu')->insert(
            array(
                'menu' => 'Customer Management',
                'alias' => 'mcustomer'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Theme Park Management',
                'alias' => 'mtheme'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Branch Management',
                'alias' => 'mbranch'
            )
        );

        DB::table('menu')->insert(
            array(
                'menu' => 'Game Center Management',
                'alias' => 'mgamecenter'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Product Management',
                'alias' => 'mproduct'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Promotion Management',
                'alias' => 'mpromotion'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Event Calendar Management',
                'alias' => 'mcalendar'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Banner Management',
                'alias' => 'mbanner'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Article Management',
                'alias' => 'marticle'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Static Page Management',
                'alias' => 'mstatic'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Point Management',
                'alias' => 'mpoint'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Games Management',
                'alias' => 'mgame'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Email Template Management',
                'alias' => 'mtemplate'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Report Management',
                'alias' => 'mreport'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Configuration',
                'alias' => 'mconfiguration'
            )
        );
        DB::table('menu')->insert(
            array(
                'menu' => 'Activity Log',
                'alias' => 'mactivity'
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
        Schema::dropIfExists('menu');
    }
}

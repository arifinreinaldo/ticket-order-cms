<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_role_id');
            $table->unsignedBigInteger('menu_id');
            $table->string('read_access');
            $table->string('create_access');
            $table->string('update_access');
            $table->string('delete_access');
            $table->timestamps();
        });
        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '1',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '2',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '3',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '4',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '5',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '6',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '7',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '8',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '9',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '10',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '11',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '12',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '13',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '14',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '15',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
            )
        );

        DB::table('menu_role')->insert(
            array(
                'user_role_id' => '1',
                'menu_id' => '16',
                'read_access' => 'X',
                'create_access' => 'X',
                'update_access' => 'X',
                'delete_access' => 'X'
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
        Schema::dropIfExists('menu_role');
    }
}

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
        $menus = DB::table('menu')->get();
        foreach ($menus as $menu) {
            DB::table('menu_role')->insert(
                array(
                    'user_role_id' => '1',
                    'menu_id' => $menu->id,
                    'read_access' => 'X',
                    'create_access' => 'X',
                    'update_access' => 'X',
                    'delete_access' => 'X'
                )
            );
        }
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

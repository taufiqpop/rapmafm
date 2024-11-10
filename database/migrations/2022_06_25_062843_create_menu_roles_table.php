<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->unsigned()->nullable(false)->default(null);
            $table->integer('role_id')->unsigned()->nullable(false)->default(null);
            $table->integer('action_id')->unsigned()->nullable(false)->default(null);
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('menu_roles');
    }
}

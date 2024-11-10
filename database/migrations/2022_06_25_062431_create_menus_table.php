<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->unsigned()->nullable(true)->default(null);
            $table->string('name', 255)->nullable(false);
            $table->string('slug_name', 255)->nullable(false);
            $table->integer('menu_order')->unsigned()->nullable()->default(null);
            $table->string('link', 100)->nullable()->default(null);
            $table->string('icon', 100)->nullable()->default(null);
            $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('menus');
    }
}

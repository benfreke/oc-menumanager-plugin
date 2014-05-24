<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMenusTable extends Migration
{

    public function up()
    {
        Schema::create('benfreke_menumanager_menus', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->integer('nest_left');
            $table->integer('nest_right');
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('benfreke_menumanager_menus');
    }

}

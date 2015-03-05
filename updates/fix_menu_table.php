<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class FixMenuTable extends Migration
{

    public function up()
    {
        Schema::table('benfreke_menumanager_menus', function($table)
        {
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
        });
    }

    public function down()
    {
        Schema::table('benfreke_menumanager_menus', function($table)
        {
            $table->integer('nest_left');
            $table->integer('nest_right');
        });
    }

}

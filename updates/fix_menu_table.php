<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class FixMenuTable extends Migration
{

    public function up()
    {
        Schema::table('benfreke_menumanager_menus', function ($table) {
            $table->integer('nest_left')->nullable()->change();
            $table->integer('nest_right')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('benfreke_menumanager_menus', function ($table) {
            $table->integer('nest_left')->nullable(false)->change();
            $table->integer('nest_right')->nullable(false)->change();
        });
    }

}

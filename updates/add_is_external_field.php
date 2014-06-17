<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddIsExternalField extends Migration
{

    public function up()
    {
        Schema::table('benfreke_menumanager_menus', function($table)
        {
            $table->boolean('is_external')->default(false);
        });
    }

    public function down()
    {
        Schema::table('benfreke_menumanager_menus', function($table)
        {
            $table->dropColumn(array('is_external'));
        });
    }

}

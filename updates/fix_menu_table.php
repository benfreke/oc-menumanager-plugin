<?php namespace BenFreke\MenuManager\Updates;

use DB;
use October\Rain\Database\Updates\Migration;

class FixMenuTable extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE `benfreke_menumanager_menus` MODIFY `nest_left` INTEGER UNSIGNED NULL;');
        DB::statement('ALTER TABLE `benfreke_menumanager_menus` MODIFY `nest_right` INTEGER UNSIGNED NULL;');
    }

    public function down()
    {
        DB::statement('ALTER TABLE `benfreke_menumanager_menus` MODIFY `nest_left` INTEGER UNSIGNED;');
        DB::statement('ALTER TABLE `benfreke_menumanager_menus` MODIFY `nest_right` INTEGER UNSIGNED;');
    }

}

<?php namespace BenFreke\MenuManager\Updates;

use DB;

use Schema;
use October\Rain\Database\Updates\Migration;

class FixMenuTable extends Migration
{

    public function up()
    {

        //SQLite does not support alter column
        //That complicates the problem
        //Approach:
        // -create new table with correct field definitions
        // -copy existing menu definitions from old table to new
        // -fix values of parent_id, nest_right, nest_left to reflect eventual id field changes
        // -drop old table
        // -rename new table

        $pdo = DB::connection()->getPdo();
        Schema::create('benfreke_menumanager_menus_new', function($table) use($pdo)
        {
            if('mysql' == $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME)){
                $table->engine = 'InnoDB';
            }
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->integer('nest_left')->unsigned()->nullable();
            $table->integer('nest_right')->unsigned()->nullable();
            $table->integer('nest_depth')->nullable();
            $table->integer('enabled')->default(1);
            $table->string('parameters')->nullable();
            $table->string('query_string')->nullable();
            $table->boolean('is_external')->default(false);
            $table->string('link_target')->default('_self');
            $table->timestamps();
        });

        $menus = DB::table('benfreke_menumanager_menus')->get();
        $idMap = [];
        foreach($menus as $menu){
            $newMenu = DB::table('benfreke_menumanager_menus_new')->insert([
                'title'       => $menu->title,
                'parent_id'   => $menu->parent_id,
                'description' => $menu->description,
                'url'         => $menu->url,
                'nest_left'   => $menu->nest_left,
                'nest_right'  => $menu->nest_right,
                'nest_depth'  => $menu->nest_depth,
                'created_at'  => $menu->created_at,
                'updated_at'  => $menu->updated_at,
                'enabled'     => $menu->enabled,
                'parameters'  => $menu->parameters,
                'query_string'=> $menu->query_string,
                'is_external' => $menu->is_external,
                'link_target' => $menu->link_target,
             ]);
            $idMap[$menu->id] = $newMenu->id;
        }
        foreach($idMap as $id=>$newId){
            DB::table('benfreke_menumanager_menus_new')
                ->where('parent_id',$id)
                ->update(['parent_id',$newId]);
            DB::table('benfreke_menumanager_menus_new')
                ->where('nest_left',$id)
                ->update(['nest_left',$newId]);
            DB::table('benfreke_menumanager_menus_new')
                ->where('nest_right',$id)
                ->update(['nest_right',$newId]);
        }
        Schema::drop('benfreke_menumanager_menus');
        switch($pdo->getAttribute(\PDO::ATTR_DRIVER_NAME)) {
        case 'mysql':
            DB::statement("ALTER TABLE benfreke_menumanager_menus_new RENAME benfreke_menumanager_menus");
            break;
        case 'sqlite':
        case 'pgsql':
            DB::statement("ALTER TABLE benfreke_menumanager_menus_new RENAME TO benfreke_menumanager_menus");
            break;
        case 'sqlsrv':
            DB::statement("sp_rename 'benfreke_menumanager_menus_new', 'benfreke_menumanager_menus'");
            break;
        }
    }

    public function down()
    {
      /*
        No way back...
        If for some reason there will be entries with null values on
        nest_left/nest_right fields just re-adding NOT NULL constraints
        will break the script.
      */

    }

}

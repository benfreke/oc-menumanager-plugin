<?php namespace BenFreke\MenuManager\Updates;

use DB;
use October\Rain\Database\Updates\Migration;

class FixMenuTable extends Migration
{

    public function up()
    {
        $pdo = DB::connection()->getPdo();
        Schema::create('benfreke_menumanager_menus_new', function($table) use($pdo)
        {
            if('mysql' == $pdo->getAttribute(PDO::ATTR_DRIVER_NAME)){
                $table->engine = 'InnoDB';
            }
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
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
                'updated_at'  => $menu->updated_at
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
        switch($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
        'mysql':
            DB::statement("ALTER TABLE benfreke_menumanager_menus_new RENAME benfreke_menumanager_menus");
            break;
        'sqlite':
        'pgsql':
            DB::statement("ALTER TABLE benfreke_menumanager_menus_new RENAME TO benfreke_menumanager_menus");
            break;
        'sqlsrv':
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

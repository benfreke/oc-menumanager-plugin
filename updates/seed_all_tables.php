<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Seeder;
use BenFreke\MenuManager\Models\Menu;

class SeedAllTables extends Seeder
{

    public function run()
    {
        $menu = Menu::create(
            [
                'title'       => 'Main Menu',
                'description' => 'The main menu items',
                'url' => ''
            ]
        );


    }
}
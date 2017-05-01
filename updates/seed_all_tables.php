<?php namespace BenFreke\MenuManager\Updates;

use Schema;
use October\Rain\Database\Updates\Seeder;
use BenFreke\MenuManager\Models\Menu;

class SeedAllTables extends Seeder
{

    public function run()
    {
        // This is a root node
        $mainMenu = Menu::create(
            [
                'title' => 'Main Menu',
                'description' => 'The main menu items',
                'url' => '',
            ]
        );

        // The top, or primary level of navigation
        $homePage = $mainMenu->children()->create(
            [
                'title' => 'Home Page',
                'description' => 'The primary navigation level',
                'url' => 'home',
            ]
        );

        // Secondary navigation
        $ajaxDemo = $homePage->children()->create(
            [
                'title' => 'Ajax Framework',
                'description' => 'Secondary item 1',
                'url' => 'ajax',
            ]
        );
        $homePage->children()->create(
            [
                'title' => 'Plugin Components',
                'description' => 'Secondary item 2',
                'url' => 'plugins',
            ]
        );

        $ajaxDemo->children()->create(
            [
                'title' => 'Menu titles do not',
                'description' => 'Tertiary item 1',
                'url' => '',
            ]
        );

        $ajaxDemo->children()->create(
            [
                'title' => 'Have to match page titles!',
                'description' => 'Tertiary item 2',
                'url' => '',
            ]
        );
        $ajaxDemo->children()->create(
            [
                'title' => 'Google Search',
                'description' => 'External link example',
                'is_external' => true,
                'url' => 'http://www.google.com',
            ]
        );
    }
}

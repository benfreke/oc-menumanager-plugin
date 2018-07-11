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
        $mainMenu->children()->create(
            [
                'title' => 'Basic Concepts',
                'description' => 'The primary navigation level',
                'url' => 'home',
            ]
        );

        // Secondary navigation
        $mainMenu->children()->create(
            [
                'title' => 'Ajax Framework',
                'description' => 'Secondary item 1',
                'url' => 'ajax',
            ]
        );
        $mainMenu->children()->create(
            [
                'title' => 'Plugin Components',
                'description' => 'Secondary item 2',
                'url' => 'plugins',
            ]
        );

        $menuExamples = $mainMenu->children()->create(
            [
                'title' => 'Menu Examples',
                'description' => 'Holder for menu examples',
                'url' => '',
            ]
        );

        $menuExamples->children()->create(
            [
                'title' => 'Menu titles do not',
                'description' => 'Tertiary item 1',
                'url' => '',
            ]
        );

        $menuExamples->children()->create(
            [
                'title' => 'Have to match page titles!',
                'description' => 'Tertiary item 2',
                'url' => '',
            ]
        );
        $menuExamples->children()->create(
            [
                'title' => 'Google Search',
                'description' => 'External link example',
                'is_external' => true,
                'url' => 'http://www.google.com',
            ]
        );
    }
}

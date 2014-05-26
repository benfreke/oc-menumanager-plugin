<?php namespace BenFreke\MenuManager;

use Backend;
use Controller;
use System\Classes\PluginBase;

/**
 * MenuManager Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'MenuManager',
            'description' => 'Plugin to enable management of menus within October CMS',
            'author'      => 'Ben Freke',
            'icon'        => 'icon-list-alt'
        ];
    }

    /**
     * Create the navigation items for this plugin
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'menumanager' => [
                'label' => 'Menus',
                'url'   => Backend::url('benfreke/menumanager/menus'),
                'icon'  => 'icon-list-alt',
                'order' => 500,
                'sideMenu' => [
                    'edit' => [
                        'label'       => 'Edit Menus',
                        'icon'        => 'icon-list-alt',
                        'url'         => Backend::url('benfreke/menumanager/menus')
                    ],
                    'reorder' => [
                        'label' => 'Reorder Menus',
                        'icon' => 'icon-exchange',
                        'url' => Backend::url('benfreke/menumanager/menus/reorder')
                    ]
                ]
            ]
        ];
    }

    /**
     * Register the front end component
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            '\BenFreke\MenuManager\Components\Menu' => 'menu',
        ];
    }

}

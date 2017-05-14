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
            'name' => 'benfreke.menumanager::lang.plugin.name',
            'description' => 'benfreke.menumanager::lang.plugin.description',
            'author' => 'Ben Freke',
            'icon' => 'icon-list-alt',
            'homepage' => 'https://github.com/benfreke/oc-menumanager-plugin',
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
                'label' => 'benfreke.menumanager::lang.menu.name',
                'url' => Backend::url('benfreke/menumanager/menus'),
                'icon' => 'icon-list-alt',
                'permissions' => ['benfreke.menumanager.*'],
                'order' => 500,
                'sideMenu' => [
                    'edit' => [
                        'label' => 'benfreke.menumanager::lang.menu.editmenu',
                        'icon' => 'icon-list-alt',
                        'url' => Backend::url('benfreke/menumanager/menus'),
                        'permissions' => ['benfreke.menumanager.access_menumanager'],
                    ],
                    'reorder' => [
                        'label' => 'benfreke.menumanager::lang.menu.reordermenu',
                        'icon' => 'icon-exchange',
                        'url' => Backend::url('benfreke/menumanager/menus/reorder'),
                        'permissions' => ['benfreke.menumanager.access_menumanager'],
                    ],
                ],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'benfreke.menumanager.access_menumanager' => [
                'label' => 'benfreke.menumanager::lang.access.label',
                'tab' => 'benfreke.menumanager::lang.plugin.name',
            ],
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

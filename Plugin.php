<?php namespace BenFreke\MenuManager;

use System\Classes\PluginBase;
use Backend\Facades\Backend;
use Schema;

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

    public function registerNavigation()
    {
        return [
            'Menus' => [
                'label' => 'Menus',
                'url'   => Backend::url('benfreke/menumanager/menus'),
                'icon'  => 'icon-list-alt',
                'order' => 500,
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            '\BenFreke\MenuManager\Components\Menu' => 'menu',
        ];
    }

}

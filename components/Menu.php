<?php namespace BenFreke\MenuManager\Components;

use Cms\Classes\ComponentBase;
use BenFreke\MenuManager\Models\Menu as menuModel;
use Request;
use App;
use DB;

class Menu extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Menu',
            'description' => 'Displays a menu on the page'
        ];
    }

    public function defineProperties()
    {
        return [
            'start'            => [
                'description' => 'The parent node to get the children of',
                'title'       => 'Parent Node',
                'default'     => 1,
                'type'        => 'dropdown'
            ],
            'primaryClasses'   => [
                'description' => 'Classes to add to the primary ul tag',
                'title'       => 'Primary Classes',
                'default'     => 'nav-pill',
                'type'        => 'string'
            ],
            'secondaryClasses' => [
                'description' => 'Classes to add to the secondary ul tags',
                'title'       => 'Secondary Classes',
                'default'     => 'dropdown-menu',
                'type'        => 'string'
            ],
            'tertiaryClasses'  => [
                'description' => 'Classes to add to the tertiary ul tags',
                'title'       => 'Tertiary Classes',
                'default'     => '',
                'type'        => 'string'
            ]
        ];

    }

    /**
     * Returns the list of menu items I can select
     * @return mixed
     */
    public function getStartOptions()
    {
        $menuModel = new menuModel();
        return $menuModel->getSelectList();
    }

    public function onRun()
    {
        /**
         * Because I'm using the id, I needed to trick OctoberCMS into thinking the id is a string
         * So this hack below fixes that and gives me back my id
         */
        $startNode = $this->property('start');
        $topMenuId = substr($startNode, 3);

        // Set the parentNode for the component output
        $this->page['parentNode'] = menuModel::find($topMenuId);

        // Add the classes to the view
        $this->page['primaryClasses']   = $this->property('primaryClasses');
        $this->page['secondaryClasses'] = $this->property('secondaryClasses');
        $this->page['tertiaryClasses']  = $this->property('tertiaryClasses');
    }

}
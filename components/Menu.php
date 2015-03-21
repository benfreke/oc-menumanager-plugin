<?php namespace BenFreke\MenuManager\Components;

use App;
use BenFreke\MenuManager\Models\Menu as menuModel;
use Cms\Classes\ComponentBase;
use DB;
use Lang;
use Request;

class Menu extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'benfreke.menumanager::lang.menu.name',
            'description' => 'benfreke.menumanager::lang.menu.description'
        ];
    }

    /**
     * @return array
     * @todo Change start to parentNode to match my naming
     */
    public function defineProperties()
    {
        return [
            'start'            => [
                'description' => 'benfreke.menumanager::lang.component.start.description',
                'title'       => 'benfreke.menumanager::lang.component.start.title',
                'default'     => 1,
                'type'        => 'dropdown'
            ],
            'activeNode'       => [
                'description' => 'benfreke.menumanager::lang.component.activenode.description',
                'title'       => 'benfreke.menumanager::lang.component.activenode.title',
                'default'     => 0,
                'type'        => 'dropdown'
            ],
            'listItemClasses'  => [
                'description' => 'benfreke.menumanager::lang.component.listitemclasses.description',
                'title'       => 'benfreke.menumanager::lang.component.listitemclasses.title',
                'default'     => 'item',
                'type'        => 'string'
            ],
            'primaryClasses'   => [
                'description' => 'benfreke.menumanager::lang.component.primaryclasses.description',
                'title'       => 'benfreke.menumanager::lang.component.primaryclasses.title',
                'default'     => 'nav nav-pills',
                'type'        => 'string'
            ],
            'secondaryClasses' => [
                'description' => 'benfreke.menumanager::lang.component.secondaryclasses.description',
                'title'       => 'benfreke.menumanager::lang.component.secondaryclasses.title',
                'default'     => 'dropdown-menu',
                'type'        => 'string'
            ],
            'tertiaryClasses'  => [
                'description' => 'benfreke.menumanager::lang.component.tertiaryclasses.description',
                'title'       => 'benfreke.menumanager::lang.component.tertiaryclasses.title',
                'default'     => '',
                'type'        => 'string'
            ],
            'numberOfLevels'   => [
                'description' => 'benfreke.menumanager::lang.component.numberoflevels.description',
                'title'       => 'benfreke.menumanager::lang.component.numberoflevels.title',
                'default'     => '2', // This is the array key, not the value itself
                'type'        => 'dropdown',
                'options'     => [
                    1 => '1',
                    2 => '2',
                    3 => '3'
                ]
            ]
        ];
    }

    /**
     * Returns the list of menu items, plus an empty default option
     *
     * @return array
     */
    public function getActiveNodeOptions()
    {
        $options = $this->getStartOptions();
        array_unshift($options, 'default');

        return $options;
    }

    /**
     * Returns the list of menu items I can select
     *
     * @return array
     */
    public function getStartOptions()
    {
        $menuModel = new menuModel();

        return $menuModel->getSelectList();
    }

    /**
     * Build all my parameters for the view
     *
     * @todo Pull as much as possible into the model, including the column names
     */
    public function onRender()
    {
        // Set the parentNode for the component output
        $topNode = menuModel::find($this->getIdFromProperty($this->property('start')));
        $this->page['parentNode'] = $topNode;

        // What page is active?
        $this->page['activeLeft'] = 0;
        $this->page['activeRight'] = 0;
        $activeNode = $this->getIdFromProperty($this->property('activeNode'));

        if ($activeNode) {

            // It's been set by the user, so use what they've set it as
            $activeNode = menuModel::find($activeNode);
        } elseif ($topNode) {

            // Go and find the page we're on
            $baseFileName = $this->page->page->getBaseFileName();

            // Get extra URL parameters
            $params = $this->page->controller->getRouter()->getParameters();

            // And make sure the active page is a child of the parentNode
            $activeNode = menuModel::where('url', $baseFileName)
                ->where('nest_left', '>', $topNode->nest_left)
                ->where('nest_right', '<', $topNode->nest_right);

            $activeNode = $activeNode->first();
        }

        // If I've got a result that is a node
        if ($activeNode && menuModel::getClassName() === get_class($activeNode)) {
            $this->page['activeLeft'] = (int)$activeNode->nest_left;
            $this->page['activeRight'] = (int)$activeNode->nest_right;
        }

        // How deep do we want to go?
        $this->page['numberOfLevels'] = (int)$this->property('numberOfLevels');

        // Add the classes to the view
        $this->page['primaryClasses'] = $this->property('primaryClasses');
        $this->page['secondaryClasses'] = $this->property('secondaryClasses');
        $this->page['tertiaryClasses'] = $this->property('tertiaryClasses');
        $this->page['listItemClasses'] = $this->property('listItemClasses');
    }

    /**
     * Gets the id from the passed property
     *  Due to the component inspector re-ordering the array on keys, and me using the key as the menu model id,
     *  I've been forced to add a string to the key. This method removes it and returns the raw id.
     *
     * @param $value
     *
     * @return bool|string
     */
    protected function getIdFromProperty($value)
    {
        if (!strlen($value) > 3) {
            return false;
        }

        return substr($value, 3);
    }

}

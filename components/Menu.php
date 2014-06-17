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

    /**
     * @return array
     * @todo Change start to parentNode to match my naming
     */
    public function defineProperties()
    {
        return [
            'start'            => [
                'description' => 'The parent node to get the children of',
                'title'       => 'Parent Node',
                'default'     => 1,
                'type'        => 'dropdown'
            ],
            'activeNode'       => [
                'description' => 'The active page. Set to "default" for the current page to be set as active',
                'title'       => 'Active Node',
                'default'     => 0,
                'type'        => 'dropdown'
            ],
            'primaryClasses'   => [
                'description' => 'Classes to add to the primary ul tag',
                'title'       => 'Primary Classes',
                'default'     => 'nav nav-pills',
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
            ],
            'numberOfLevels'   => [
                'description' => 'How many levels of menu to output',
                'title'       => 'Depth',
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
     * Returns the list of menu items I can select
     * @return array
     */
    public function getStartOptions()
    {
        $menuModel = new menuModel();
        return $menuModel->getSelectList();
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
     * Build all my parameters for the view
     * @todo Pull as much as possible into the model, including the column names
     */
    public function onRun()
    {
        // Set the parentNode for the component output
        $topNode                  = menuModel::find($this->getIdFromProperty($this->property('start')));
        $this->page['parentNode'] = $topNode;

        // What page is active?
        $this->page['activeLeft']  = 0;
        $this->page['activeRight'] = 0;
        $activeNode                = $this->getIdFromProperty($this->property('activeNode'));

        if ($activeNode) {

            // It's been set by the user, so use what they've set it as
            $activeNode = menuModel::find($activeNode);

        } elseif ($topNode) {

            // Go and find the page we're on
            $baseFileName = $this->page->page->getBaseFileName();

            // And make sure the active page is a child of the parentNode
            $activeNode = menuModel::where('url', $baseFileName)
                ->where('nest_left', '>', $topNode->nest_left)
                ->where('nest_right', '<', $topNode->nest_right)
                ->first();
        }

        // If I've got a result that is a node
        if ($activeNode && menuModel::getClassName() === get_class($activeNode)) {
            $this->page['activeLeft']  = (int)$activeNode->nest_left;
            $this->page['activeRight'] = (int)$activeNode->nest_right;
        }

        // How deep do we want to go?
        $this->page['numberOfLevels'] = (int)$this->property('numberOfLevels');

        // Add the classes to the view
        $this->page['primaryClasses']   = $this->property('primaryClasses');
        $this->page['secondaryClasses'] = $this->property('secondaryClasses');
        $this->page['tertiaryClasses']  = $this->property('tertiaryClasses');
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

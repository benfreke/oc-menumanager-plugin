<?php namespace BenFreke\MenuManager\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BenFreke\MenuManager\Models\Menu;

/**
 * Menus Back-end Controller
 */
class Menus extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BenFreke.MenuManager', 'menumanager', 'menus');
    }

    public function reorder()
    {
        $this->pageTitle = 'Reorder Menu';

        $toolbarConfig = $this->makeConfig();
        $toolbarConfig->buttons = '@/plugins/benfreke/menumanager/controllers/menus/_reorder_toolbar.htm';

        $this->vars['toolbar'] = $this->makeWidget('Backend\Widgets\Toolbar', $toolbarConfig);
        $this->vars['records'] = Menu::make()->getEagerRoot();
    }

    public function reorder_onMove()
    {
        $sourceNode = Menu::find(post('sourceNode'));
        $targetNode = post('targetNode') ? Menu::find(post('targetNode')) : null;

        if ($sourceNode == $targetNode)
            return;

        switch (post('position')) {
            case 'before': $sourceNode->moveBefore($targetNode); break;
            case 'after': $sourceNode->moveAfter($targetNode); break;
            case 'child': $sourceNode->makeChildOf($targetNode); break;
            default: $sourceNode->makeRoot(); break;
        }
    }
}
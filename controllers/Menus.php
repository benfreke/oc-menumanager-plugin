<?php namespace BenFreke\MenuManager\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BenFreke\MenuManager\Models\Menu;
use Illuminate\Support\Facades\Input;
use Lang;

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

    public $requiredPermissions = ['benfreke.menumanager.access_menumanager'];

    /**
     * Ensure that by default our edit menu sidebar is active
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BenFreke.MenuManager', 'menumanager', 'edit');

        // Add my assets
        $this->addJs('/plugins/benfreke/menumanager/assets/js/benfreke.menumanager.js');
    }

    /**
     * As external_url and internal_url doesn't exist in database, we need fill with url value.
     *
     * @param $host
     *
     * @return void
     */
    public function formExtendFields($host)
    {
        $allFields = $host->getFields();
        switch ($allFields['is_external']->value) {
            case 0:
                $allFields['internal_url']->value = $allFields['url']->value;
                break;
            case 1:
                $allFields['external_url']->value = $allFields['url']->value;
                break;
            default:
                break;
        }
    }

    /**
     * Displays the menu items in a tree list view so they can be reordered
     */
    public function reorder()
    {
        // Ensure the correct sidemenu is active
        BackendMenu::setContext('BenFreke.MenuManager', 'menumanager', 'reorder');

        $this->pageTitle = Lang::get('benfreke.menumanager::lang.menu.reordermenu');

        $toolbarConfig = $this->makeConfig();
        $toolbarConfig->buttons = '$/benfreke/menumanager/controllers/menus/_reorder_toolbar.htm';

        $this->vars['toolbar'] = $this->makeWidget('Backend\Widgets\Toolbar', $toolbarConfig);
        $this->vars['records'] = Menu::make()->getEagerRoot();
    }

    /**
     * Update the menu item position
     */
    public function reorder_onMove()
    {
        $sourceNode = Menu::find(post('sourceNode'));
        $targetNode = post('targetNode') ? Menu::find(post('targetNode')) : null;

        if ($sourceNode == $targetNode) {
            return;
        }

        switch (post('position')) {
            case 'before':
                $sourceNode->moveBefore($targetNode);
                break;
            case 'after':
                $sourceNode->moveAfter($targetNode);
                break;
            case 'child':
                $sourceNode->makeChildOf($targetNode);
                break;
            default:
                $sourceNode->makeRoot();
                break;
        }
    }
}

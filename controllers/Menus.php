<?php namespace BenFreke\MenuManager\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BenFreke\MenuManager\Models\Menu;
use Illuminate\Support\Facades\Input;

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

    /**
     * Ensure that by default our edit menu sidebar is active
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BenFreke.MenuManager', 'menumanager', 'edit');
    }

    /**
     * Ensures the correct URL value is saved to the model
     */
    protected function modifyPost()
    {
        $new_post_data = post();

        if (post('Menu')['is_external'] == "1") {
            $new_post_data['Menu']['url'] = $new_post_data['Menu']['external_url'];
        } else {
            $new_post_data['Menu']['url'] = $new_post_data['Menu']['internal_url'];
        }
        unset($new_post_data['Menu']['internal_url']);
        unset($new_post_data['Menu']['external_url']);
        Input::replace($new_post_data);

    }

    /**
     * Ajax handler for updating the form.
     *
     * @param int $recordId The model primary key to update.
     *
     * @return mixed
     */
    public function update_onSave($recordId = null)
    {
        $this->modifyPost();
        return $this->getClassExtension('Backend.Behaviors.FormController')->update_onSave($recordId);
    }

    /**
     * Overrided ajax handler for saving from the creation form.
     * @return mixed
     */
    public function create_onSave()
    {
        $this->modifyPost();
        return $this->getClassExtension('Backend.Behaviors.FormController')->create_onSave();
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
        if ($host->allFields['is_external']->value == 1) {
            $host->allFields['external_url']->value = $host->allFields['url']->value;
        } else {
            $host->allFields['internal_url']->value = $host->allFields['url']->value;
        }
    }

    /**
     * Displays the menu items in a tree list view so they can be reordered
     */
    public function reorder()
    {
        // Ensure the correct sidemenu is active
        BackendMenu::setContext('BenFreke.MenuManager', 'menumanager', 'reorder');

        $this->pageTitle = 'Reorder Menu';

        $toolbarConfig          = $this->makeConfig();
        $toolbarConfig->buttons = '@/plugins/benfreke/menumanager/controllers/menus/_reorder_toolbar.htm';

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

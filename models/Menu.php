<?php namespace BenFreke\MenuManager\Models;


use Model;
use System\Classes\ApplicationException;
use Lang;
use Cms\Classes\Page;

/**
 * Menu Model
 */
class Menu extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'benfreke_menumanager_menus';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title', 'description', 'parent_id'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required'
    ];



    /**
     * @var array
     */
    public $implement = ['October.Rain.Database.Behaviors.NestedSetModel'];

    /**
     * Returns the list of menu items, where the key is the id and the value is the title, indented with '-' for depth
     * @return array
     */
    public function getSelectList()
    {
        $items = $this->getAll();
        $output = array();
        foreach($items as $item) {
            $depthIndicator = $this->getDepthIndicators($item->nest_depth);
            $output["id-$item->id"] = $depthIndicator . ' ' . $item->title;
        }
        return $output;
    }

    /**
     * Recursively adds depth indicators, a '-', to a string
     *
     * @param int    $depth
     * @param string $indicators
     *
     * @return string
     */
    protected function getDepthIndicators( $depth = 0, $indicators = '' )
    {
        if ( $depth < 1 ) {
            return $indicators;
        }
        return $this->getDepthIndicators( --$depth, $indicators . '-' );
    }

    public function getPageList()
    {
        return ['first', 'second'];
    }

    public function getUrlOptions()
    {
        $pages = Page::sortBy('baseFileName')->lists('title', 'baseFileName');
        foreach($pages as $key => $value) {
            $pages[$key] = "{$value} - (File: $key)";
        }
        return $pages;
    }

}
<?php namespace BenFreke\MenuManager\Models;

use Model;
use Lang;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Cms\Classes\Controller as BaseController;
use System\Classes\ApplicationException;

/**
 * Menu Model
 */
class Menu extends Model
{

    use \October\Rain\Database\Traits\NestedTree;

    /**
     * @var \Cms\Classes\Controller A reference to the CMS controller.
     */
    private $controller;

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

    /**
     * Get a list of all pages. Prepend an empty option to the start
     *
     * @return array
     */
    public function getUrlOptions()
    {
        $allPages = Page::sortBy('baseFileName')->lists('title', 'baseFileName');
        $pages = array(
            '' => 'No page link'
        );
        foreach($allPages as $key => $value) {
            $pages[$key] = "{$value} - (File: $key)";
        }
        return $pages;
    }

    /**
     * Returns the class name so I can compare
     *
     * @return string
     */
    public static function getClassName()
    {
        return get_called_class();
    }

    /**
     * Returns the correct url for this menu item.
     * It will either be the full page URL or '#' if no link was provided
     *
     * @param bool $routePersistence
     *
     * @return string
     */
    public function getLinkHref($routePersistence = true)
    {
        $this->controller = new BaseController;

        $url = '#';

        $parameters = (array) json_decode( $this->parameters );

        if ($this->url) {
            if (!$this->is_external) {
                $url = $this->controller->pageUrl( $this->url, $parameters, $routePersistence );
            } else {
                $url = $this->url;
            }
        } 

        return $url . $this->query_string;
    }

    /**
     * Sets the target attribute for the link
     *
     * @return string
     */
    public function getLinkTarget()
    {
        return $this->link_target ?: '_self';
    }

    /**
     * Load the item classes here to keep the twig template clean
     *
     * @param int $leftIndex The left value of the active node
     * @param int $rightIndex The right value of the active node
     *
     * @return string
     *
     * @todo Add dropdown class if the depth is right
     */
    public function getListItemClasses($leftIndex, $rightIndex)
    {
        $classes = array();

        // Is this item active?
        if ($this->nest_left <= $leftIndex && $this->nest_right >= $rightIndex) {
            $classes[] = 'active';
        }

        // If not active, return an empty string
        return implode(' ', $classes);
    }
}

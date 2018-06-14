OctoberCMS Menu Manager Plugin
=====================

After installation you are able to add, edit and remove Menus from your site.

A component is included to output the menu in pages/partials/layout. It can include up to 3 levels of content. Add it as you would any other component.

## Versions ##

**Currently 1.5.3**

### 1.5.3

- Added ability to delete menu items thanks [@osmanzeki](https://github.com/osmanzeki)

### 1.5.2

- Added French Translations, thanks [@Glitchbone](https://github.com/Glitchbone)
- Added code of conduct

### 1.5.1

- Add homepage for plugin details, thanks [@gegor85](https://github.com/gergo85)
- Added a couple of missing translations

### 1.5.0

- Added support for postgres and sqlite by fixing migrations and updating mutator and accessors

### 1.4.8

- Merged PR to fix re-order errors. Thanks [@CptMeatball](https://github.com/CptMeatball)

### 1.4.7

- Merged PR to fix syntax errors with fresh install of 1.4.6. Thanks [@devlifeX](https://github.com/devlifeX)

### 1.4.6

- Merged PRs that fix bug with plugin not working with stable release

### 1.4.5

- Fixed bug where getBaseFileName method was moved to a different object

### 1.4.4

- Fixed bug with incorrect labels. Thanks @ribsousa

### 1.4.3

- Fixed bug where getBaseFileName method was moved to a different object

### 1.4.2

- Fixed bug where url field was not saving. Refactored code to use a Laravel Mutator.

### 1.4.1

- Fixed bug caused by deleting method I shouldn't have. Thanks @MatissJA

### 1.4.0

- Multiple bug fixes due to new features in OctoberCMS
- Ability to translate added
- Ability to add fragments to URL added

### 1.3.4

- JSON validation now works

### 1.3.3

- Fixed typo in JSON help text

### 1.3.2

- Bug fixed where param checking breaks active query. Thanks @alxy

### 1.3.1

- Bug fixed where incorrect active menu was set
- JSON validation of parameters has been added
- Both courtesy of @whsol

### 1.3.0

- Added translations

### 1.2.0

- Added list item classes; Fixed validation and admin bugs

### 1.1.3

- Fixed bug that prevented multiple components showing on the same page

### 1.1.2

- Reformatted admin interface to make more sense (possibly just to me ...)
- Removed CSS and JS partial, and replaced with an asset JS file
- Added escaping to any query string values used on a menu item
- Small updates to text to make more sense
- Reformatted some functions for future enhancements

### 1.1.1

- Added ability to enable/disable individual menu links
- Added ability for url parameters &amp; query string
- Fixed issue of "getLinkHref()" pulling through full page url with parameters rather than the ACTUAL page url
- All these changes are courtesy of [@DanielHitchen](https://github.com/DanielHitchen)

### 1.1.0

- Added ability to link to external sites. Thanks [Adis](https://github.com/adisos)

### 1.0.6

- Removed NestedSetModel
- Added NestedTree trait, thanks @daftspunk
- Fixed bug when no menus set, thanks @danielhitchens

### 1.0.5

- Moved link creation code into the model in preperation for external links coming in 1.1.0
- Brought list item class creation into the model
- Fixed typo with default menu class so it will display as pills

### 1.0.4

- Fixed bug where Nested Set traits needed to be included in the class, introduced by CMS upgrade

### 1.0.3

- Menu items no longer need to link anywhere
- Ensured the active node must always be a child of the parent node

### 1.0.2

- Added active classes to component
- Added ability to select a menu item other than the current page as the active item
- Added ability to control depth of menu

### 1.0.1

- Created backend area to manage menu items
- Created backend area to re-order menu items
- Created component to output menu in a page/partial/layout

## Roadmap

Please see the [issues register](https://github.com/benfreke/oc-menumanager-plugin/issues), as I have put all my suggested improvements there.

# Documentation

## Available Options

- **Alias** - This is available to all components and is baked into OctoberCMS
- **Parent Node** - The node to get the children of to create the menu. See the Parent Node section below for further information
- **Active Node** - This is the active page. The default option is the current page, but you can manually set which menu item should be active.
- **Primary Classes** - The classes to add to the parent ul tag. Defaults to "nav nav-pills"
- **Secondary Classes** - The classes to add to the children ul tag. Defaults to "dropdown-menu"
- **Tertiary Classes** - The classes to add to the grandchildren ul tag. Defaults to ""
- **Depth** - How many levels of menu to display. The bootstrap default is 2, so if you do wish to show 3 levels please bear in mind you will need to add your own css to the theme to handle active states.

## Adding the component to a Page

When editing a page/partial/layout, add the component to the page as you would any other component

```
{% component "menu" %}
```

Inside the widget, you can set the menu class for both the primary and secondary navigation. You also set the parent node at this time.

## Behind the scenes

Menu Manager takes advantage of Nested Sets to allow quick traversal and drag and drop functionality. It also makes working out the active page and active parents super simple.

By default no items are created. If you are developing, simply add the seed file back into the update file and run a `php artisan plugin:refresh` on the server to have some date pre-inserted.

## The Parent Node

This is the node from which the menu will be populated. The component will collect all the children of this node and create the menu content from these children nodes. For example, consider this default structure based loosely off the October CMS demo pages.

    - Main Menu
    -- Home
    --- Plugin Components
    --- Ajax Framework

If we select "Main Menu" as the Parent Node, we will have 1 menu item visible. This will the title of "Home" and will be a bootstrap style dropdown navigation. Clicking on home will reveal 2 sub-menu items, "Plugin Components" and "Ajax Framework".

If we select "Home" as the Parent Node, we will have 2 menu items visible, "Plugin Components" and "Ajax Framework".

This allows the creation of side navigation relevant to the page you are currently on by re-using the same backend menu but having separate components on the page use different Parent Nodes to change the output.

## Other

If you have any suggestions, please [raise an issue](https://github.com/benfreke/oc-menumanager-plugin/issues) on the plugin's [github repository](https://github.com/benfreke/oc-menumanager-plugin).

## Thanks / Contributions

- Obviously the [OctoberCMS](http://octobercms.com/) creators, [Samuel Georges](https://github.com/daftspunk) and [Aleksey Bobkov](https://github.com/alekseybobkov)
- [DanielHitchen](https://github.com/DanielHitchen) for bug reporting, enhancements and requests/ideas
- [Adis](https://github.com/adisos) for help with the 1.1.x releases

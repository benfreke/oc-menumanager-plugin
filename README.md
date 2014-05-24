OctoberCMS Menu Manager Plugin
=====================

After installation you are able to add, edit and remove Menus from your site.

A component is included to output the menu in pages/partials/layout. It can include up to 3 levels of content. Add it as you would any other component.

## Roadmap

These are what I've planned. If you have any suggestions, please [raise an issue](https://github.com/benfreke/oc-menumanager-plugin/issues) on the plugin's [github repository](https://github.com/benfreke/oc-menumanager-plugin).

### 1.0.2

- Localise all files

### 1.0.3

- Add active and active-parent classes to menu items depending on page location
- Move all link and class creation into Model
- Allow links to point at an external url
- Add additional parameter to links to handle url filter options (such as a blog post)

### 1.0.4

- When a page/file location is changed, update any menus that link to it

### 1.0.5

- Display the page title on the Menu listing page, not just when updating a menu item

### 1.1.0

- Add ability to link to parts of the CMS that aren't pages
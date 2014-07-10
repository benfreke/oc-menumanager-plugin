jQuery(function ($) {

    // Get and hide the options
    var menuOptions, menuShowClass;

    menuOptions = $('.menumanager-type').hide();

    // Watch for changes
    $('.menumanager-type-controller').on('change', 'select', function (event) {
        menuOptions.hide();
        setMenuType($(this).val());
        menuOptions.filter(menuShowClass).show();
    });

    // Set the initial state
    setMenuType($('.menumanager-type-controller select').trigger('change'));

    /**
     * Set the class to filter by
     * @param selectedValue
     */
    function setMenuType(selectedValue) {
        menuShowClass = '.type-' + selectedValue;
    }
});
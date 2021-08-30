(function ($, root, undefined) {

    $(function () {

        'use strict';

        var $window = $(window);
        var $body = $('body');
        var $document = $(document);


        // mobile menu button
        var $menu_button = $('#menu_button');
        var $nav = $('nav');
        $menu_button.on('click', function (e) {
            e.preventDefault();
            $nav.toggleClass('menu_visible');
        });


        // if press escape key, 
        $document.on('keydown', function (e) {
            if (e.keyCode == 27) {
                closeMenu();
            }
        });

        $('#main').on('click', function () {
            closeMenu();
        });

        function closeMenu() {
            $nav.removeClass('menu_visible');
        }



    });

})(jQuery, this);



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



        var $sections = $('section');
        $sections.removeClass('visible');
        setInvisibleSections($window, $sections);
        $window.on('scroll', function (e) {
            setInvisibleSections($window, $sections);
        })

        function setInvisibleSections($window, $sections) {
            let $scrollPos = 0;
            let $windowHeight = $window.height()
            $scrollPos = $window.scrollTop() + ($windowHeight * 0.65);
            for (let i = 0; i < $sections.length; i++) {
                const $section = $sections[i];
                if ($section.offsetTop < $scrollPos) {
                    $($section).addClass('visible');
                } else {
                    $($section).removeClass('visible');
                }
            }
        }

        // $('#services_section').addClass('always_visible');



    });

})(jQuery, this);



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


        // concert search
        // concert search

        let $search_concerts = $('#search_concerts');
        let $concert_boxes = $('.concert_box');
        let $concert_location_boxes = $('.concert_location_box');
        $search_concerts.on('keyup', function (e) {
            let search_terms = e.target.value.split(' ').filter(t => t != '');

            $concert_boxes.each(function () {
                let $this = $(this);
                let should_hide = true;
                if (search_terms.length > 0) {
                    let box_terms = $this.data('search').split('-');
                    search_terms.forEach(st => {
                        box_terms.forEach(bt => {
                            if (bt.includes(st)) {
                                should_hide = false;
                            }
                        })
                    })
                } else {
                    should_hide = false;
                }
                if (should_hide) {
                    $this.addClass('hidden');
                } else {
                    $this.removeClass('hidden');
                }
            });

            $concert_location_boxes.each(function () {
                let $this = $(this);
                let cbc = $this.find('.concert_box').length;
                let hbc = $this.find('.concert_box.hidden').length;
                if (cbc === hbc) {
                    $this.addClass('hidden')
                } else {
                    $this.removeClass('hidden');
                }
            });



        })
        // concert search
        // concert search

        $('.overflow').on('click', function () {
            $(this).toggleClass('overflow');
        })



        $("#structure_image").change(function () {
            let formdata = new FormData();
            var file;
            var len = this.files.length;
            if (len > 0) {
                file = this.files[0];
                if (formdata) {
                    formdata.append("structure_image", file);
                    formdata.append('action', 'wdm_upload_image_action');
                }

            }
            else {
                formdata = false;
            }

            if (formdata) {
                $.ajax({
                    type: 'POST',
                    url: wordpress_ajax_url,
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        /*handle response */
                        console.log(response);
                        $('#structure_image_id').val(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });


        $('.lieu_container').on('click', function () {
            let $this = $(this);
            let $id = $this.data('id');
            if (map_markers) {
                const map_marker = map_markers.find(m => m.location_id == $id);
                if (map_marker) {
                    map_map.panTo(map_marker.position);
                    if (map_map.zoom !== 17) {
                        map_map.setZoom(17);
                    }
                    map_infowindow.setContent(map_marker.infocontent);
                    map_infowindow.open(map_map, map_marker);
                }
            }
        })



        // MAP
        // MAP
        if (typeof map_locations !== "undefined") {
            var map_options = {
                zoom: 15,
                mapTypeControl: true,
                scrollwheel: false,
                draggable: true,
                navigationControlOptions: { style: google.maps.NavigationControlStyle.SMALL },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            var map_container = $('#map_container');
            var map_map = new google.maps.Map(map_container.get(0), map_options);
            var map_bounds = new google.maps.LatLngBounds();
            var map_infowindow = new google.maps.InfoWindow({ content: '...' });
            var map_markers = [];

            for (var i = 0; i < map_locations.length; i++) {
                var map_location = map_locations[i];
                if (map_location != null) {
                    addPointToMap(map_map, map_location, map_bounds, map_infowindow, map_markers);
                }
            }

            if (map_locations.length > 1) {
                map_map.fitBounds(map_bounds);
                google.maps.event.trigger(map_map, 'resize');
            } else {
                const center = map_bounds.getCenter();
                map_map.setCenter(center);
            }

            const map_cluster = new MarkerClusterer(map_map, map_markers, {
                imagePath:
                    theme_directory + '/img/m',
            });
        }
        // MAP
        // MAP


    });

})(jQuery, this);




function addPointToMap(map, location, bounds, infowindow, markers) {

    if (typeof location.lat != 'undefined' && typeof location.lng != 'undefined') {
        var latlng = new google.maps.LatLng(location.lat, location.lng);
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            title: location.title,
            url: location.url,
            location_id: location.id,
            infocontent: location.title
        });
        marker.addListener('click', function () {
            infowindow.setContent(this.infocontent);
            infowindow.open(map, this);
        });
        markers.push(marker);
        bounds.extend(latlng);
    }

};
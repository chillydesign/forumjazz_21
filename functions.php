<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup() {
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('large', 1600, '', true); // Large Thumbnail
    add_image_size('medium', 800, '', true); // Medium Thumbnail
    add_image_size('small', 400, '', true); // Small Thumbnail
    add_image_size('thumbnail', 300, 300, true); // Small Thumbnail

    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form'));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
}


remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

function disable_wp_emojicons() {

    // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // filter to remove TinyMCE emojis
    // add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action('init', 'disable_wp_emojicons');


function remove_json_api() {

    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');
    // Turn off oEmbed auto discovery.
    add_filter('embed_oembed_discover', '__return_false');
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
    // Remove all embeds rewrite rules.
    // add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

}
add_action('after_setup_theme', 'remove_json_api');



function wf_version() {
    return '0.2.4';
}

add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue() {


    $tdu = get_template_directory_uri();

    // remove gutenberg css
    wp_dequeue_style('wp-block-library');



    wp_register_script('map_cluster', '//unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js', array(), '', true); // Custom scripts
    wp_enqueue_script('map_cluster'); // Enqueue it!


    $gkey = 'AIzaSyBXhnvEf12n4T36mlca5zUM15uPJtD0HrA';
    wp_register_script('wf_google_maps', '//maps.google.com/maps/api/js?key=' . $gkey, array(), '', true); // Custom scripts
    wp_enqueue_script('wf_google_maps'); // Enqueue it!


    // COOL MUSIC NOTES
    // wp_register_script('scripts', $tdu . '/js/scripts.js', array(), wf_version(), true);
    // wp_enqueue_script('scripts'); // Enqueue it!
    // wp_register_script('vector', $tdu . '/js/vector.js', array(), wf_version(), true);
    // wp_enqueue_script('vector'); // Enqueue it!
    // wp_register_script('canvas', $tdu . '/js/canvas.js', array(), wf_version(), true);
    // wp_enqueue_script('canvas'); // Enqueue it!



    wp_register_style('wf_style', $tdu . '/css/global.css', array(), wf_version(), 'all');
    wp_enqueue_style('wf_style'); // Enqueue it!


}


add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
function html5blank_header_scripts() {
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_enqueue_script('jquery');
        // wp_deregister_script('jquery');
        $tdu = get_template_directory_uri();


        // $gkey = '';
        // wp_register_script('wf_google_maps', '//maps.google.com/maps/api/js?key=' . $gkey, array(), '', true); // Custom scripts
        // wp_enqueue_script('wf_google_maps'); // Enqueue it!

        wp_register_script('scripts', $tdu . '/js/scripts.js', array(),  wf_version(), true);
        wp_enqueue_script('scripts'); // Enqueue it!



    }
}

add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
function register_html5_menu() {
    register_nav_menus(array( // Using array to specify more menus if needed
        'primary-navigation' => __('Primary Menu', 'webfactor'), // Main Navigation
        'footer-navigation' => __('Footer Menu', 'webfactor'), // Footer Navigation
        'social-navigation' => __('Social Menu', 'webfactor'), // Social Navigation
    ));
}

function chilly_nav($menu) {
    wp_nav_menu(
        array(
            'theme_location'  => $menu,
            'menu'            => '',
            'container'       => '',
            'container_class' => 'menu-{menu slug}-container',
            'container_id'    => '',
            'menu_class'      => '',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '%3$s',
            'depth'           => 0,
            'walker'          => ''
        )
    );
}




// add_action('wp_footer', 'blankslate_footer');
function blankslate_footer() {
?>
    <script>
        jQuery(document).ready(function($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
<?php
}
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep) {
    $sep = '|';
    return $sep;
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title) {
    if ($title == '') {
        return '...';
    } else {
        return $title;
    }
}
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts) {
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open() {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link() {
    echo '<a href="#main" class="skip-link screen-reader-text">' . esc_html__('Accès direct au contenu', 'blankslate') . '</a>';
}
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link() {
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more) {
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes) {
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Footer Widget Area', 'blankslate'),
        'id' => 'footer-widget-area',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script() {
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function blankslate_custom_pings($comment) {
?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php
}
add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count) {
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}





add_action('init', 'create_post_types'); // Add our Slide Type

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_types() {

    $concert_slug = 'concert';
    $concert_slug_plural = 'concerts';
    register_post_type(
        'concert', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Concerts', 'webfactor'), // Rename these to suit
                'singular_name' => __('Concert', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Concert', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Concert', 'webfactor'),
                'new_item' => __('Ajouter Concert', 'webfactor'),
                'view' => __('Afficher Concert', 'webfactor'),
                'view_item' => __('Afficher Concert', 'webfactor'),
                'search_items' => __('Rechercher Concerts', 'webfactor'),
                'not_found' => __('Pas de Concert trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Concert trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $concert_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $concert_slug_plural,
                'delete_others_posts' => 'delete_others_' . $concert_slug_plural,
                'delete_posts' => 'delete_' . $concert_slug_plural,
                'delete_private_posts' => 'delete_private_' . $concert_slug_plural,
                'delete_published_posts' => 'delete_published_' . $concert_slug_plural,
                'edit_posts' => 'edit_' . $concert_slug_plural,
                'edit_others_posts' => 'edit_others_' . $concert_slug_plural,
                'edit_private_posts' => 'edit_private_' . $concert_slug_plural,
                'edit_published_posts' => 'edit_published_' . $concert_slug_plural,
                'publish_posts' => 'publish_' . $concert_slug_plural,
                'read_private_posts' => 'read_private_' . $concert_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => true, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );


    $extra_slug = 'extra';
    $extra_slug_plural = 'extras';

    register_post_type(
        'extra', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Extras', 'webfactor'), // Rename these to suit
                'singular_name' => __('Extra', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Extra', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Extra', 'webfactor'),
                'new_item' => __('Ajouter Extra', 'webfactor'),
                'view' => __('Afficher Extra', 'webfactor'),
                'view_item' => __('Afficher Extra', 'webfactor'),
                'search_items' => __('Rechercher Extras', 'webfactor'),
                'not_found' => __('Pas de Extra trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Extra trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $extra_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $extra_slug_plural,
                'delete_others_posts' => 'delete_others_' . $extra_slug_plural,
                'delete_posts' => 'delete_' . $extra_slug_plural,
                'delete_private_posts' => 'delete_private_' . $extra_slug_plural,
                'delete_published_posts' => 'delete_published_' . $extra_slug_plural,
                'edit_posts' => 'edit_' . $extra_slug_plural,
                'edit_others_posts' => 'edit_others_' . $extra_slug_plural,
                'edit_private_posts' => 'edit_private_' . $extra_slug_plural,
                'edit_published_posts' => 'edit_published_' . $extra_slug_plural,
                'publish_posts' => 'publish_' . $extra_slug_plural,
                'read_private_posts' => 'read_private_' . $extra_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => true, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );

    $extra_forum_slug = 'extraforum';
    $extra_forum_slug_plural = 'extraforums';

    register_post_type(
        'extraforum', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Extra forums', 'webfactor'), // Rename these to suit
                'singular_name' => __('Extra forum', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Extra forum', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Extra forum', 'webfactor'),
                'new_item' => __('Ajouter Extra forum', 'webfactor'),
                'view' => __('Afficher Extra forum', 'webfactor'),
                'view_item' => __('Afficher Extra forum', 'webfactor'),
                'search_items' => __('Rechercher Extra forums', 'webfactor'),
                'not_found' => __('Pas de Extra forum trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Extra forum trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $extra_forum_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $extra_forum_slug_plural,
                'delete_others_posts' => 'delete_others_' . $extra_forum_slug_plural,
                'delete_posts' => 'delete_' . $extra_forum_slug_plural,
                'delete_private_posts' => 'delete_private_' . $extra_forum_slug_plural,
                'delete_published_posts' => 'delete_published_' . $extra_forum_slug_plural,
                'edit_posts' => 'edit_' . $extra_forum_slug_plural,
                'edit_others_posts' => 'edit_others_' . $extra_forum_slug_plural,
                'edit_private_posts' => 'edit_private_' . $extra_forum_slug_plural,
                'edit_published_posts' => 'edit_published_' . $extra_forum_slug_plural,
                'publish_posts' => 'publish_' . $extra_forum_slug_plural,
                'read_private_posts' => 'read_private_' . $extra_forum_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => true, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );

    $recontre_slug = 'rencontre';
    $recontre_slug_plural = 'rencontres';

    register_post_type(
        'rencontre', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Rencontres', 'webfactor'), // Rename these to suit
                'singular_name' => __('Rencontre', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Rencontre', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Rencontre', 'webfactor'),
                'new_item' => __('Ajouter Rencontre', 'webfactor'),
                'view' => __('Afficher Rencontre', 'webfactor'),
                'view_item' => __('Afficher Rencontre', 'webfactor'),
                'search_items' => __('Rechercher Rencontres', 'webfactor'),
                'not_found' => __('Pas de Rencontre trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Rencontre trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $recontre_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $recontre_slug_plural,
                'delete_others_posts' => 'delete_others_' . $recontre_slug_plural,
                'delete_posts' => 'delete_' . $recontre_slug_plural,
                'delete_private_posts' => 'delete_private_' . $recontre_slug_plural,
                'delete_published_posts' => 'delete_published_' . $recontre_slug_plural,
                'edit_posts' => 'edit_' . $recontre_slug_plural,
                'edit_others_posts' => 'edit_others_' . $recontre_slug_plural,
                'edit_private_posts' => 'edit_private_' . $recontre_slug_plural,
                'edit_published_posts' => 'edit_published_' . $recontre_slug_plural,
                'publish_posts' => 'publish_' . $recontre_slug_plural,
                'read_private_posts' => 'read_private_' . $recontre_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => true, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );



    $location_slug = 'lieu';
    $location_slug_plural = 'lieux';
    register_post_type(
        'lieu', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Lieux', 'webfactor'), // Rename these to suit
                'singular_name' => __('Lieu', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Lieu', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Lieu', 'webfactor'),
                'new_item' => __('Ajouter Lieu', 'webfactor'),
                'view' => __('Afficher Lieu', 'webfactor'),
                'view_item' => __('Afficher Lieu', 'webfactor'),
                'search_items' => __('Rechercher Lieux', 'webfactor'),
                'not_found' => __('Pas de Lieu trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Lieu trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $location_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $location_slug_plural,
                'delete_others_posts' => 'delete_others_' . $location_slug_plural,
                'delete_posts' => 'delete_' . $location_slug_plural,
                'delete_private_posts' => 'delete_private_' . $location_slug_plural,
                'delete_published_posts' => 'delete_published_' . $location_slug_plural,
                'edit_posts' => 'edit_' . $location_slug_plural,
                'edit_others_posts' => 'edit_others_' . $location_slug_plural,
                'edit_private_posts' => 'edit_private_' . $location_slug_plural,
                'edit_published_posts' => 'edit_published_' . $location_slug_plural,
                'publish_posts' => 'publish_' . $location_slug_plural,
                'read_private_posts' => 'read_private_' . $location_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => true, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );


    $partner_slug = 'partenaire';
    $partner_slug_plural = 'partenaires';
    register_post_type(
        'partenaire', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Partenaires', 'webfactor'), // Rename these to suit
                'singular_name' => __('Partenaire', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Partenaire', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Partenaire', 'webfactor'),
                'new_item' => __('Ajouter Partenaire', 'webfactor'),
                'view' => __('Afficher Partenaire', 'webfactor'),
                'view_item' => __('Afficher Partenaire', 'webfactor'),
                'search_items' => __('Rechercher Partenaires', 'webfactor'),
                'not_found' => __('Pas de Partenaire trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Partenaire trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $partner_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $partner_slug_plural,
                'delete_others_posts' => 'delete_others_' . $partner_slug_plural,
                'delete_posts' => 'delete_' . $partner_slug_plural,
                'delete_private_posts' => 'delete_private_' . $partner_slug_plural,
                'delete_published_posts' => 'delete_published_' . $partner_slug_plural,
                'edit_posts' => 'edit_' . $partner_slug_plural,
                'edit_others_posts' => 'edit_others_' . $partner_slug_plural,
                'edit_private_posts' => 'edit_private_' . $partner_slug_plural,
                'edit_published_posts' => 'edit_published_' . $partner_slug_plural,
                'publish_posts' => 'publish_' . $partner_slug_plural,
                'read_private_posts' => 'read_private_' . $partner_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => true, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );



    $cat_labels = array(
        'name'                       => 'Catégories',
        'singular_name'              => 'Catégorie',
        'menu_name'                  => 'Catégorie',
        'all_items'                  => 'Toutes les Catégories',
        'parent_item'                => 'Catégorie parente',
        'parent_item_colon'          => 'Catégorie parente:',
        'new_item_name'              => 'Nom de la nouvelle categorie',
        'add_new_item'               => 'Ajouter une categorie',
        'edit_item'                  => 'Modifier categorie',
        'update_item'                => 'Mettre à jur la categorie',
        'separate_items_with_commas' => 'Separer les categories avec des virgules',
        'search_items'               => 'Chercher dans les categories',
        'add_or_remove_items'        => 'Ajouter ou supprimer des categories',
        'choose_from_most_used'      => 'Choisir parmi les categories les plus utilisées',
    );

    $cat_args = array(
        'labels'                     => $cat_labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('concert_category', array('concert'), $cat_args);
    register_taxonomy('extra_category', array('extra'), $cat_args);
    register_taxonomy('rencontre_category', array('rencontre'), $cat_args);
    register_taxonomy('partenaire_category', array('partenaire'), $cat_args);


    $prix_slug = 'prix';
    $prix_slug_plural = 'prixes';
    register_post_type(
        'prix', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Votes', 'webfactor'), // Rename these to suit
                'singular_name' => __('Vote', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Vote', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Vote', 'webfactor'),
                'new_item' => __('Ajouter Vote', 'webfactor'),
                'view' => __('Afficher Vote', 'webfactor'),
                'view_item' => __('Afficher Vote', 'webfactor'),
                'search_items' => __('Rechercher Votes', 'webfactor'),
                'not_found' => __('Pas de Vote trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Vote trouvé dans la corbeille', 'webfactor')
            ),
            'map_meta_cap' => true,
            'capability_type' => $prix_slug,
            'capabilities' => array(
                'create_posts' => 'create_' . $prix_slug_plural,
                'delete_others_posts' => 'delete_others_' . $prix_slug_plural,
                'delete_posts' => 'delete_' . $prix_slug_plural,
                'delete_private_posts' => 'delete_private_' . $prix_slug_plural,
                'delete_published_posts' => 'delete_published_' . $prix_slug_plural,
                'edit_posts' => 'edit_' . $prix_slug_plural,
                'edit_others_posts' => 'edit_others_' . $prix_slug_plural,
                'edit_private_posts' => 'edit_private_' . $prix_slug_plural,
                'edit_published_posts' => 'edit_published_' . $prix_slug_plural,
                'publish_posts' => 'publish_' . $prix_slug_plural,
                'read_private_posts' => 'read_private_' . $prix_slug_plural,
                'read' => 'read',
            ),
            'public' => true,
            'publicly_queryable' => false, // dont allow to see on front end
            'exclude_from_search' => true, // dont show in search
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );
}



function shortmonth_of($date) {
    $nice_date =  date_i18n('M', strtotime(($date)));
    return $nice_date;
}

function month_of($date) {
    $nice_date =  date_i18n('F', strtotime(($date)));
    return $nice_date;
}

function day_of($date) {

    $nice_date =  date_i18n('l', strtotime(($date)));
    return $nice_date;
}
function date_of($date) {

    $nice_date =  date_i18n('d', strtotime(($date)));
    return $nice_date;
}


function chilly_get_name($obj) {
    return ($obj->name);
}

function  cat_names_from_categories($categories) {
    if (!is_array($categories)) {
        return null;
    }
    return  implode(', ',  array_map('chilly_get_name', $categories));
}

function youtube_id_from_url($url) {

    $a = explode('?v=', $url);
    $b = $a[1];
    $c = explode('&', $b);
    $d = $c[0];
    $id = $d;
    return $id;
}


function lieu_to_map_json($lieu) {
    $position = get_field('position', $lieu->ID);
    if ($position) {
        $latlng = explode(',', $position);
        $title = $lieu->post_title;
        $obj = new stdClass();
        $obj->lat = $latlng[0];
        $obj->lng = $latlng[1];
        $obj->title = $title;
        $obj->id = $lieu->ID;
        $obj->url = $lieu->guid;
        return ($obj);
    }
    return null;
}

function thumbnail_of_post_url($post_id,  $size = 'large') {

    $image_id = get_post_thumbnail_id($post_id);
    $image_url = wp_get_attachment_image_src($image_id, $size);
    if ($image_url) {
        $image = $image_url[0];
        return $image;
    }
    return false;
}

add_action("login_head", "login_background_image");
function login_background_image() {
    $tdu = get_template_directory_uri();
    echo '<style type="text/css">
    body.login { 
        background-image: url( "' . $tdu . '/img/admin_background.jpg") !important;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        box-shadow: 0 0 0 2000px rgba(0,0,0,0.5) inset
    }
    body.login  #login a {
        color: white !important;
    </style>';
}


function generate_date_box($date) {
    $month = shortmonth_of($date);
    $day = date_of($date);

    echo   '<div class="event_date_container">
            <div class="month">' . $month . '</div>
            <div class="day">' . $day . '</div>
        </div>';
}




add_action('pre_get_posts', 'my_change_sort_order');
function my_change_sort_order($query) {
    if ($query->is_main_query()) :
        if (is_post_type_archive(array('concert', 'extra', 'recontre'))) :
            $current_date = date('Ymd');
            $query->set('order', 'ASC');
            $query->set('orderby', 'meta_value_num');
            $query->set('meta_key', 'date');
            $query->set('posts_per_page', -1);
            $query->set('meta_query', array(
                array(
                    'key' => 'date',
                    'value' => $current_date,
                    'compare' => '>'
                ),
            ));
        endif;
    endif;
};

// WOOCOMMERCE
// WOOCOMMERCE
// WOOCOMMERCE


function chilly_already_bought_shortcode($atts) {
    $product_ids =  array(531, 532, 533, 534);
    $products_bought = array();
    foreach ($product_ids as $product_id) {
        if (chilly_customer_already_bought($product_id)) {
            $product = wc_get_product($product_id);
            $product_name = $product->get_name();
            array_push($products_bought, $product_name);
        }
    }

    if (sizeof($products_bought) > 0) {

        echo '<p class="alert">' . __("Vous avez acheté le pass pro ", 'webfactor') . implode(',', $products_bought)  .  '. ' . __("Lors de l'achat du pass nous vous demandons de renseigner des informations sur votre compte. Pour acheter le pass pro pour une autre personne, veuillez", 'webfactor') . '<a href="' . wp_logout_url(home_url()) . '">' . __("cliquer ici pour vous déconnecter", 'webfactor') . '</a>';
    }
}
add_shortcode('already_bought_message', 'chilly_already_bought_shortcode');


function chilly_product_add_to_cart($atts) {
    global $post;

    if (empty($atts)) {
        return '';
    }

    $atts = shortcode_atts(
        array(
            'id'         => '',
            'class'      => '',
            'quantity'   => '1',
            'sku'        => '',
            'show_price' => 'true',
        ),
        $atts,
        'product_add_to_cart'
    );

    if (!empty($atts['id'])) {
        $product_data = get_post($atts['id']);
    } elseif (!empty($atts['sku'])) {
        $product_id   = wc_get_product_id_by_sku($atts['sku']);
        $product_data = get_post($product_id);
    } else {
        return '';
    }

    $product = is_object($product_data) && in_array($product_data->post_type, array('product', 'product_variation'), true) ? wc_setup_product_data($product_data) : false;

    if (!$product) {
        return '';
    }

    ob_start();


    $css = 'style="min-height: auto;  padding: 10px; background: rgba(255,255,255,0.4);"';

    if (chilly_customer_already_bought($atts['id'])) {
        echo '<p ' . $css . '>' . __("Acheté", 'webfactor') . '</p>';
    } else    if (chilly_find_product_in_cart($atts['id'])) {
        echo '<p ' . $css . ' >' . __('Déjà ajouté au panier', 'webfactor')  . '<br>   <a class="added_to_cart" href="' . wc_get_cart_url() . '">' . __('Aller au panier', 'webfactor') . '</a></p>';
    } else {
        echo '<p class="product woocommerce add_to_cart_inline ' . esc_attr($atts['class']) . '" >';
        if (wc_string_to_bool($atts['show_price'])) {
            // @codingStandardsIgnoreStart
            echo $product->get_price_html();
            // @codingStandardsIgnoreEnd
        }
        woocommerce_template_loop_add_to_cart(
            array(
                'quantity' => $atts['quantity'],
            )
        );
        echo '</p>';
    }



    // Restore Product global in case this is shown inside a product post.
    wc_setup_product_data($post);

    return ob_get_clean();
}



add_shortcode('chilly_add_to_cart', 'chilly_product_add_to_cart');




function chilly_customer_already_bought($product_id) {

    if (!is_user_logged_in()) {
        return false;
    }

    return wc_customer_bought_product(
        wp_get_current_user()->user_email,
        get_current_user_id(),
        $product_id
    );
}


function chilly_find_product_in_cart($product_id) {
    $product_cart_id = WC()->cart->generate_cart_id($product_id);
    $in_cart = WC()->cart->find_product_in_cart($product_cart_id);
    return ($in_cart);
}


// // DONT LET LOGGED IN USER BUY SAME PRODUCT TWICE
// add_filter('woocommerce_is_purchasable', 'chilly_wc_disable_repeat_purchase', 10, 2);
// function chilly_wc_disable_repeat_purchase($purchasable, $product) {
//     if (is_user_logged_in()) {
//         return !chilly_customer_already_bought($product->get_id());
//     } else {
//         return $purchasable;
//     }
// }


/**
 * Remove password strength check.
 */
function iconic_remove_password_strength() {
    wp_dequeue_script('wc-password-strength-meter');
}
add_action('wp_print_scripts', 'iconic_remove_password_strength', 10);

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

// REMOVE EXTRA FIELDS FROM CHECKOUT AND MAKE SOME UNREQUIRED
function custom_override_checkout_fields($fields) {

    unset($fields['billing']['billing_phone']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);

    unset($fields['order']['order_comments']);

    return $fields;
}
add_filter('woocommerce_enable_order_notes_field', '__return_false', 9999);
add_action('woocommerce_after_order_notes', 'chilly_custom_checkout_field');


add_action('woocommerce_before_checkout_form', 'chilly_add_message_checkout');

function chilly_add_message_checkout() {

    if (is_user_logged_in()) {
        $email =   wp_get_current_user()->user_email;
        echo '<p class="alert">' . __('Vous êtes connecté avec le compte', 'webfactor') . ' ' . $email .  '. ' . __('Si vous souhaitez acheter le pass pour un autre compte', 'webfactor') .  ' <a href="' .  wp_logout_url(home_url())  . '">' . __('veuillez vous déconnecter', 'webfactor') . '</a>.</p>';
    }
}

if (!function_exists('api_save_csv_string')) {
    function api_save_csv_string($string) {

        $new_string = html_entity_decode($string);
        $new_string = str_replace(array("\r", "\n"), ' | ', $new_string);
        $new_string = str_replace(';', ' ', $new_string);
        $new_string = str_replace(',', ' ', $new_string);
        $new_string = strip_tags($new_string);
        return $new_string;
    }
}



/**
 * ADD CUSTOM FIELDS TO CHECKOUT
 */


function chilly_extra_woocommerce_fields() {
    return array(
        array('structure_name', __('Structure', 'blankslate')),
        array('structure_position',   __('Position', 'blankslate')),
        array('structure_website',   __('Site web', 'blankslate')),
        array('structure_telephone',  __('Phone', 'blankslate'))
    );
}

function chilly_custom_checkout_field($checkout) {

    echo '<div id="my_custom_checkout_field"><br><br><h3>' . __('Vos informations personnelles', 'blankslate') . '</h3>';

    // add image upload
    echo '<p class="form-row my-field-class form-row-wide validate-required" id="structure_image_field" data-priority=""><label for="structure_image" class="">' .  __('Image', 'blankslate') . '&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="hidden" name="structure_image_id" id="structure_image_id" /><input type="file" class="input-text " name="structure_image" id="structure_image" placeholder="Structure"  value=""  /></span></p><script>const wordpress_ajax_url = "' .  admin_url('admin-ajax.php') . '"</script> ';

    $fields  = chilly_extra_woocommerce_fields();
    foreach ($fields   as $field) {
        woocommerce_form_field($field[0], array(
            'type'          => 'text',
            'class'         => array('my-field-class form-row-wide'),
            'label'         => __($field[1]),
            'required'  => true,
            'placeholder'   => __($field[1]),
        ), $checkout->get_value($field[0]));
    }




    echo '</div>';
}


add_action('wp_ajax_wdm_upload_image_action', 'wdm_upload_image_action_callback');
add_action('wp_ajax_nopriv_wdm_upload_image_action', 'wdm_upload_image_action_callback');
function wdm_upload_image_action_callback() {
    if (!empty($_FILES)) {
        //Check if there are any errors in the upload.
        if ($_FILES['structure_image']['error'] > 0) {
            die('An error occurred when uploading.');
        }

        /* validate the file type */

        // check if a file with the same name exists
        if (file_exists('upload/' . $_FILES['structure_image']['name'])) {
            die('File name exists.');
        }

        //get file path
        $filename = $_FILES['structure_image']['name'];
        $type = $_FILES['structure_image']['type'];
        $tmp_name = $_FILES['structure_image']['tmp_name'];
        $error = $_FILES['structure_image']['error'];
        $size = $_FILES['structure_image']['size'];

        //Upload Files to WordPress Uploads Folder
        if (!function_exists('wp_handle_upload'))
            require_once(ABSPATH . 'wp-admin/includes/file.php');

        $uploadedfile = $_FILES['structure_image'];
        $upload_overrides = array(
            'test_form' => false,
            'test_size' => true,
            'test_upload' => true,
        );

        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);


        if ($movefile && !isset($movefile['error'])) {
            //file is uploaded successfully
            $wp_upload_dir = wp_upload_dir();
            $attachment = array(
                'guid' => $wp_upload_dir['url'] . '/' . basename($movefile['file']),
                'post_mime_type' => $movefile['type'],
                // 'post_title' =>  sanitize_title(basename($movefile['file'])),
                'post_title' => 'image from woocommerce form',
                'post_content' => "",
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, $movefile['file']);
            // add thumnbails
            $attach_data = wp_generate_attachment_metadata($attach_id, $movefile['file']);
            wp_update_attachment_metadata($attach_id,  $attach_data);
            // echo $filename;
            echo $attach_id;
            wp_die();
        } else {
            // upload error 
            echo ($movefile['error']);
        }
    }
    echo 'error';
}





add_action('woocommerce_checkout_update_order_meta', 'chilly_add_custom_user_meta');
function chilly_add_custom_user_meta($order_id) {
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();
    if ($user_id) {
        $fields  = chilly_extra_woocommerce_fields();
        foreach ($fields as $field) {
            if (!empty($_POST[$field[0]])) {
                update_user_meta($user_id, $field[0], $_POST[$field[0]]);
            }
        }

        update_user_meta($user_id, 'structure_image',   $_POST['structure_image_id']);
    }
}


/**
 * Display field value on the order edit page
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);

function my_custom_checkout_field_display_admin_order_meta($order) {
    $user_id = $order->get_user_id();
    $fields  = chilly_extra_woocommerce_fields();
    foreach ($fields   as $field) {
        echo '<p><strong>' . __($field[1]) . ':</strong> ' . get_user_meta($user_id, $field[0], true) . '</p>';
    }
}

add_action('woocommerce_checkout_process', 'chilly_custom_checkout_field_process');

function chilly_custom_checkout_field_process() {
    // Check if set, if its not set add an error.
    $fields  = chilly_extra_woocommerce_fields();
    foreach ($fields   as $field) {
        if (!$_POST[$field[0]]) {
            wc_add_notice(__($field[1] . ' est obligatoire'), 'error');
        }
    }
}

// make customers participant user role by default
function my_new_customer_data($new_customer_data) {
    $new_customer_data['role'] = 'participant';
    return $new_customer_data;
}
add_filter('woocommerce_new_customer_data', 'my_new_customer_data');



add_filter('woocommerce_prevent_admin_access', '__return_false');
// add_filter('woocommerce_disable_admin_bar', '__return_false');



function processConcerts($concerts) {
    foreach ($concerts as $concert) {
        processConcert($concert);
    }
    usort($concerts, "sort_by_event_date_and_time");
    return $concerts;
}


function makeSearchTime($time) {
    if ($time) {
        $ar = explode(':', $time);
        $h = intval($ar[0]);
        $m = intval($ar[1]);
        // if after midnight make it display after
        // morning and evening events, not before
        if ($h < 5) {
            $h += 24;
            if ($m == 0) {
                $m = '00';
            }
            return  $h . ':' . $m;
        }
        return $time;
    }
    return $time;
}


function sort_by_location_name_and_time($a, $b) {
    return strcmp($a->location_name . $a->search_time, $b->location_name . $b->search_time);
}

function sort_by_menu_order_and_time($a, $b) {
    return strcmp(
        $a->menu_order . '---' . $a->search_time,
        $b->menu_order . '---' . $b->search_time
    );
}

function sort_by_event_date_and_time($a, $b) {
    return strcmp(
        $a->date . '---' . $a->search_time,
        $b->date . '---' . $b->search_time
    );
}



function processConcert($concert) {



    $concert->location = get_field('location', $concert->ID);
    $concert->time = get_field('time',  $concert->ID);
    $concert->search_time = makeSearchTime($concert->time);

    $concert->url = get_permalink($concert->ID);

    // $concert->image = thumbnail_of_post_url($concert->ID, 'medium');
    $image =  get_field('image',  $concert->ID);
    if ($image) {
        $concert->image = $image['sizes']['medium'];
    }
    $concert->search = sanitize_title($concert->post_title);

    if ($concert->location) {
        $concert->location_name = $concert->location->post_title;
        // $concert->location_name =   __('Showcase', 'blankslate');
        $concert->search = sanitize_title($concert->location_name . ' ' . $concert->post_title);
    } else if ($concert->post_type == 'rencontre') {
        $concert->location_name =   __('Rencontres', 'blankslate');
    }

    return $concert;
}

function processDatesForConcertsByDate($concerts) {
    foreach ($concerts as $concert) {
        $concert = processConcert($concert);
        $date =  get_field('date',  $concert->ID);
        $concert->date = $date;
        $concert->nice_date = implode(' ', array(day_of($date), date_of($date), month_of($date)));
        $concert->ticketing = get_field('ticketing',  $concert->ID);
        $concert->ticketing_text = get_field('ticketing_text',  $concert->ID);

        // if exists alt_title display tha tinstead of title
        $alt_title = get_field('alt_title',  $concert->ID);
        if ($alt_title) {
            $concert->alt_title =  $alt_title;
        } else {
            $concert->alt_title =  $concert->post_title;
        }
    }
    usort($concerts, "sort_by_event_date_and_time");
    return $concerts;
}

function processDatesForConcertGrid($dates, $concerts) {
    foreach ($concerts as $concert) {
        $concert_date = get_field('date',  $concert->ID);

        $date_index = array_search($concert_date, array_column($dates, 'date'));
        if (is_int($date_index)) {

            $concert = processConcert($concert);

            if (isset($concert->location_name)) {
                array_push($dates[$date_index]['concerts'], $concert);
            }
        }
    }

    // for some reason this doesnt work with a normal foreach loop
    for ($d = 0; $d < sizeof($dates); $d++) {
        usort($dates[$d]['concerts'], "sort_by_menu_order_and_time");
    }
    return $dates;
}


add_filter('cfw_get_billing_checkout_fields', 'remove_checkout_fields', 100);

function remove_checkout_fields($fields) {
    unset($fields['billing_company']);
    unset($fields['billing_city']);
    unset($fields['billing_postcode']);
    unset($fields['billing_country']);
    unset($fields['billing_state']);
    unset($fields['billing_address_1']);
    unset($fields['billing_address_2']);
    return $fields;
}


function prix_fields() {
    return [
        'first_name' => 'Prénom',
        'last_name' => 'Nom',
        'email' => 'Adresse électronique',
        'etablissement' => 'Etablissement',
        'je_suis' => 'Je suis',
        'justification' => 'Justification',
        'code' => 'Code used',
    ];
}


add_action('admin_post_nopriv_prix_jeune_form',    'process_prix_jeune_form');
add_action('admin_post_prix_jeune_form',  'process_prix_jeune_form');


function process_prix_jeune_form() {

    $referer = $_SERVER['HTTP_REFERER'];
    $referer =  explode('?',   $referer)[0];

    // IF DATA HAS BEEN POSTED
    if (isset($_POST['action'])  && $_POST['action'] == 'prix_jeune_form') {

        $code = $_POST['code'];
        $concert_id = $_POST['concert_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $etablissement = $_POST['etablissement'];
        $justification = $_POST['justification'];


        setcookie('jazz_prix_form', implode(';;', [$first_name, $last_name, $email, $etablissement, $justification]), time() + 3600, "/");


        if ($code == 'code123') {



            // if we  have the right data and user logged in
            //  && $current_user_id > 0
            if (
                !empty($email)  &&
                !empty($first_name) &&
                !empty($last_name) &&
                !empty($justification) &&
                !empty($concert_id) &&
                $concert_id != ''
            ) {
                $post = array(
                    'post_title'   => $first_name . ' ' . $last_name,
                    'post_status'  => 'publish',
                    'post_type'    => 'prix',
                    'post_content' => '',
                    'post_parent' =>  $concert_id

                );

                // EDIT OR ADD NEW POST
                $new_prix = wp_insert_post($post);

                // IF SUCCESS
                if ($new_prix > 0) {
                    // add email to ACF
                    $fields = prix_fields();
                    foreach ($fields as $field => $translation) :
                        $$field = $_POST[$field];
                        if ($$field  != '') :
                            update_field($field, $$field,  $new_prix);
                        endif;
                    endforeach;

                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    update_field('ip_address',   $ip_address, $new_prix);
                    update_field('concert_id',   $concert_id, $new_prix);

                    // clear cookie
                    setcookie('jazz_prix_form', '', time() - 3600, "/");


                    send_prix_email($email, $first_name, $last_name, $justification, $etablissement, $concert_id);

                    wp_redirect($referer . '?success', $status = 302);

                    // something went wrong with adding the prix post
                } else {
                    wp_redirect($referer . '?problem', $status = 302);
                }

                // if we dont have all the data or user not logged in
            } else {
                wp_redirect($referer . '?problem=fields', $status = 302);
            }
        } else {
            // code is wrong
            wp_redirect($referer . '?problem=code', $status = 302);
        }


        // if the form didnt post the action field
    } else {
        wp_redirect($referer . '?problem', $status = 302);
    }
}

function send_prix_email($email, $first_name, $last_name, $justification, $etablissement, $concert_id) {

    $concert = get_post($concert_id);
    if ($concert) {
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
        $headers = 'From: ' . $first_name . ' <' . $email . '>' . "\r\n";
        $headers .= 'Reply-To: ' . $first_name . ' <' . $email . '>' . "\r\n";
        $message = '';
        $message .= '<strong>NOM</strong> : ' . $first_name . ' ' . $last_name . "<br>";
        $message .= '<strong>EMAIL</strong> : '  . $email  . "<br>";
        $message .= '<strong>ETABLISSEMENT</strong> : '  . $etablissement  . "<br>";
        $message .= '<strong>Vote</strong> : '  . $concert->post_title  . "<br>";
        $message .= '<strong>JUSTIFIER VOTRE CHOIX</strong> : '  . $justification  . "<br>";
        wp_mail($email, 'Forum Jazz Prix étudiant', $message, $headers);
        remove_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type');
        return true;
    } else {
        return false;
    }
}


function user_structure_image($user_id) {
    $image = null;
    $image_id =  get_field('structure_image',  "user_" . $user_id);
    if ($image_id) {
        $image_src = wp_get_attachment_image_src($image_id, 'medium');
        if ($image_src) {
            $image = $image_src[0];
        }
    }
    if (!$image) {
        // get $user and get user email from id
        // $image = get_avatar_url($user->user_email);
    }
    return $image;
}



function webfactor_prix_jeune_shortcode($atts) {


    $output = '<div class="prix_jeune_form_container">';

    $concerts  = get_posts(array(
        'post_type' => 'concert',
        'posts_per_page' => -1,
        'suppress_filters' => 0, // stop wpml giving posts from all languages
    ));



    if (isset($_GET['success'])) :
        $output .= '<p class="alert alert_success">' . __("Votre vote a bien été enregistré !", 'blankslate') . '</p>';
    endif;

    if (isset($_GET['problem'])) :
        $output .= ' <p class="alert alert_problem">';
        if ($_GET['problem'] == 'fields') {
            $output .= __("Veuillez renseigner tous les champs.", 'blankslate');
        } else {
            $output .= __("Une erreur s'est produite.", 'blankslate');
        }
        $output .= '</p>';
    endif;





    $output .= '<form id="prix_jeune_form" action="' . esc_url(admin_url('admin-post.php')) . ' " method="post" enctype="multipart/form-data">';


    $first_name = $last_name = $email =  $etablissement =  $justification = '';
    $jcookie = $_COOKIE["jazz_prix_form"];
    if (isset($jcookie)) {
        $j = explode(';;', $jcookie);
        $first_name = $j[0];
        $last_name = $j[1];
        $email = $j[2];
        $etablissement = $j[3];
        $justification = $j[4];
    }



    $output .= '<div class="field">
        <label for="code"> ' . __(' Code (Communiqué dans votre invitation)', 'webfactor') . '*</label>
        <input type="text" id="code" name="code" />
    </div>
    <div class="field">
        <label for="first_name"> ' . __('Prénom', 'webfactor') . '*</label>
        <input type="text" id="first_name" name="first_name" value="' .  $first_name . '">
    </div>
    <div class="field">
        <label for="last_name"> ' . __('Nom', 'webfactor') . '*</label>
        <input type="text" id="last_name" name="last_name" value="' .  $last_name . '">
    </div>
    <div class="field">
        <label for="email"> ' . __('Email', 'webfactor') . '*</label>
        <input type="text" id="email" name="email" value="' .  $email . '">
    </div>


    <div class="field">
        <label for="etablissement"> ' . __('Etablissement', 'webfactor') . '*</label>
        <input type="text" id="etablissement" name="etablissement" value="' .  $etablissement . '">
    </div>


    <div class="field">
        <label for="concert_id">' . __('Cliquez sur votre groupe coup de coeur Forum Jazz 2021', 'blankslate') . '</label>
        <select name="concert_id" id="concert_id">
            <option value="">' . __('Choisir un groupe', 'webfactor') . '</option>';
    foreach ($concerts as $concert) :
        $output .= '<option value="' . $concert->ID . '">' . $concert->post_title . '</option>';
    endforeach;
    $output .= '</select>
    </div>

    <div class="field">
        <label for="justification">' . __('Merci de justifier votre choix en quelques mots', 'webfactor') . '*</label>
        <textarea id="justification" name="justification">' . $justification .  '</textarea>
    </div>


    <div class="field">
        <input type="hidden" name="action" value="prix_jeune_form">
        <input class="button" id="prix_jeune_form_submit_button" type="submit" value="' . __('Envoyer', 'webfactor') .  '">
    </div>
</form>
</div>';


    return $output;
}
add_shortcode('prix_jeune', 'webfactor_prix_jeune_shortcode');



add_action('manage_posts_extra_tablenav', 'add_download_link');
function add_download_link($which) {
    if ($which == 'bottom') {
        $tdu = get_template_directory_uri();  // get_home_url()
        if (is_post_type_archive('prix')) {
            $download_link = $tdu . '/api/v1/index_prix.php';
            echo '<div class="alignleft actions"><a class="action button-primary button" href="' . $download_link . '">Télécharger CSV</a></div>';
        }
    }
}
add_action('manage_users_extra_tablenav', 'add_download_link_users');
function add_download_link_users() {
    $tdu = get_template_directory_uri();  // get_home_url()
    $download_link = $tdu . '/api/v1/index_customers.php';
    echo '<div class="alignleft actions"><a class="action button-primary button" href="' . $download_link . '">Télécharger Participants</a></div>';
}



function social_meta_properties() {

    $smp =  new stdClass();
    $smp->site_name = 'Forum Jazz';
    global $post;


    if (is_single() || is_page()) {

        $post_id = get_the_ID();
        $smp->title = get_the_title();
        $smp->description = get_bloginfo('description');
        $smp->image =   get_template_directory_uri() . '/img/admin_background.jpg';
        $image = get_field('image', $post_id);
        if ($image) {
            $smp->image =  $image['sizes']['medium'];
        }
        $smp->url = get_the_permalink();
        $smp->type = 'article';
    } else {
        $smp->title =    get_bloginfo('name');
        $smp->description = get_bloginfo('description');
        $smp->image =   get_template_directory_uri() . '/img/admin_background.jpg';
        $smp->url = get_home_url();
        $smp->type = 'website';
    }


    return $smp;
}



?>
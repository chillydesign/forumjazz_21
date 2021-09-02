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
    return '0.0.1';
}

add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue() {


    $tdu = get_template_directory_uri();

    // remove gutenberg css
    wp_dequeue_style('wp-block-library');

    $gkey = 'AIzaSyAxQfqRqtPLAW4BolFMCxTiv9y--R8CXdU';
    wp_register_script('wf_google_maps', '//maps.google.com/maps/api/js?key=' . $gkey, array(), '', true); // Custom scripts
    wp_enqueue_script('wf_google_maps'); // Enqueue it!


    wp_register_script('scripts', $tdu . '/js/scripts.js', array(), wf_version(), true);
    wp_enqueue_script('scripts'); // Enqueue it!

    wp_register_script('vector', $tdu . '/js/vector.js', array(), wf_version(), true);
    wp_enqueue_script('vector'); // Enqueue it!
    wp_register_script('canvas2', $tdu . '/js/canvas2.js', array(), wf_version(), true);
    wp_enqueue_script('canvas2'); // Enqueue it!



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
    echo '<a href="#main" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
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
}



function month_of($date) {
    // %A <br> %d.%m.%Y
    $nice_date =  strftime('%h', strtotime(($date)));
    return $nice_date;
}

function day_of($date) {

    $nice_date =  strftime('%d', strtotime(($date)));
    return $nice_date;
}


function youtube_id_from_url($url) {

    $a = explode('?v=', $url);
    $b = $a[1];
    $c = explode('&', $b);
    $d = $c[0];
    $id = $d;
    return $id;
}


function partenaire_to_map_json($partenaire) {
    $position = get_field('position', $partenaire->ID);
    if ($position) {
        $latlng = explode(',', $position);
        $title = $partenaire->post_title;
        $obj = new stdClass();
        $obj->lat = $latlng[0];
        $obj->lng = $latlng[1];
        $obj->title = $title;
        $obj->id = $partenaire->ID;
        $obj->url = $partenaire->guid;
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

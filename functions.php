<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup() {
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form'));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}


add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue() {
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}
add_action('wp_footer', 'blankslate_footer');
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
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
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
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
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

            'public' => true,
            'publicly_queryable' => false, // dont allow to see on front end
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

            'public' => true,
            'publicly_queryable' => false, // dont allow to see on front end
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

            'public' => true,
            'publicly_queryable' => false, // dont allow to see on front end
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
}

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
add_action('admin_notices', 'blankslate_admin_notice');
function blankslate_admin_notice() {
    $user_id = get_current_user_id();
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_3') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p>' . __('<big><strong>BlankSlate</strong>:</big> Help keep the project alive! <a href="?notice-dismiss" class="alignright">Dismiss</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">Make a Donation</a>', 'blankslate') . '</p></div>';
}
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed() {
    $user_id = get_current_user_id();
    if (isset($_GET['notice-dismiss']))
        add_user_meta($user_id, 'blankslate_notice_dismissed_3', 'true', true);
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
add_action('init', 'create_post_type_video'); // Add our Video Custom Post Type

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_types() {

    register_post_type(
        'programmation', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Programmation', 'webfactor'), // Rename these to suit
                'singular_name' => __('Programmation', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Programmation', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Programmation', 'webfactor'),
                'new_item' => __('Ajouter Programmation', 'webfactor'),
                'view' => __('Afficher Programmation', 'webfactor'),
                'view_item' => __('Afficher Programmation', 'webfactor'),
                'search_items' => __('Rechercher Programmation', 'webfactor'),
                'not_found' => __('Pas de Programmation trouvée', 'webfactor'),
                'not_found_in_trash' => __('Pas de Programmation trouvée dans la corbeille', 'webfactor')
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


    function create_post_type_video() {

        $args_video_cat = array(

            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
        );
        register_taxonomy('video_cat', array('video'), $args_video_cat);


        register_post_type(
            'video', // Register Custom Post Type
            array(
                'labels' => array(
                    'name' => __('Vidéo', 'video'), // Rename these to suit
                    'singular_name' => __('Vidéo', 'video'),
                    'add_new' => __('Ajouter', 'video'),
                    'add_new_item' => __('Nouvelle Vidéo', 'video'),
                    'edit' => __('Modifier', 'video'),
                    'edit_item' => __('Modifier Vidéo', 'video'),
                    'new_item' => __('Ajouter Vidéo', 'video'),
                    'view' => __('Afficher Vidéo', 'video'),
                    'view_item' => __('Afficher Vidéo', 'video'),
                    'search_items' => __('Rechercher Vidéo', 'video'),
                    'not_found' => __('Aucune vidéo trouvée', 'video'),
                    'not_found_in_trash' => __('Aucune vidéo trouvée dans la corbeille', 'video')
                ),
                'public' => true,
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
                    'video_cat'
                ) // Add Category and Post Tags support
            )
        );
    }


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
        'agenda', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Agendas', 'webfactor'), // Rename these to suit
                'singular_name' => __('Agenda', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Agenda', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Agenda', 'webfactor'),
                'new_item' => __('Ajouter Agenda', 'webfactor'),
                'view' => __('Afficher Agenda', 'webfactor'),
                'view_item' => __('Afficher Agenda', 'webfactor'),
                'search_items' => __('Rechercher Agendas', 'webfactor'),
                'not_found' => __('Pas de Agenda trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Agenda trouvé dans la corbeille', 'webfactor')
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
        'projet', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Projets', 'webfactor'), // Rename these to suit
                'singular_name' => __('Projet', 'webfactor'),
                'add_new' => __('Ajouter', 'webfactor'),
                'add_new_item' => __('Ajouter Projet', 'webfactor'),
                'edit' => __('Modifier', 'webfactor'),
                'edit_item' => __('Modifier Projet', 'webfactor'),
                'new_item' => __('Ajouter Projet', 'webfactor'),
                'view' => __('Afficher Projet', 'webfactor'),
                'view_item' => __('Afficher Projet', 'webfactor'),
                'search_items' => __('Rechercher Projets', 'webfactor'),
                'not_found' => __('Pas de Projet trouvé', 'webfactor'),
                'not_found_in_trash' => __('Pas de Projet trouvé dans la corbeille', 'webfactor')
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
                'thumbnail',
                'author'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                //    'post_tag',
                //    'category'
            ) // Add Category and Post Tags support
        )
    );

    $prog_cat = array(
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

    $args_prog_cat = array(
        'labels'                     => $prog_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('prog_category', array('programmation', 'concert'), $args_prog_cat);


    $prog_year = array(
        'name'                       => 'Editions',
        'singular_name'              => 'Edition',
        'menu_name'                  => 'Editions',
        'all_items'                  => 'Toutes les Editions',
        'parent_item'                => 'Edition parente',
        'parent_item_colon'          => 'Edition parente:',
        'new_item_name'              => 'Nom de la nouvelle édition',
        'add_new_item'               => 'Ajouter une édition',
        'edit_item'                  => 'Modifier édition',
        'update_item'                => 'Mettre à jour l\'édition',
        'separate_items_with_commas' => 'Séparer les éditions avec des virgules',
        'search_items'               => 'Chercher dans les éditions',
        'add_or_remove_items'        => 'Ajouter ou supprimer des éditions',
        'choose_from_most_used'      => 'Choisir parmi les éditions les plus utilisées',
    );
    $args_prog_year = array(
        'labels'                     => $prog_year,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('prog_cat', array('programmation', 'concert'), $args_prog_year);



    $year_cat = array(
        'name'                       => 'Année de création',
        'singular_name'              => 'Année de création',
        'menu_name'                  => 'Année de création',
        'all_items'                  => 'Toutes les Année de création',
        'parent_item'                => 'Année de création parente',
        'parent_item_colon'          => 'Année de création parente:',
        'new_item_name'              => 'Nom de la nouvelle année de création',
        'add_new_item'               => 'Ajouter une année de création',
        'edit_item'                  => 'Modifier année de création',
        'update_item'                => 'Mettre à jur la année de création',
        'separate_items_with_commas' => 'Separer les année de créations avec des virgules',
        'search_items'               => 'Chercher dans les année de créations',
        'add_or_remove_items'        => 'Ajouter ou supprimer des année de créations',
        'choose_from_most_used'      => 'Choisir parmi les année de créations les plus utilisées',
    );

    $args_year_cat = array(
        'labels'                     => $year_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('year_creation', array('projet'), $args_year_cat);



    $esthetic_cat = array(
        'name'                       => 'Esthétiques',
        'singular_name'              => 'Esthétique',
        'menu_name'                  => 'Esthétique',
        'all_items'                  => 'Toutes les Esthétiques',
        'parent_item'                => 'Esthétique parente',
        'parent_item_colon'          => 'Esthétique parente:',
        'new_item_name'              => 'Nom de la nouvelle esthétique',
        'add_new_item'               => 'Ajouter une esthétique',
        'edit_item'                  => 'Modifier esthétique',
        'update_item'                => 'Mettre à jur la esthétique',
        'separate_items_with_commas' => 'Separer les esthétiques avec des virgules',
        'search_items'               => 'Chercher dans les esthétiques',
        'add_or_remove_items'        => 'Ajouter ou supprimer des esthétiques',
        'choose_from_most_used'      => 'Choisir parmi les esthétiques les plus utilisées',
    );

    $args_esthetic_cat = array(
        'labels'                     => $esthetic_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('esthet_category', array('projet'), $args_esthetic_cat);


    $numberpeople_cat = array(
        'name'                       => 'Effectif du projets',
        'singular_name'              => 'Effectif du projet',
        'menu_name'                  => 'Effectif du projet',
        'all_items'                  => 'Toutes les Effectif du projets',
        'parent_item'                => 'Effectif du projet parente',
        'parent_item_colon'          => 'Effectif du projet parente:',
        'new_item_name'              => 'Nom de la nouvelle effectif du projet',
        'add_new_item'               => 'Ajouter une effectif du projet',
        'edit_item'                  => 'Modifier effectif du projet',
        'update_item'                => 'Mettre à jur la effectif du projet',
        'separate_items_with_commas' => 'Separer les effectif du projets avec des virgules',
        'search_items'               => 'Chercher dans les effectif du projets',
        'add_or_remove_items'        => 'Ajouter ou supprimer des effectif du projets',
        'choose_from_most_used'      => 'Choisir parmi les effectif du projets les plus utilisées',
    );

    $args_numberpeople_cat = array(
        'labels'                     => $numberpeople_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('number_people', array('projet'), $args_numberpeople_cat);

    $format_cat = array(
        'name'                       => 'Formats',
        'singular_name'              => 'Format',
        'menu_name'                  => 'Format',
        'all_items'                  => 'Toutes les Formats',
        'parent_item'                => 'Format parente',
        'parent_item_colon'          => 'Format parente:',
        'new_item_name'              => 'Nom de la nouvelle format',
        'add_new_item'               => 'Ajouter une format',
        'edit_item'                  => 'Modifier format',
        'update_item'                => 'Mettre à jur la format',
        'separate_items_with_commas' => 'Separer les formats avec des virgules',
        'search_items'               => 'Chercher dans les formats',
        'add_or_remove_items'        => 'Ajouter ou supprimer des formats',
        'choose_from_most_used'      => 'Choisir parmi les formats les plus utilisées',
    );

    $args_format_cat = array(
        'labels'                     => $format_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('format_cat', array('projet'), $args_format_cat);

    $technique_cat = array(
        'name'                       => 'Technique',
        'singular_name'              => 'Technique',
        'menu_name'                  => 'Technique',
        'all_items'                  => 'Toutes les Techniques',
        'parent_item'                => 'Technique parente',
        'parent_item_colon'          => 'Technique parente:',
        'new_item_name'              => 'Nom de la nouvelle technique',
        'add_new_item'               => 'Ajouter une technique',
        'edit_item'                  => 'Modifier technique',
        'update_item'                => 'Mettre à jur la technique',
        'separate_items_with_commas' => 'Separer les techniques avec des virgules',
        'search_items'               => 'Chercher dans les techniques',
        'add_or_remove_items'        => 'Ajouter ou supprimer des techniques',
        'choose_from_most_used'      => 'Choisir parmi les techniques les plus utilisées',
    );

    $args_technique_cat = array(
        'labels'                     => $technique_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('technique_cat', array('projet'), $args_technique_cat);


    $public_cat = array(
        'name'                       => 'Public',
        'singular_name'              => 'Public',
        'menu_name'                  => 'Public',
        'all_items'                  => 'Toutes les Publics',
        'parent_item'                => 'Public parente',
        'parent_item_colon'          => 'Public parente:',
        'new_item_name'              => 'Nom de la nouvelle public',
        'add_new_item'               => 'Ajouter une public',
        'edit_item'                  => 'Modifier public',
        'update_item'                => 'Mettre à jur la public',
        'separate_items_with_commas' => 'Separer les publics avec des virgules',
        'search_items'               => 'Chercher dans les publics',
        'add_or_remove_items'        => 'Ajouter ou supprimer des publics',
        'choose_from_most_used'      => 'Choisir parmi les publics les plus utilisées',
    );

    $args_public_cat = array(
        'labels'                     => $public_cat,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('public_cat', array('projet'), $args_public_cat);
}

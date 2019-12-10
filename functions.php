<?php

require get_template_directory() . '/includes/settings.php';


$args = array(
    'name'          => __( 'Primary', 'headless-wp' ),
    'id'            => 'primary',    // ID should be LOWERCASE  ! ! !
    'description'   => 'This sidebar will appear on all pages, unless explicitly overridden or not included.',
    'class'         => '',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>'
);
register_sidebar( $args );

$args2 = array(
    'name'          => __( 'Secondary', 'headless-wp' ),
    'id'            => 'secondary',    // ID should be LOWERCASE  ! ! !
    'description'   => 'This sidebar will appear on all pages, unless explicitly overridden or not included.',
    'class'         => '',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>'
);
register_sidebar( $args2 );

if ( ! function_exists( 'headless-wp_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own headless-wp_setup() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     */
    function headless_wp_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/headless-wp
         * If you're building a theme based on Twenty Sixteen, use a find and replace
         * to change 'headless-wp' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'headless-wp' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1200, 9999 );

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ) );
    }
endif; // headless-wp_setup
add_action( 'after_setup_theme', 'headless_wp_setup' );


/**
 * Register a speaking post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function headless_wp_talk_init() {
    $labels = array(
        'name'               => _x( 'Talks', 'post type general name', 'headless-wp' ),
        'singular_name'      => _x( 'Talk', 'post type singular name', 'headless-wp' ),
        'menu_name'          => _x( 'Talks', 'admin menu', 'headless-wp' ),
        'name_admin_bar'     => _x( 'Talk', 'add new on admin bar', 'headless-wp' ),
        'add_new'            => _x( 'Add New', 'talk', 'headless-wp' ),
        'add_new_item'       => __( 'Add New Talk', 'headless-wp' ),
        'new_item'           => __( 'New Talk', 'headless-wp' ),
        'edit_item'          => __( 'Edit Talk', 'headless-wp' ),
        'view_item'          => __( 'View Talk', 'headless-wp' ),
        'all_items'          => __( 'All Talks', 'headless-wp' ),
        'search_items'       => __( 'Search Talks', 'headless-wp' ),
        'parent_item_colon'  => __( 'Parent Talks:', 'headless-wp' ),
        'not_found'          => __( 'No talks found.', 'headless-wp' ),
        'not_found_in_trash' => __( 'No talks found in Trash.', 'headless-wp' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'headless-wp' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'talks' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
        'menu_icon'          => 'dashicons-megaphone',
        'taxonomies'         => array( 'category', 'post_tag' )
    );

    register_post_type( 'talks', $args );
}

add_action( 'init', 'headless_wp_talk_init' );

/**
 * Register a Tips and Tricks post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function headless_wp_tips_and_tricks_init() {
    $labels = array(
        'name'               => _x( 'Tips and Tricks', 'post type general name', 'headless-wp' ),
        'singular_name'      => _x( 'Tips and Tricks', 'post type singular name', 'headless-wp' ),
        'menu_name'          => _x( 'Tips and Tricks', 'admin menu', 'headless-wp' ),
        'name_admin_bar'     => _x( 'Tips and Tricks', 'add new on admin bar', 'headless-wp' ),
        'add_new'            => _x( 'Add New', 'Tips and Tricks', 'headless-wp' ),
        'add_new_item'       => __( 'Add New Tips and Tricks', 'headless-wp' ),
        'new_item'           => __( 'New Tips and Tricks', 'headless-wp' ),
        'edit_item'          => __( 'Edit Tips and Tricks', 'headless-wp' ),
        'view_item'          => __( 'View Tips and Tricks', 'headless-wp' ),
        'all_items'          => __( 'All Tips and Tricks', 'headless-wp' ),
        'search_items'       => __( 'Search Tips and Tricks', 'headless-wp' ),
        'parent_item_colon'  => __( 'Parent Tips and Tricks:', 'headless-wp' ),
        'not_found'          => __( 'No Tips and Tricks found.', 'headless-wp' ),
        'not_found_in_trash' => __( 'No Tips and Tricks found in Trash.', 'headless-wp' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'headless-wp' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'tips-tricks' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
        'menu_icon'          => 'dashicons-money',
        'taxonomies'         => array( 'category', 'post_tag' )
    );

    register_post_type( 'tips-and-tricks', $args );
}

add_action( 'init', 'headless_wp_tips_and_tricks_init' );


/**
 * Send a request to build the site once a post is published
 */

function deploy_on_publish() {
    wp_remote_post( 'https://api.netlify.com/build_hooks/5b0f8c101f12b738363f6567', '' );
}

add_action( 'publish_post', 'deploy_on_publish' );

/**
 * Add an ACF Options page
 */
if ( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page();

}

// Add Yoase SEO data to the WP REST API response
function wp_api_encode_yoast( $data, $post, $context ) {
    $yoastMeta = array(
        'yoast_wpseo_focuskw'               => get_post_meta( $post->ID, '_yoast_wpseo_focuskw', true ),
        'yoast_wpseo_title'                 => wpseo_replace_vars( get_post_meta( $post->ID, '_yoast_wpseo_title', true ), $post ),
        'yoast_wpseo_metadesc'              => wpseo_replace_vars( get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ), $post ),
        'yoast_wpseo_linkdex'               => get_post_meta( $post->ID, '_yoast_wpseo_linkdex', true ),
        'yoast_wpseo_metakeywords'          => get_post_meta( $post->ID, '_yoast_wpseo_metakeywords', true ),
        'yoast_wpseo_meta_robots_noindex'   => get_post_meta( $post->ID, '_yoast_wpseo_meta-robots-noindex', true ),
        'yoast_wpseo_meta_robots_nofollow'  => get_post_meta( $post->ID, '_yoast_wpseo_meta-robots-nofollow', true ),
        'yoast_wpseo_meta_robots_adv'       => get_post_meta( $post->ID, '_yoast_wpseo_meta-robots-adv', true ),
        'yoast_wpseo_canonical'             => get_post_meta( $post->ID, '_yoast_wpseo_canonical', true ),
        'yoast_wpseo_redirect'              => get_post_meta( $post->ID, '_yoast_wpseo_redirect', true ),
        'yoast_wpseo_opengraph_title'       => get_post_meta( $post->ID, '_yoast_wpseo_opengraph-title', true ),
        'yoast_wpseo_opengraph_description' => get_post_meta( $post->ID, '_yoast_wpseo_opengraph-description', true ),
        'yoast_wpseo_opengraph_image'       => get_post_meta( $post->ID, '_yoast_wpseo_opengraph-image', true ),
        'yoast_wpseo_twitter_title'         => get_post_meta( $post->ID, '_yoast_wpseo_twitter-title', true ),
        'yoast_wpseo_twitter_description'   => get_post_meta( $post->ID, '_yoast_wpseo_twitter-description', true ),
        'yoast_wpseo_twitter_image'         => get_post_meta( $post->ID, '_yoast_wpseo_twitter-image', true )
    );

    $data->data['yoast_meta'] = (array) $yoastMeta;

    return $data;
}

add_filter( 'rest_prepare_post', 'wp_api_encode_yoast', 10, 3 );
add_filter( 'rest_prepare_category', 'wp_api_encode_yoast', 10, 3 );
add_filter( 'rest_prepare_page', 'wp_api_encode_yoast', 10, 3 );
add_filter( 'rest_prepare_post_tag', 'wp_api_encode_yoast', 10, 3 );



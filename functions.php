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
 * Send a request to build the site once a post is published
 */

function deploy_on_publish() {
	$netlify_main_build_hook = get_field( 'netlify_main_build_hook', 'option' );
    wp_remote_post( $netlify_main_build_hook, '' );
}

add_action( 'publish_post', 'deploy_on_publish' );


// Add Yoast SEO data to the WP REST API response
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






/**
 * Registers a custom field in the WPGraphQL schema for the site favicon.
 */
function register_favicon_field() {
	// Check if function exists to prevent fatal error if WPGraphQL is not active
	if ( function_exists( 'register_graphql_field' ) ) {
		register_graphql_field( 'GeneralSettings', 'faviconDefault', [
			'type'        => 'String',
			'description' => __( 'Site default favicon URL', 'headless-wp' ),
			'resolve'     => function () {
				$favicon_id = get_field( 'favicon_default', 'option' );
				if ( ! empty( $favicon_id ) ) {
					$favicon_url = wp_get_attachment_image_url( $favicon_id, 'full' );

					return $favicon_url;
				}

				return null;
			}
		] );
		register_graphql_field( 'GeneralSettings', 'faviconDark', [
			'type'        => 'String',
			'description' => __( 'Site dark favicon URL', 'headless-wp' ),
			'resolve'     => function () {
				$favicon_id = get_field( 'favicon_dark', 'option' );
				if ( ! empty( $favicon_id ) ) {
					$favicon_url = wp_get_attachment_image_url( $favicon_id, 'full' );

					return $favicon_url;
				}

				return null;
			}
		] );
	}
}
// Hook into WPGraphQL's register_types action
add_action( 'graphql_register_types', 'register_favicon_field' );
/**
 * Remove the HTML from post excerpts. It makes it easier to deal with the string of text for NEXT.js
 */
remove_filter( 'the_excerpt', 'wpautop' );

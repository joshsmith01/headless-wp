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
	wp_remote_post( 'https://api.netlify.com/build_hooks/5b0f8c101f12b738363f6567', '' );
}

add_action( 'publish_post', 'deploy_on_publish' );

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
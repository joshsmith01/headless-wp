<?php
/**
 * Setup the new field on the General Settings page
 */
function headlesswp_settings_api_init() {
	// Add the section to general settings so we can add our fields to it
	add_settings_section(
		'headlesswp_setting_section',
		'Redirect your Headless WP',
		'headlesswp_setting_section_callback_function',
		'general'
	);

	// Add the field with the names and function to use for our new settings, put it in our new section
	add_settings_field(
		'headlesswp_setting_name',
		'New URL',
		'headlesswp_setting_callback_function',
		'general',
		'headlesswp_setting_section'
	);

	// Register our setting so that $_POST handling is done for us and
	// our callback function just has to echo the <input>
	register_setting( 'general', 'headlesswp_setting_name' );
} // headlesswp_settings_api_init()

add_action( 'admin_init', 'headlesswp_settings_api_init' );


// ------------------------------------------------------------------
// Settings section callback function
// ------------------------------------------------------------------
//
// This function is needed if we added a new section. This function
// will be run at the start of our section
//

function headlesswp_setting_section_callback_function() {
	echo '<p>If you want to redirect your WordPress instance, add the new URL here</p>';
}

// ------------------------------------------------------------------
// Callback function for our example setting
// ------------------------------------------------------------------
//
// creates a checkbox true/false option. Other types are surely possible
//

function headlesswp_setting_callback_function() {
	echo '<input name="headlesswp_setting_name" id="headlesswp_setting_name" type="url" class="regular-text code" value="' . get_option( 'headlesswp_setting_name' ) . '" /><p>If you want this installation to redirect add a URL here.<br> This is useful for when you only want your WordPress to serve data via the WP REST API or similar API.</p>';
}
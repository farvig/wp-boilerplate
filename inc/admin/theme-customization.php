<?php

/*
 * Theme Customization
 */


function ivp_theme_customizer(){
	wp_enqueue_script( 
		  'ivp-themecustomizer',
		  get_template_directory_uri().'/inc/assets/js/theme-customizer.js',
		  array( 
		  	'jquery',
		  	'customize-preview'
		  ),
		  '1.0.0',
		  true
	);
}
add_action( 'customize_preview_init', 'ivp_theme_customizer' );


// This theme allows users to set a custom background
// add_custom_background was deprecated as of 3.4, so testing for existence, but keeping add_custom_background for backward-compatibility
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'custom-background' );
} else {
	add_custom_background();
}

// Add a way for the custom header to be styled in the admin panel that controls
// custom headers. See boilerplate_admin_header_style(), below.
// add_custom_image_header was deprecated as of 3.4, so testing for existence, but keeping add_custom_image_header for backward-compatibility
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'custom-header' );

} else {
	add_custom_image_header( '', 'boilerplate_admin_header_style' );
}


// The height and width of your custom header. You can hook into the theme's own filters to change these values.
// Add a filter to boilerplate_header_image_width and boilerplate_header_image_height to change these values.
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'boilerplate_header_image_width', 1000 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'boilerplate_header_image_height', 250 ) );

// Don't support text inside the header image.
define( 'NO_HEADER_TEXT', true );

// We'll be using post thumbnails for custom header images on posts and pages.
// We want them to be 940 pixels wide by 198 pixels tall.
// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );


// doesn't seem to work
//add_action( 'customize_controls_enqueue_scripts', 'ivp_theme_customizer_live_preview' );


function ivp_register_theme_customizer( $wp_customizer ) {
    $wp_customizer->add_section(
    	'ivp_display_header_options',
    	 array(
    	 	'title' 	=> 'Display header options',
    	 	'priority'	=> 200
    	 )
    );

	$wp_customizer->add_setting(
		'ivp_logo_file',
    	 array(
    	 	'default' 	=> '',
    	 	'transport'	=> 'postMessage'
    	 )
	);   

	$wp_customizer->add_control(
		new WP_Customize_Image_Control(
			$wp_customizer,
			'ivp_logo_file',
	    	 array(
	    	 	'label'		=> 'Choose logo',
	    	 	'section' 	=> 'ivp_display_header_options',
	    	 	'settings'	=> 'ivp_logo_file'
	    	 )
    	 )
	);
	$wp_customizer->add_setting(
		'ivp_page_title_bg',
    	 array(
    	 	'default' 	=> '',
    	 	'transport'	=> 'postMessage'
    	 )
	);   

	$wp_customizer->add_control(
		new WP_Customize_Image_Control(
			$wp_customizer,
			'ivp_page_title_bg',
	    	 array(
	    	 	'label'		=> 'Choose background image',
	    	 	'section' 	=> 'ivp_display_header_options',
	    	 	'settings'	=> 'ivp_page_title_bg'
	    	 )
    	 )
	); 
}
add_action( 'customize_register', 'ivp_register_theme_customizer' );



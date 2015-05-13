<?php
add_action('wp_dashboard_setup', 'ivp_custom_dashboard_widgets');

function ivp_custom_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

	wp_add_dashboard_widget(
		'ivp_theme_intro_widget',
		'Theme introduction',
		'ivp_theme_intro_widget_content'
   	);
}

function ivp_theme_intro_widget_content() {
   echo 'Hej med dig';
}
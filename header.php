<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till the content area
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6 lte7 lte8 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7 lte7 lte8 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8 lte8 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 * We filter the output of wp_title() a bit -- see
			 * boilerplate_filter_wp_title() in functions.php.
			 */
			wp_title( '|', true, 'right' );
		?></title>
	  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
			<script src="<?php echo get_stylesheet_directory_uri() ?>/inc/assets/js/html5shiv.js"></script>
		<![endif]-->
<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
		<header class="site-header">
			<div class="container">
				<a href="<?php echo home_url(); ?>" title="Til forsiden" class="site-logo">
					<img src="<?php echo get_theme_mod( 'ivp_logo_file',  get_template_directory_uri().'/img/ivp-logo.png' ); ?>" alt="">
				</a>
				<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'ivp' ); ?>" class="visuallyhidden"><?php _e( 'Skip to content', 'ivp' ); ?></a>
				<nav role="navigation" class="site-nav">
					<?php wp_nav_menu( array('menu' => 'primary', 'container' => 'false' )); ?>
				</nav>
			</div>
		</header>
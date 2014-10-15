<?php

if ( ! function_exists( 'boilerplate_widgets_init' ) ) :
	/**
	 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
	 *
	 * To override boilerplate_widgets_init() in a child theme, remove the action hook and add your own
	 * function tied to the init hook.
	 *
	 * @since 1.0
	 * @uses register_sidebar
	 */
	function boilerplate_widgets_init() {
		// Area 2, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Primary Widget Area', 'ivp' ),
			'id' => 'primary-widget-area',
			'description' => __( 'Blog post sidebar widget', 'ivp' ),
			'before_widget' => '<div id="%1$s" class="ivp-widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="ivp-widget-title">',
			'after_title' => '</h3>',
		) );

		// Area 3, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'First Footer Widget Area', 'ivp' ),
			'id' => 'first-footer-widget-area',
			'description' => __( 'The first footer widget area', 'ivp' ),
			'before_widget' => '<div id="%1$s" class="ivp-widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="ivp-widget-title">',
			'after_title' => '</h3>',
		) );

		// Area 4, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Second Footer Widget Area', 'ivp' ),
			'id' => 'second-footer-widget-area',
			'description' => __( 'The second footer widget area', 'ivp' ),
			'before_widget' => '<div id="%1$s" class="ivp-widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="ivp-widget-title">',
			'after_title' => '</h3>',
		) );

		// Area 5, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Third Footer Widget Area', 'ivp' ),
			'id' => 'third-footer-widget-area',
			'description' => __( 'The third footer widget area', 'ivp' ),
			'before_widget' => '<div id="%1$s" class="ivp-widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="ivp-widget-title">',
			'after_title' => '</h3>',
		) );

		// Area 6, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Fourth Footer Widget Area', 'ivp' ),
			'id' => 'fourth-footer-widget-area',
			'description' => __( 'The fourth footer widget area', 'ivp' ),
			'before_widget' => '<div id="%1$s" class="ivp-widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="ivp-widget-title">',
			'after_title' => '</h3>',
		) );

	}
endif;
add_action( 'widgets_init', 'boilerplate_widgets_init' );
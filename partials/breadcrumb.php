<?php

/*
 * Breacrump
 * 
 * @since Boilerplate 1.0
 */


function simple_breadcrumb() {
    global $post;
    // Change the separator to what ever you need e.g. / or >
	$separator = " <span class='breadcrump-divider'>»</span> "; 
	
    echo '<div class="breadcrumb">';
	if (!is_front_page()) {
		echo '<a href="';
		echo home_url();
		echo '">';
		echo __('Home' ,'ivp');
		echo "</a> ".$separator;
		if ( is_category() || is_single() ) {
			the_category(', ');
			if ( is_single() ) {
				echo $separator;
				the_title();
			}
		} elseif ( is_page() && $post->post_parent ) {
			$home = get_page(get_option('page_on_front'));
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<a href="';
					echo get_permalink($post->ancestors[$i]); 
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a>".$separator;
				}
			}
			echo the_title();
		} elseif (is_page()) {
			echo the_title();
		} elseif (is_404()) {
			echo "404";
		}
	} else {
		bloginfo('name');
	}
	echo '</div>';
}
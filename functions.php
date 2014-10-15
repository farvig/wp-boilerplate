<?php

/*
 * Constants
 */

define( 'THEMEROOT', get_stylesheet_directory_uri() );
define ('IMAGES' , THEMEROOT . '/img' );


if( !isset( $content_width ) ){
	$content_width = 1280;
}


/*
 * Boilerplate setup function
 */

if( !function_exists( 'ivp_boilerplate_setup ') ){
	function ivp_boilerplate_setup(){
		/*
		 * Setting up localization
		 */
		load_theme_textdomain('ivp', get_template_directory() . '/lang');

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// add thumbnail support
		add_theme_support( 'post-thumbnails' );

		
		// Menus
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => __( 'Site navigation', 'ivp' ),
			'secondary' => __( 'Secondary menu for widgets', 'ivp' ),
		) );


	}

	add_action( 'after_setup_theme', 'ivp_boilerplate_setup');
}


/*
 * Include our scripts 
 */

function ivp_register_scripts() {
	//wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 
		'ivp-plugins',
		get_template_directory_uri() . '/inc/assets/js/plugins.js',
		array('jquery'),
		'1.0.0',
		true
	);
	wp_enqueue_script( 
		'moderniizr',
		get_template_directory_uri() . '/inc/assets/js/modernizr-2.6.2.min.js',
		array(),
		'2.6.2',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ivp_register_scripts' );


/*
 * Including files
 */
global $ivp_theme_options;

include('inc/admin/theme-settings.php');
$ivp_theme_options = ivp_theme_get_settings();
include('inc/admin/admin-pages.php');
include('inc/admin/theme-customization.php');
include('inc/admin/theme-update-checker.php');

include('inc/shortcodes.php');

// Our widgets
include('inc/widgetareas.php');
include('inc/widgets/ivp_social.php');

// Our metaboxes
// Meta box creator class
include('inc/lib/meta-box-class/meta-box-class.php');

include('inc/metaboxes/ivp-hide-subnavigation.php');
include('inc/metaboxes/rich-tax-description-editor/main.php');
include('inc/metaboxes/ivp-frontpage-metaboxes.php');


// Check for updates
$ivp_theme_update_checker = new ThemeUpdateChecker(
    'amsterdam',
    'http://ivaerksaetterpress.dk/themes/amsterdam/info.json'
);

if ( ! function_exists( 'boilerplate_remove_recent_comments_style' ) ) :
	/**
	 * Removes the default styles that are packaged with the Recent Comments widget.
	 *
	 * To override this in a child theme, remove the filter and optionally add your own
	 * function tied to the widgets_init action hook.
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
endif;
add_action( 'widgets_init', 'boilerplate_remove_recent_comments_style' );


if ( ! function_exists( 'boilerplate_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own boilerplate_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="clearfix">
				<div class="comment-author-image module-1-4">
						<?php  echo get_avatar( $comment, 40 ); ?>
				</div>
				
				<div class="comment-content clearfix module-3-4">

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'ivp' ); ?></em>
						<br />
					<?php endif; ?>

					<h4 class="comment-author-name">
						<?php printf( __( '%s', 'ivp' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</h4>

					<div class="comment-date">
						<?php
							/* translators: 1: date, 2: time */
							$date = get_comment_date('d,M,Y');
							$date = explode(",", $date);
							$date = '<span class="comment-day">'.$date[0].'.</span><span class="comment-month">'.$date[1].'</span><span class="comment-year">'.$date[2].'</span>';
							$time = '<time class="comment-time">'.get_comment_time().'</time>';
							printf( __( '%1$s %2$s', 'ivp' ), $time, $date ); ?>
					</div>
					<div class="comment-text"><?php comment_text(); ?></div>
				</div>
				<div class="post-comment-reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-##  -->
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'ivp' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'ivp'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;

// This theme styles the visual editor to resemble the theme style.
//add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url() ) );


if ( ! function_exists( 'boilerplate_filter_wp_title' ) ) :
	/**
	 * Makes some changes to the <title> tag, by filtering the output of wp_title().
	 *
	 * If we have a site description and we're viewing the home page or a blog posts
	 * page (when using a static front page), then we will add the site description.
	 *
	 * If we're viewing a search result, then we're going to recreate the title entirely.
	 * We're going to add page numbers to all titles as well, to the middle of a search
	 * result title and the end of all other titles.
	 *
	 * The site title also gets added to all titles.
	 *
	 * @since Twenty Ten 1.0
	 *
	 * @param string $title Title generated by wp_title()
	 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
	 * 	vertical bar, "|", as a separator in header.php.
	 * @return string The new title, ready for the <title> tag.
	 */
	function boilerplate_filter_wp_title( $title, $separator ) {
		// Don't affect wp_title() calls in feeds.
		if ( is_feed() )
			return $title;

		// The $paged global variable contains the page number of a listing of posts.
		// The $page global variable contains the page number of a single post that is paged.
		// We'll display whichever one applies, if we're not looking at the first page.
		global $paged, $page;

		if ( is_search() ) {
			// If we're a search, let's start over:
			$title = sprintf( __( 'Search results for %s', 'boilerplate' ), '"' . get_search_query() . '"' );
			// Add a page number if we're on page 2 or more:
			if ( $paged >= 2 )
				$title .= " $separator " . sprintf( __( 'Page %s', 'boilerplate' ), $paged );
			// Add the site name to the end:
			$title .= " $separator " . get_bloginfo( 'name', 'display' );
			// We're done. Let's send the new title back to wp_title():
			return $title;
		}

		// Otherwise, let's start by adding the site name to the end:
		$title .= get_bloginfo( 'name', 'display' );

		// If we have a site description and we're on the home/front page, add the description:
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $separator " . $site_description;

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'boilerplate' ), max( $paged, $page ) );

		// Return the new title to wp_title():
		return $title;
	}
endif;
add_filter( 'wp_title', 'boilerplate_filter_wp_title', 10, 2 );

if ( ! function_exists( 'boilerplate_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post—date/time and author.
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_posted_on() {
		// BP: slight modification to Twenty Ten function, converting single permalink to multi-archival link
		// Y = 2012
		// F = September
		// m = 01–12
		// j = 1–31
		// d = 01–31
		printf( __( '<span class="%1$s">Posted on</span> <span class="entry-date">%2$s %3$s, %4$s</span> <span class="meta-sep">by</span> %5$s', 'boilerplate' ),
			// %1$s = container class
			'meta-prep meta-prep-author',
			// %2$s = month: /yyyy/mm/
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				home_url() . '/' . get_the_date( 'Y' ) . '/' . get_the_date( 'm' ) . '/',
				esc_attr( 'View Archives for ' . get_the_date( 'F' ) . ' ' . get_the_date( 'Y' ) ),
				get_the_date( 'F' )
			),
			// %3$s = day: /yyyy/mm/dd/
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				home_url() . '/' . get_the_date( 'Y' ) . '/' . get_the_date( 'm' ) . '/' . get_the_date( 'd' ) . '/',
				esc_attr( 'View Archives for ' . get_the_date( 'F' ) . ' ' . get_the_date( 'j' ) . ' ' . get_the_date( 'Y' ) ),
				get_the_date( 'j' )
			),
			// %4$s = year: /yyyy/
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				home_url() . '/' . get_the_date( 'Y' ) . '/',
				esc_attr( 'View Archives for ' . get_the_date( 'Y' ) ),
				get_the_date( 'Y' )
			),
			// %5$s = author vcard
			sprintf( '<span class="entry-author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'ivp' ), get_the_author() ),
				get_the_author()
			)
		);
	}
endif;

if ( ! function_exists( 'boilerplate_posted_in' ) ) :
	/**
	 * Prints HTML with meta information for the current post (category, tags and permalink).
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_posted_in() {
		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			$posted_in = __( 'This entry was posted in %1$s and tagged %2$s.', 'ivp' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( 'This entry was posted in %1$s.', 'ivp' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;
/*	End original TwentyTen functions (from Starkers Theme, renamed into this namespace) */

/*	Begin Boilerplate */
	// Add Admin
	//require_once(get_template_directory() . '/boilerplate-admin/admin-menu.php');

	// remove version info from head and feeds (http://digwp.com/2009/07/remove-wordpress-version-number/)
	if ( ! function_exists( 'boilerplate_complete_version_removal' ) ) :
		function boilerplate_complete_version_removal() {
			return '';
		}
	endif;
	add_filter('the_generator', 'boilerplate_complete_version_removal');



/*	End Boilerplate */

if ( ! function_exists( 'ivp_boilerplate_page_menu_args' ) ) :
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * To override this in a child theme, remove the filter and optionally add
	 * your own function tied to the wp_page_menu_args filter hook.
	 *
	 * @since Twenty Ten 1.0
	 */
	function ivp_boilerplate_page_menu_args( $args ) {
		$args['show_home'] = false;
		return $args;
	}
endif;
add_filter( 'wp_page_menu_args', 'ivp_boilerplate_page_menu_args' );




/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
	'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
) );


// This theme uses its own gallery styles.
add_filter( 'use_default_gallery_style', '__return_false' );


/*
 * Add Google webmaster tools, if entered
 */

function ivp_add_google_webmaster_meta_tag(){
	global $ivp_theme_options;

	if($ivp_theme_options['webmaster_tools']){
		echo $ivp_theme_options['webmaster_tools'];
	}
}
add_action('wp_head', 'ivp_add_google_webmaster_meta_tag');


/* ------------------------------------------------------------------*/
/* ADD PRETTYPHOTO REL ATTRIBUTE FOR LIGHTBOX */
/* ------------------------------------------------------------------*/
 
add_filter('wp_get_attachment_link', 'ivp_add_rel_attribute');
function ivp_add_rel_attribute($link) {
	global $post;
	return str_replace('<a href', '<a rel="gallery" href', $link);
}


function ivp_customizer_css() {
    ?>
    <style type="text/css">
        .page-header { background-image: url(<?php echo get_theme_mod( 'ivp_page_title_bg' ); ?>); }
    </style>
    <?php
}
add_action( 'wp_head', 'ivp_customizer_css' );

add_action( 'widgets_init', 'boilerplate_remove_recent_comments_style' );
<?php
/*
 * IVP social links widget
 * Takes the link entered in the IVP settings panel
 *
 */
class wpb_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'ivp_social', 

		// Widget name will appear in UI
		__('IværksætterPress Social links', 'ivp'), 

		// Widget description
		array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'ivp' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];

	// This is where we run the code and display the output
	global $ivp_theme_options;
	echo '<ul>';
	if( $ivp_theme_options['facebook'] != ''){
		echo '<li><a href="' . $ivp_theme_options['facebook'] . '" title="' . __('Meet us on facebook','ivp') . '" class="ivp-social-link ivp-social-link-facebook"><span class="icon-facebook"></span>Facebook</a></li>';
	}
	if( $ivp_theme_options['twitter'] != ''){
		echo '<li><a href="' . $ivp_theme_options['twitter'] . '" title="' . __('Meet us on twitter','ivp') . '" class="ivp-social-link ivp-social-link-twitter"><span class="icon-twitter"></span>Twitter</a></li>';
	}
	if( $ivp_theme_options['youtube'] != ''){
		echo '<li><a href="' . $ivp_theme_options['youtube'] . '" title="' . __('Meet us on youtube','ivp') . '" class="ivp-social-link ivp-social-link-youtube"><span class="icon-youtube"></span>Youtube</a></li>';
	}
	if( $ivp_theme_options['pinterest'] != ''){
		echo '<li><a href="' . $ivp_theme_options['pinterest'] . '" title="' . __('Meet us on pinterest','ivp') . '" class="ivp-social-link ivp-social-link-pinterest"><span class="icon-pinterest"></span>Pinterest</a></li>';
	}
	if( $ivp_theme_options['linkedin'] != ''){
		echo '<li><a href="' . $ivp_theme_options['linkedin'] . '" title="' . __('Meet us on linkedin','ivp') . '" class="ivp-social-link ivp-social-link-linkedin"><span class="icon-linkedin"></span>LinkedIn</a></li>';
	}
	echo '</ul>';
	echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'New title', 'ivp' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
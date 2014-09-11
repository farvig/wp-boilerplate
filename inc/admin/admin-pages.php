<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates the admin page
 *
 * @since 1.0
 * @return void
 */


function register_theme_settings_page(){
    add_menu_page(
      __('Theme settings', 'ivp'),   // The text to be displayed in the title tags of the page when the menu is selected
      __('Theme settings', 'ivp'),   // The on-screen name text for the menu
      'manage_options',     		 // The capability required for this menu to be displayed to the user.
      'ivp-settings',                // The slug name to refer to this menu by (should be unique for this menu).
      'theme_settings_front_page',   // The function that displays the page content for the menu page.
       get_stylesheet_directory_uri('stylesheet_directory') . "/img/ivp-theme-settings-icon.png"
      ); 
}
add_action( 'admin_menu', 'register_theme_settings_page' );

function theme_settings_front_page(){
	ob_start();
	global $ivp_theme_options;

	$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], ivp_theme_get_settings_tabs() ) ? $_GET[ 'tab' ] : 'social';

	ob_start();
	?>
	<div class="wrap wpppw-container">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach( ivp_theme_get_settings_tabs() as $tab_id => $tab_name ) {

				$tab_url = add_query_arg( array(
					'settings-updated' => false,
					'tab' => $tab_id
				) );

				$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

				echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
					echo esc_html( $tab_name );
				echo '</a>';
			}
			?>
		</h2>
		<div id="tab_container">
			<form method="post" action="options.php">
				<table class="form-table">
				<?php
				settings_fields( 'ivp_theme_settings' );
				do_settings_fields( 'ivp_theme_settings_' . $active_tab, 'ivp_theme_settings_' . $active_tab );
				?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div><!-- #tab_container-->
	</div><!-- .wrap -->
  
<?php  echo ob_get_clean();
}

function register_settings_help_page() {
  add_submenu_page(
         'ivp-settings',			 // The slug name for the parent menu 
         __('Theme help', 'ivp'),    // The text to be displayed in the title tags of the page when the menu is selected
         __('Theme help', 'ivp'),    // The text to be used for the menu
        'manage_options',      		 // The capability required for this menu to be displayed to the user.
        'ivp-help',     			 // The slug name to refer to this menu by (should be unique for this menu).
        'ivp_settings_help_page' 	 // The function that displays the page content for the menu page.
    );
}
add_action('admin_menu', 'register_settings_help_page');

function ivp_settings_help_page(){
  ob_start(); ?>
	<div class="wrap">
		<h2><?php  _e('Theme help', 'ivp'); ?></h2>
		<div class="postbox metabox-holder">
			<h3><span><?php _e('Finding Documentation and About this Help Page','ivp'); ?></span></h3>
			<div class="inside">
				<div class="module-1-2">
					<h4>Social</h4>
					<p>Her kan du indsætte links til dine forskellige sociale mediesider. Du kan vises listen 
						med disse links via widget "IVP sociale links".</p>
						<p>Her kan du også vælge at skjule de deleknapper, der kommer indbygget med temaet, hvis du
							hellere vil bruge andre plugins.</p>
				</div>
				<div class="module-1-2">
					<h4>Google</h4>
					<p>Hvis du har oprette en google Webmaster tools konto kan du kopiere meta-tag'et ind, som du finder på din W
					Webmaster konto.</p>
					<p>Det samme gælder for Google Analytics. Google analytics vil kun blive brugt, hvis den besøgende
						har accepteret brugen deraf via "Accepter cookies"-boksen, se næste afsnit.</p>
				</div>
				<div class="module-1-2">
					<h4>Cookies</h4>
				</div>
			</div>
		</div>
	</div> 
<?php  echo ob_get_clean();
}
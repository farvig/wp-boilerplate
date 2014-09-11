<?php
/**
 * Get Settings
 *
 * Retrieves all plugin settings
 *
 * @since 1.0
 * @return array EDD settings
 */
function ivp_theme_get_settings() {

  $settings = get_option( 'ivp_theme_settings' );
  if( empty( $settings ) ) {
    // Update old settings with new single option
    $general_settings = is_array( get_option( 'ivp_theme_settings_general' ) )    ? get_option( 'ivp_theme_settings_general' ) : array();
    
    $settings = array_merge( $general_settings);

    update_option( 'ivp_theme_settings', $settings );

  } 
  return $settings;
}


/**
 * Add all settings sections and fields
 *
 * @since 1.0
 * @return void
*/
function ivp_theme_register_settings() {

  if ( false == get_option( 'ivp_theme_settings' ) ) {
    add_option( 'ivp_theme_settings' );
  }

  foreach( ivp_theme_get_registered_settings() as $tab => $settings ) {

    
    add_settings_section(
      'ivp_theme_settings_' . $tab,
      __return_null(),
      '__return_false',
      'ivp_theme_settings_' . $tab
    );

    foreach ( $settings as $option ) {
      $name = isset( $option['name'] ) ? $option['name'] : '';

      add_settings_field(
        'ivp_theme_settings[' . $option['id'] . ']',
        $name,
        function_exists( 'ivp_theme_' . $option['type'] . '_callback' ) ? 'ivp_theme_' . $option['type'] . '_callback' : 'ivp_theme_missing_callback',
        'ivp_theme_settings_' . $tab,
        'ivp_theme_settings_' . $tab,
        array(
          'id'      => isset( $option['id'] ) ? $option['id'] : null,
          'desc'    => ! empty( $option['desc'] ) ? $option['desc'] : '',
          'name'    => isset( $option['name'] ) ? $option['name'] : null,
          'section' => $tab,
          'size'    => isset( $option['size'] ) ? $option['size'] : null,
          'options' => isset( $option['options'] ) ? $option['options'] : '',
          'std'     => isset( $option['std'] ) ? $option['std'] : ''
        )
      );
    }

  }
  // Creates our settings in the options table
  register_setting( 'ivp_theme_settings', 'ivp_theme_settings', 'ivp_theme_settings_sanitize' );

}
add_action('admin_init', 'ivp_theme_register_settings');

function ivp_theme_get_registered_settings() {

  /*
   * Theme settings, filters are provided for each settings
   * section to allow extensions and other plugins to add their own settings
   */
  $ivp_theme_settings = array(
    /** Social Settings */
    'social' => apply_filters( 'ivp_theme_settings_social',
      array(
        'Facebook'=> array(
          'id'    => 'facebook',
          'name'  => __( 'Facebook page', 'ivp' ),
          'desc'  => __( 'Link to your facebook page', 'ivp' ),
          'type'  => 'text',
        ),
        'twitter' => array(
          'id'    => 'twitter',
          'name'  => __( 'Twitter page', 'ivp' ),
          'desc'  => __( 'Link to your Twitter page', 'ivp' ),
          'type'  => 'text',
        ),
        'youtube' => array(
          'id'    => 'youtube',
          'name'  => __( 'Youtube page', 'ivp' ),
          'desc'  => __( 'Link to your Youtube page', 'ivp' ),
          'type'  => 'text',
        ),
        'pinterest' => array(
          'id'    => 'pinterest',
          'name'  => __( 'Pinterest page', 'ivp' ),
          'desc'  => __( 'Link to your Pinterest page', 'ivp' ),
          'type'  => 'text',
        ),
        'linkedin' => array(
          'id'    => 'linkedin',
          'name'  => __( 'LinkedIn page', 'ivp' ),
          'desc'  => __( 'Link to your LinkedIn page', 'ivp' ),
          'type'  => 'text',
        ),
        'hide_sharing' => array(
          'id'    => 'hide_sharing',
          'name'  => __( 'Hide Sharing', 'ivp' ),
          'desc'  => __( 'Hide sharing buttons on posts and pages. You can hide these and add others via plugins.', 'ivp' ),
          'type'  => 'checkbox'
        ),
      )
    ),
    'google' => apply_filters( 'ivp_theme_settings_google',
      array(
        'Webmaster_tools' => array(
          'id'    => 'webmaster_tools',
          'name'  => __( 'Webmaster tools', 'ivp' ),
          'desc'  => __( 'Link to your Webmaster tools. See the theme help section for how to set it all up.', 'ivp' ),
          'type'  => 'text',
        ),
        'google_analytics' => array(
          'id'    => 'google_analytics',
          'name'  => __( 'Analytics Script', 'ivp' ),
          'desc'  => __( 'Paste in your Google Analytics script', 'ivp' ),
          'type'  => 'textarea',
        )
        
      )
    ),
    'cookiebox' => apply_filters( 'ivp_theme_settings_cookiebox',
      array(
        'show_cookiebox' => array(
          'id'    => 'show_cookiebox',
          'name'  => __( 'Show Cookie box', 'ivp' ),
          'desc'  => __( 'Check to show the accept cookies box. In the EU is the needed by law if you use any kind of tracking.', 'ivp' ),
          'type'  => 'checkbox',
        ),
        'cookiebox_messege' => array(
          'id'    => 'cookiebox_messege',
          'name'  => __( 'Text for the cookie box', 'ivp' ),
          'desc'  => __( 'Write your text for the cookie box', 'ivp' ),
          'type'  => 'rich_editor',
          'std'   => __('We uses cookies. We uses cookies for statistics recording the use of our website. By continuing to use this website, you consent to our use of cookies. If you do not wish to enable cookies, please see our guide on how to disable cookies from the site.','ivp')
        )
      )
    ),

  );
  return $ivp_theme_settings;
}

function ivp_theme_settings_sanitize( $input = array() ) {
  global $ivp_theme_options;

  if ( empty( $_POST['_wp_http_referer'] ) ) {
    return $input;
  }

  parse_str( $_POST['_wp_http_referer'], $referrer );

  $settings = ivp_theme_get_registered_settings();
  $tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

  $input = $input ? $input : array();
  $input = apply_filters( 'ivp_theme_settings_' . $tab . '_sanitize', $input );
  // Loop through each setting being saved and pass it through a sanitization filter
  foreach ( $input as $key => $value ) {

    // Get the setting type (checkbox, select, etc)
    $type = isset( $settings[$tab][$key]['type'] ) ? $settings[$tab][$key]['type'] : false;

    if ( $type ) {
      // Field type specific filter
      $input[$key] = apply_filters( 'ivp_theme_settings_sanitize_' . $type, $value, $key );
    }

    // General filter
    $input[$key] = apply_filters( 'ivp_theme_settings_sanitize', $value, $key );
  }

  // Loop through the whitelist and unset any that are empty for the tab being saved
  if ( ! empty( $settings[$tab] ) ) {
    foreach ( $settings[$tab] as $key => $value ) {

      // settings used to have numeric keys, now they have keys that match the option ID. This ensures both methods work
      if ( is_numeric( $key ) ) {
        $key = $value['id'];
      }

      if ( empty( $input[$key] ) ) {
        unset( $ivp_theme_options[$key] );
      }

    }
  }

  // Merge our new settings with the existing

  $output = array_merge( $ivp_theme_options, $input );

  add_settings_error( 'paywall-notices', '', __( 'Settings updated.', 'ivp' ), 'updated' );

  return $output;
}

function ivp_theme_sanitize_text_field( $input ) {
  return trim( $input );
}
add_filter( 'ivp_theme_settings_sanitize_text', 'ivp_theme_sanitize_text_field' );


function ivp_theme_header_callback( $args ) {
  echo '<hr/>';
}
/**
 * Checkbox Callback
 *
 * Renders checkboxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $paywalloptions Array of all the IVP Theme Options
 * @return void
 */

function ivp_theme_checkbox_callback( $args ) {
  global $ivp_theme_options;

  $checked = isset($ivp_theme_options[$args['id']]) ? checked(1, $ivp_theme_options[$args['id']], false) : '';
  
  $html = '<input type="checkbox" id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']" value="1" ' . $checked . '/>';
  $html .= '<label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}

/**
 * Multicheck Callback
 *
 * Renders multiple checkboxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_multicheck_callback( $args ) {
  global $ivp_theme_options;

  if ( ! empty( $args['options'] ) ) {
    foreach( $args['options'] as $key => $option ):
      if( isset( $ivp_theme_options[$args['id']][$key] ) ) { $enabled = $option; } else { $enabled = NULL; }
      echo '<input name="ivp_theme_settings[' . $args['id'] . '][' . $key . ']" id="ivp_theme_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
      echo '<label for="ivp_theme_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
    endforeach;
    echo '<p class="description">' . $args['desc'] . '</p>';
  }
}

/**
 * Radio Callback
 *
 * Renders radio boxes.
 *
 * @since 1.3.3
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_radio_callback( $args ) {
  global $ivp_theme_options;

  foreach ( $args['options'] as $key => $option ) :
    $checked = false;

    if ( isset( $ivp_theme_options[ $args['id'] ] ) && $ivp_theme_options[ $args['id'] ] == $key )
      $checked = true;
    elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( $ivp_theme_options[ $args['id'] ] ) )
      $checked = true;

    echo '<input name="ivp_theme_settings[' . $args['id'] . ']"" id="ivp_theme_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
    echo '<label for="ivp_theme_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
  endforeach;

  echo '<p class="description">' . $args['desc'] . '</p>';
}
/**
 * Text Callback
 *
 * Renders text fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_text_callback( $args ) {
  global $ivp_theme_options;

  if ( isset( $ivp_theme_options[ $args['id'] ] ) )
    $value = $ivp_theme_options[ $args['id'] ];
  else
    $value = isset( $args['std'] ) ? $args['std'] : '';

  $size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
  $html = '<input type="text" class="' . $size . '-text" id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
  $html .= '<label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}

/**
 * Number Callback
 *
 * Renders number fields.
 *
 * @since 1.9
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_number_callback( $args ) {
  global $ivp_theme_options;

  if ( isset( $ivp_theme_options[ $args['id'] ] ) )
    $value = $ivp_theme_options[ $args['id'] ];
  else
    $value = isset( $args['std'] ) ? $args['std'] : '';

  $max  = isset( $args['max'] ) ? $args['max'] : 999999;
  $min  = isset( $args['min'] ) ? $args['min'] : 0;
  $step = isset( $args['step'] ) ? $args['step'] : 1;

  $size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
  $html = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $size . '-text" id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
  $html .= '<label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}

/**
 * Textarea Callback
 *
 * Renders textarea fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_textarea_callback( $args ) {
  global $ivp_theme_options;

  if ( isset( $ivp_theme_options[ $args['id'] ] ) )
    $value = $ivp_theme_options[ $args['id'] ];
  else
    $value = isset( $args['std'] ) ? $args['std'] : '';

  $size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
  $html = '<textarea class="large-text" cols="50" rows="5" id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
  $html .= '<label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}

/**
 * Password Callback
 *
 * Renders password fields.
 *
 * @since 1.3
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_password_callback( $args ) {
  global $ivp_theme_options;

  if ( isset( $ivp_theme_options[ $args['id'] ] ) )
    $value = $ivp_theme_options[ $args['id'] ];
  else
    $value = isset( $args['std'] ) ? $args['std'] : '';

  $size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
  $html = '<input type="password" class="' . $size . '-text" id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
  $html .= '<label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}

/**
 * Select Callback
 *
 * Renders select fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @return void
 */
function ivp_theme_select_callback($args) {
  global $ivp_theme_options;

  if ( isset( $ivp_theme_options[ $args['id'] ] ) )
    $value = $ivp_theme_options[ $args['id'] ];
  else
    $value = isset( $args['std'] ) ? $args['std'] : '';

  $html = '<select id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']"/>';

  foreach ( $args['options'] as $option => $name ) :
    $selected = selected( $option, $value, false );
    $html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
  endforeach;

  $html .= '</select>';
  $html .= '<label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}


/**
 * Rich Editor Callback
 *
 * Renders rich editor fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $ivp_theme_options Array of all the IVP Theme Options
 * @global $wp_version WordPress Version
 */
function ivp_theme_rich_editor_callback( $args ) {
  global $ivp_theme_options, $wp_version;
  if ( isset( $ivp_theme_options[ $args['id'] ] ) )
    $value = $ivp_theme_options[ $args['id'] ];
  else
    $value = isset( $args['std'] ) ? $args['std'] : '';

  if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
    ob_start();
    wp_editor( stripslashes( $value ), 'ivp_theme_settings_' . $args['id'], array( 'textarea_name' => 'ivp_theme_settings[' . $args['id'] . ']' ) );
    $html = ob_get_clean();
  } else {
    $html = '<textarea class="large-text" rows="10" id="ivp_theme_settings[' . $args['id'] . ']" name="ivp_theme_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
  }

  $html .= '<br/><label for="ivp_theme_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

  echo $html;
}


/**
 * Missing Callback
 *
 * If a function is missing for settings callbacks alert the user.
 *
 * @since 1.3.1
 * @param array $args Arguments passed by the setting
 * @return void
 */
function ivp_theme_missing_callback($args) {
  printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'ivp' ), $args['id'] );
}


/**
 * Retrieve settings tabs
 *
 * @since 1.8
 * @param array $input The field value
 * @return string $input Sanitizied value
 */
function ivp_theme_get_settings_tabs() {

  $settings = ivp_theme_get_registered_settings();

  $tabs               = array();
  $tabs['social']     = __( 'Social', 'ivp' );
  $tabs['google']     = __( 'Google', 'ivp' );
  $tabs['cookiebox']  = __( 'Cookies', 'ivp' );
  return apply_filters( 'ivp_theme_settings_tabs', $tabs );
}

<?php

add_action( 'add_meta_boxes', 'ivp_add_hide_sub_navigation' );
function ivp_add_hide_sub_navigation(){
    add_meta_box( 
		'ivp_hide_sub_navigation',
		__('Hide left navigation','ivp'),
		'ivp_hide_sub_navigation_cb',
		'page',
		'side',
		'default'
	);
}

function ivp_hide_sub_navigation_cb(){
	// $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $check = isset( $values['ivp_hide_subnavigation_check'][0] ) ? esc_attr( $values['ivp_hide_subnavigation_check'][0] ) : '';
     
    wp_nonce_field( 'ivp_hide_subnavigation_nonce', 'meta_box_nonce' );
    ?>
    <p>
        <input type="checkbox" id="ivp_hide_subnavigation_check" name="ivp_hide_subnavigation_check" <?php if( $check == true ) { ?>checked="checked"<?php } ?> />
        <label for="ivp_hide_subnavigation_check"><?php _e('Check to hide sub navigation','ivp'); ?></label>
    </p>
    <?php 
}


add_action( 'save_post', 'ivp_hide_subnavigation_save' );
function ivp_hide_subnavigation_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'ivp_hide_subnavigation_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
         
    $chk = isset( $_POST['ivp_hide_subnavigation_check'] ) && $_POST['ivp_hide_subnavigation_check'] ? true : false;
    update_post_meta( $post_id, 'ivp_hide_subnavigation_check', $chk );
}
<?php

/*
 * Share buttons
 * 
 * @since Boilerplate 1.0
 */

function ivp_display_share_buttons(){
	// Get out themes option
	global $ivp_theme_options;

	if( !$ivp_theme_options['hide_sharing'] ){

		// Use the share links for social media
		?>
		<div class="ivp-share-bar">
            <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" title="Share on facebook" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="ivp_share-btn ivp_facebook-btn"><span class="icon-facebook"></span></a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_permalink() ); ?>&related=indiemondo" title="Share on Twitter" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="ivp_share-btn ivp_twitter-btn"><span class="icon-twitter"></span></a>
            <a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>" title="Share on google plus" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="ivp_share-btn ivp_googleplus-btn"><span class="icon-googleplus"></span></a>
            <a href="http://www.pinterest.com/pin/create/link/?url=<?php echo urlencode( get_permalink() ); ?>&media=<?php echo urlencode( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ); ?>&description=<?php echo strip_tags( get_the_excerpt() ); ?>" title="Share on Pinterest" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="ivp_share-btn ivp_pinterest-btn"><span class="icon-pinterest"></span></a>
        </div>
		<?php
	}
}
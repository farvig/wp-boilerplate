<?php
	global $ivp_theme_options;

	if($ivp_theme_options['show_cookiebox']){
		?>
		<div class="cookie-container">
    		<a href="#" title="<?php _e('We use cookies','ivp'); ?>" class="toggle-cookie-text"></a>
    		<div class="cookie-text-container">
       			 <div class="cookie-text-inner-container">
           			 <a href="" title="<?php _e('close','ivp'); ?>" class="cookie-close-btn">x</a>
            		<div class="cookie-box-content">
	                	<?php echo $ivp_theme_options['cookiebox_messege']; ?>
			            <footer class="cookie-box-footer clearfix">
			                <a href="#" title="<?php _e('Accept','ivp'); ?>" class="accept-cookies btn"><?php _e('Accept','ivp'); ?></a>
			                <a href="#" title="<?php _e('Decline','ivp'); ?>" class="decline-cookies btn"><?php _e('Decline','ivp'); ?></a>
			            </footer>
        			</div>
    			</div>
			</div>
		</div>
		<?php
		if (isset($_COOKIE["ivpCookieScript"])){
			$cookiescript = $_COOKIE["ivpCookieScript"];
			if( (string) $cookiescript === "accepted" ){
				echo $ivp_theme_options['google_analytics'];
			}
		}
	}

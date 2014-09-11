<?php

/*
 * Shortcodes for the IVP Framework 
 */

//[foobar]
function foobar_func(){
	return "foo and bar";
}
add_shortcode( 'foobar', 'foobar_func' );
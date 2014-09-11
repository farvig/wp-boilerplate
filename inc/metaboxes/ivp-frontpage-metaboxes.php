<?php
$prefix = 'ivp_';
/* 
* configure your meta box
*/
$config = array(
'id'             => 'frontpage_banner',     // meta box id, unique per meta box
'title'          => 'Frontpage Banner',     // meta box title
'pages'          => array('page'),        	// post types, accept custom post types as well, default is array('post'); optional
'context'        => 'side',                 // where the meta box appear: normal (default), advanced, side; optional
'priority'       => 'high',                 // order of meta box: high (default), low; optional
'fields'         => array(),                // list of meta fields (can be added by field arrays)
'local_images'   => false,                  // use local or hosted images (meta box images for add/remove)
'use_with_theme' => true                    // change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);


/*
* Initiate your meta box
*/
$my_meta =  new AT_Meta_Box($config);

/*
* Add fields to your meta box
*/

//text field
$my_meta->addText($prefix.'frontpage_banner_title',array('name'=> __('Title','ivp') ));
//select field
$my_meta->addPosts($prefix.'frontpage_banner_lnk',array('post_type' => 'page'),array('name'=> __('Link to page','ivp') ));
//Image field
$my_meta->addImage($prefix.'frontpage_banner_image',array('name'=> __('Banner image','ivp') ));
/*
* Don't Forget to Close up the meta box Declaration 
*/
//Finish Meta Box Declaration 
$my_meta->Finish();
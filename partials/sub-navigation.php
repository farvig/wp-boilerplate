<?php
// Hide sub nav if set in theme settings
if ( !get_post_meta( $post->ID, 'ivp_hide_subnavigation_check' , true) ){
?>
    <nav class="sub-nav">
        <ul>
            <?php 
            // Sub nav
            $parent = array_reverse( get_post_ancestors($post->ID));
            if(array_key_exists(0, $parent)){
                $first_parent = get_page($parent[0]);
            }else{
                 $first_parent = $post;
            }
            wp_list_pages("title_li=&child_of=".$first_parent->ID); 
            
            ?>
        </ul>
    </nav>
<?php } ?>
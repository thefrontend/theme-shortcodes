<?php
add_shortcode('bloginfo','shortcode_bloginfo');

/**
* bloginfo		
*
* 
*/
function shortcode_bloginfo( $atts ) {
    $atts = shortcode_atts(array(
        'key' => '',
    ),$atts );
    
    return get_bloginfo($atts['key']);
} // function


?>
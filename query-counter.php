<?php
/**
 * Displays query count and load time if the current user can edit themes.  
 * Original function by Justin Tadlock/Hybrid theme
 * @return string  
 */
function theme_shortcodes_query_counter() {
    if ( current_user_can( 'edit_themes' ) )
        $out = sprintf( __( 'This page loaded in %1$s seconds with %2$s database queries.', $domian ), timer_stop( 0, 3 ), get_num_queries() );
    return $out;
}
add_shortcode('query-counter', 'theme_shortcodes_query_counter');
?>

<?php
/**
 * Shortcode to display a link back to the site. 
 * functionality provided by Justin Tadlock/Hybrid theme
 * @return type 
 */
function theme_shortcodes_site_link() {
    return '<a class="site-link" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home"><span>' . get_bloginfo( 'name' ) . '</span></a>';
}
add_shortcode('site-link', 'theme_shortcodes_site_link');
?>

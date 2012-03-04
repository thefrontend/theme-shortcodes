<?php
/**
 * Shortcode to display a link to the theme page. 
 * Original function by Justin Tadlock/Hybrid theme
 * @return type  
 */
function shortcode_theme_link() {
    $data = get_theme_data( trailingslashit( TEMPLATEPATH ) . 'style.css' );
    return '<a class="theme-link" href="' . esc_url( $data['URI'] ) . '" title="' . esc_attr( $data['Name'] ) . '"><span>' . esc_attr( $data['Name'] ) . '</span></a>';
}
add_shortcode('theme-link', 'theme_shortcodes_theme_link');
?>

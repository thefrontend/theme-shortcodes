<?php
// Set the script flag to false for the adsense shortcode
$theme_shortcodes['adsense'] = false;

/**
* Register the google adsense javascript with wordpress		
* @return void
*/
function theme_shortcodes_adsense_register_scripts() {
    wp_register_script('adsense','http://pagead2.googlesyndication.com/pagead/show_ads.js');	
}

/**
 * Adsense shortcode callback
 * @param array $atts
 * @return string  
 */
function theme_shortcodes_adsense( $atts ) {
    global $theme_shortcodes;
    
    // Set the scrip flag to true as the shortcode has been used
    $theme_shortcodes['adsense'] = true;
    
    // Extract and apply the defaults
    extract(shortcode_atts(array(
        'ad_client' => '',
        'ad_slot' => '',
        'width' => '',
        'height' => '',
    ), $atts));

    $return .= '<script type="text/javascript"><!--'. "\n";
    $return .= 'google_ad_client = "' . $ad_client . '"'. "\n";
    $return .= 'google_ad_slot = "' . $ad_slot . '"'. "\n";
    $return .= 'google_ad_width = ' . $width . ''. "\n";
    $return .= 'google_ad_height = ' . $height . ''. "\n";
    $return .= '//-->'. "\n";
    $return .= '</script>'. "\n";

    return $return;
}

/**
 * Include the google adsense javascript only when the shortcode is used on the page
 * @return void 
 */
function theme_shortcodes_adsense_print_scripts() {
    global $theme_shortcodes;
    if (!$theme_shortcodes['adsense']) { return; }
    wp_print_scripts('adsense'); 
}

// Register the shortcode with wordpress
add_shortcode('adsense','theme_shortcodes_adsense');


?>
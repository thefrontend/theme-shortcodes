<?php

	add_shortcode('child-link','shortcode_child_link');
	/**
	* child-link 					
	*
	* by Justin Tadlock/Hybrid theme
	*/	
	function shortcode_child_link() {
		$data = get_theme_data( trailingslashit( STYLESHEETPATH ) . 'style.css' );
		return '<a class="child-link" href="' . esc_url( $data['URI'] ) . '" title="' . esc_attr( $data['Name'] ) . '"><span class="child-link-text">' . esc_attr( $data['Name'] ) . '</span></a>';
	} // function

?>
<?php

	add_shortcode('esc','shortcode_esc');
	/**
	* esc		
	*
	* HTML Special Chars shortcode
	*/
	function shortcode_esc( $atts, $content=null ){
			$output = htmlentities($content);
			return $output;
	} // function

?>
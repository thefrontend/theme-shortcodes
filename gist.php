<?php

	add_shortcode('gist','shortcode_gist');

	/**
	* [gist] Shortcode Callback
	*/
	function shortcode_gist($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' => null
		), $atts));

		if (!$id) {
			return;
		}
		
		$html =  '<script src="http://gist.github.com/'.trim($id).'.js"></script>';
		
		if($content != null){
			$html .= '<noscript><code class="gist"><pre>'.$content.'</pre></code></noscript>';
		}
		return $html;
	} // function
	
?>
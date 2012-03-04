<?php

	add_shortcode('jsfiddle','shortcode_jsfiddle');

	/**
	* [jsfiddle] Shortcode Callback
	*
	* Embed a jsFiddle into a webpage. 
	* Based on code by Willington Vega  http://wvega.com/
	*/
	function shortcode_jsfiddle($attrs, $content) {
		$tabs = array('result', 'js', 'css', 'html');

		extract(shortcode_atts(array(
			'url' => null,
			'height' => '300px',
			'include' => join(',', $tabs)
		), $attrs));
		
		if (!$url) {
			return;
		}
		$include = array_intersect(split(',', $include), $tabs);
		$url = trim($url, '/') . '/embedded/' . join(',', $include);

		$html = '<iframe style="width: 100%; height: ' . $height . '" src="' . $url . '"></iframe>';

		return $html;
	}
	
?>
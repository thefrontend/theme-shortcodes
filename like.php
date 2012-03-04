<?php

	add_shortcode('like','shortcode_like');


 
	/**
	* like		
	*
	* 
	*/
	function shortcode_like( $atts, $content=null ){
		// set the flag if the shortcode is used
		$this->like_flag = true;
	
		extract(shortcode_atts(array(
				'send' => 'false',
				'layout' => 'standard',
				'show_faces' => 'true',
				'width' => '400px',
				'action' => 'like',
				'font' => '',
				'colorscheme' => 'light',
				'ref' => '',
				'locale' => 'en_US',
				'appId' => '' // Put your AppId here is you have one
		), $atts));
	
		// set the global locale variable
		$this->likelocale = $locale;
		$this->likeappId = $appId;
		
    $output = <<<HTML
        <fb:like ref="$ref" href="$content" layout="$layout" colorscheme="$colorscheme" action="$action" send="$send" width="$width" show_faces="$show_faces" font="$font"></fb:like>
HTML;
 
		return $output;
	} // function

	function shortcode_like_register_scripts() {}
	
	// Add the facebook like javascript if the shortcode was used
	function shortcode_like_print_scripts() {
		wp_register_script('like','http://connect.facebook.net/' . $this->likelocale . '/all.js#appId=' . $this->likeappId . '&amp;xfbml=1');
		if ($this->like_flag) {
			wp_print_scripts('like'); 
		} else {
			return;
		}
	} // function






?>
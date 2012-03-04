<?php


	add_shortcode('gravatar','shortcode_gravatar');
	
	/**
	* [gravatar] Shortcode Callback
	*
	*
	*/
	function shortcode_gravatar( $atts ) {
		extract( shortcode_atts( array(
			'size' => '80',
			'email' => '',
			'rating' => 'X',
			'default' => '',
			'alt' => '',
			'title' => '',
			'align' => '', 
			'style' => '', 
			'class' => '', 
			'id' => '', 
			'border' => '', 
			), $atts ) );
		if ( !$email ) return '';
		
		// Supported Gravatar parameters
		$rating  = $rating ? '&amp;r=' . $rating : '';
		$default = $default ? '&amp;d=' . urlencode( $default ) : '';
		
		// Supported HTML attributes for the IMG tag
		$alt    = $alt ? ' alt="' . $alt . '"' : '';
		$title  = $title ? ' title="' . $title . '"' : '';
		$align  = $align ? ' align="' . $align . '"' : '';
		$style  = $style ? ' style="' . $style . '"' : '';
		$class  = $class ? ' class="' . $class . '"' : '';
		$id     = $id ? ' id="' . $id . '"' : '';
		$border = $border ? ' border="' . $border . '"' : '';
		
		return get_avatar( $email, $size, $default, $alt );
		// Send back the completed tag
		return '<img src="http://www.gravatar.com/avatar/' . md5( trim( strtolower( $email ) ) ) . '.jpg?s=' . $size . $rating . $default . '" width="' . $size . '" height="' . $size . '"' . $alt . $title . $align . $style . $class . $id . $border . ' />';
	}
	
	
	function shortcode_gravatar_cache($source) {
		$time = 1209600; //The time of cache(seconds)
		preg_match('/avatar\/([a-z0-9]+)\?s=(\d+)/',$source,$tmp);
		$abs = ABSPATH.'wp-content/plugins/theme-shortcodes/cache/'.$tmp[1].'.jpg';
		$url = get_bloginfo('wpurl').'/wp-content/plugins/theme-shortcodes/cache/'.$tmp[1].'.jpg';
		$default = get_bloginfo('wpurl').'/wp-content/plugins/theme-shortcodes/cache/'.'default.png';
		if (!is_file($abs)||(time()-filemtime($abs))>$time){
			copy('http://www.gravatar.com/avatar/'.$tmp[1].'?s=64&d='.$default.'&r=G',$abs);
		}
		if (filesize($abs)<500) { copy($default,$abs); }
		return '<img alt="" src="'.$url.'" class="avatar avatar-'.$tmp[2].'" width="'.$tmp[2].'" height="'.$tmp[2].'" />';
	}




?>
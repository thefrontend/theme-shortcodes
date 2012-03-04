<?php
	add_shortcode('loginout','shortcode_loginout');
	/**
	* shortcode_loginout 					
	*
	* by Justin Tadlock/Hybrid theme
	*/	
	function shortcode_loginout() {
		$domain = $domian;
		if ( is_user_logged_in() )
			$out = '<a class="logout-link" href="' . esc_url( wp_logout_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log out of this account', $domain ) . '">' . __( 'Log out', $domain ) . '</a>';
		else
			$out = '<a class="login-link" href="' . esc_url( wp_login_url( site_url( $_SERVER['REQUEST_URI'] ) ) ) . '" title="' . esc_attr__( 'Log into this account', $domain ) . '">' . __( 'Log in', $domain ) . '</a>';

		return $out;
	} // function
	
?>
<?php

	add_shortcode('comment-reply-link','shortcode_comment_reply_link');
	/**
	* comment-reply-link				
	*
	* 
	*/
	function shortcode_comment_reply_link( $attr ) {
		$domain = $domian;

		if ( !get_option( 'thread_comments' ) || 'comment' !== get_comment_type() )
			return '';

		$defaults = array(
			'reply_text' => __( 'Reply', $domain ),
			'login_text' => __( 'Log in to reply.', $domain ),
			'depth' => $GLOBALS['comment_depth'],
			'max_depth' => get_option( 'thread_comments_depth' ),
			'before' => '',
			'after' => ''
		);
		$attr = shortcode_atts( $defaults, $attr );

		return get_comment_reply_link( $attr );
	} // function  
	
	
?>
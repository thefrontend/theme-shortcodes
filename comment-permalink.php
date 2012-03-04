<?php


	add-shortcode('comment-permalink','shortcode_comment_permalink');

	
	/**
	* comment-permalink					
	*
	* 
	*/
	function shortcode_comment_permalink( $attr ) {
		global $comment;

		$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );
		$domain = $domain;
		$link = '<a class="permalink" href="' . get_comment_link( $comment->comment_ID ) . '" title="' . sprintf( esc_attr__( 'Permalink to comment %1$s', $domain ), $comment->comment_ID ) . '">' . __( 'Permalink', $domain ) . '</a>';
		return $attr['before'] . $link . $attr['after'];
	} // function  


?>
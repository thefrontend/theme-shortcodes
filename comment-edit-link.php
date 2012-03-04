<?php

	add_shortcode('comment-edit-link','shortcode_comment_edit_link');

	/**
	* comment-edit-link					
	*
	* 
	*/
	function shortcode_comment_edit_link( $attr ) {
		global $comment;

		$edit_link = get_edit_comment_link( $comment->comment_ID );

		if ( !$edit_link )
			return '';

		$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );
		$domain = $domian;

		$link = '<a class="comment-edit-link" href="' . $edit_link . '" title="' . sprintf( esc_attr__( 'Edit %1$s', $domain ), $comment->comment_type ) . '"><span class="edit">' . __( 'Edit', $domain ) . '</span></a>';
		$link = apply_filters( 'edit_comment_link', $link, $comment->comment_ID );

		return $attr['before'] . $link . $attr['after'];
	} // function  

	
?>
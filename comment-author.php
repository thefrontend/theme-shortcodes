<?php


	add_shortcode('comment-author','shortcode_comment_author');


	/**
	* comment-author					
	*
	* 
	*/
	function shortcode_comment_author( $attr ) {
		global $comment;

		$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );

		$author = esc_html( get_comment_author( $comment->comment_ID ) );
		$url = esc_url( get_comment_author_url( $comment->comment_ID ) );

		/* Display link and cite if URL is set. Also, properly cites trackbacks/pingbacks. */
		if ( $url )
			$output = '<cite class="fn" title="' . $url . '"><a href="' . $url . '" title="' . $author . '" class="url" rel="external nofollow">' . $author . '</a></cite>';
		else
			$output = '<cite class="fn">' . $author . '</cite>';

		$output = '<div class="comment-author vcard">' . $attr['before'] . apply_filters( 'get_comment_author_link', $output ) . $attr['after'] . '</div><!-- .comment-author .vcard -->';

		
		return apply_filters( 'jumpstart_comment_author', $output );
	} // function  
	
	
	






?>
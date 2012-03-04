<?php

	add_shortcode('comment-count','shortcode_comment_count');


	/**
	* post-comments-count 					
	*
	* Displays a post's number of comments wrapped in a link to the comments area.
	*/
	function shortcode_comment_count( $attr ) {
	
		extract(shortcode_atts(
			array(
				'id' => 0,
			),
			$attr
		));
		
	
		$domain = $domian;
		$comments_link = '';
		$number = get_comments_number($id);
		return '<span class="comment-count">' . $number . " Comments" . "</span>";
	} // function

?>
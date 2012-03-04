<?php

add_shortcode('author-comment-count','shortcode_author_comment_count');

/**
* [author-comment-count] Shortcode Callback
*
*
*/
function shortcode_author_comment_count(){

    $oneText = '1';
    $moreText = '%';

    global $wpdb;

    $result = $wpdb->get_var('
        SELECT
            COUNT(comment_ID)
        FROM
            '.$wpdb->comments.'
        WHERE
            comment_author_email = "'.get_comment_author_email().'"'
    );

    if($result == 1): 

            echo str_replace('%', $result, $oneText);

    elseif($result > 1): 

            echo str_replace('%', $result, $moreText);

    endif;

}
	
?>
<?php

	add_shortcode('category-group-posts','shortcode_category_group_posts');
	/**
	* category-group-posts
	*
	* Category group posts by Rob Holmes http://onemanonelaptop.com
	*/
	function shortcode_category_group_posts($atts, $content, $tag) {
		global $post;	
		$defaults = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'parent'                   => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 0,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'more' 					   => 'more...',
			'columns' 				   => 2,
			'taxonomy'                 => 'category',
			'separator'				   => ', ',
			'pad_counts'               => false );
		
		// Merge user provided atts with defaults
		$atts = shortcode_atts( $defaults, $atts );
		
		$categories=  get_categories($atts); 
		
		// Go through each of the categories one by one
		$counter = 0;
		$output = '';
		$current_column = 0;
		
		foreach ($categories as $category) {
			
			$build = '<div class="category-group-entry"><div class="category-group-category"><a href="' . get_category_link( $category->cat_ID ) . '">' . $category->cat_name . '</a> <span class="category-group-count">('. $category->category_count .')</span></div>';
			$build_items = array();
			
			// For each category that exists get the posts in that category
			$args = array( 'numberposts' => 5, 'offset'=> 0, 'category' => $category->cat_ID, 'post_type'=>$atts['type'] );
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) {
				setup_postdata($post); 
				$build_items[] = '<span class="category-group-post"><a href="' .  get_permalink() . '">' . get_the_title() . '</a></span>';
			}
			$build .= implode( $atts['separator'] ,$build_items);
			$build .= ' <a href="' . get_category_link( $category->cat_ID ) . '">' . $atts['more'] . '</a>';
			$build .= '</div>'; // close the wrapping div
			
			$counter++;
			
			// If the counter is divisible by the column number then increment the counter
			if ( $counter % $atts['columns']) { $current_column++; }
			
			// Wrap the counter back to zero after reaching max columsn
			if ($current_column >= $atts['columns']) { $current_column = 0; }
			
			$output[$current_column] .= $build;
			
		}
		
		$final = '';
		$final .= '<table class="category-group"><tr>';
			foreach ($output as $html) {
				$final .=  '<td>' . $html. '</td>';
			}
		
		$final .=  '</tr></table>';
		return $final;	
	} // function
	
	
?>
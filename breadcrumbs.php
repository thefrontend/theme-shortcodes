<?php

	add_shortcode('breadcrumbs','shortcode_breadcrumbs');

	/**
	* breadcrumbs		
	*
	* by Joost de Valk http://yoast.com/
	*/
	function shortcode_breadcrumbs($attr) {
		global $wp_query, $post;

		$attr = shortcode_atts(array(	
			'lat'   => '',
			'sep'=> '&raquo;',
			'home'=> 'Home',
			'blog'=> '',
			'prefix'=> 'You are here:',
			'archiveprefix'=> 'Archives for',
			'searchprefix'=> 'Search for',
			'singlecatprefix'=> true,
			'singleparent'=> 0,
			'boldlast'=> true,
			'nofollowhome'=> false
			
			
			), $attr);
	

		if (!function_exists('bold_or_not')) {
			function bold_or_not($input) {
				$attr = get_option("yoast_breadcrumbs");
				if ($attr['boldlast']) {
					return '<strong>'.$input.'</strong>';
				} else {
					return $input;
				}
			}		
		}

		if (!function_exists('yoast_get_category_parents')) {
			// Copied and adapted from WP source
			function yoast_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
				$chain = '';
				$parent = &get_category($id);
				if ( is_wp_error( $parent ) )
				   return $parent;

				if ( $nicename )
				   $name = $parent->slug;
				else
				   $name = $parent->cat_name;

				if ( $parent->parent && ($parent->parent != $parent->term_id) )
				   $chain .= get_category_parents($parent->parent, true, $separator, $nicename);

				$chain .= bold_or_not($name);
				return $chain;
			}
		}
		
		$nofollow = ' ';
		if ($attr['nofollowhome']) {
			$nofollow = ' rel="nofollow" ';
		}
		
		$on_front = get_option('show_on_front');
		
		if ($on_front == "page") {
			$homelink = '<a'.$nofollow.'href="'.get_permalink(get_option('page_on_front')).'">'.$attr['home'].'</a>';
			$bloglink = $homelink.' '.$attr['sep'].' <a href="'.get_permalink(get_option('page_for_posts')).'">'.$attr['blog'].'</a>';
		} else {
			$homelink = '<a'.$nofollow.'href="'.get_bloginfo('url').'">'.$attr['home'].'</a>';
			$bloglink = $homelink;
		}
			
		if ( ($on_front == "page" && is_front_page()) || ($on_front == "posts" && is_home()) ) {
			$output = bold_or_not($attr['home']);
		} elseif ( $on_front == "page" && is_home() ) {
			$output = $homelink.' '.$attr['sep'].' '.bold_or_not($attr['blog']);
		} elseif ( !is_page() ) {
			$output = $bloglink.' '.$attr['sep'].' ';
			if ( ( is_single() || is_category() || is_tag() || is_date() || is_author() ) && $attr['singleparent'] != false) {
				$output .= '<a href="'.get_permalink($attr['singleparent']).'">'.get_the_title($attr['singleparent']).'</a> '.$attr['sep'].' ';
			} 
			if (is_single() && $attr['singlecatprefix']) {
				$cats = get_the_category();
				$cat = $cats[0];
				if ( is_object($cat) ) {
					if ($cat->parent != 0) {
						$output .= get_category_parents($cat->term_id, true, " ".$attr['sep']." ");
					} else {
						$output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a> '.$attr['sep'].' '; 
					}
				}
			}
			if ( is_category() ) {
				$cat = intval( get_query_var('cat') );
				$output .= yoast_get_category_parents($cat, false, " ".$attr['sep']." ");
			} elseif ( is_tag() ) {
				$output .= bold_or_not($attr['archiveprefix']." ".single_cat_title('',false));
			} elseif ( is_date() ) { 
				$output .= bold_or_not($attr['archiveprefix']." ".single_month_title(' ',false));
			} elseif ( is_author() ) { 
				$user = get_userdatabylogin($wp_query->query_vars['author_name']);
				$output .= bold_or_not($attr['archiveprefix']." ".$user->display_name);
			} elseif ( is_search() ) {
				$output .= bold_or_not($attr['searchprefix'].' "'.stripslashes(strip_tags(get_search_query())).'"');
			} else if ( is_tax() ) {
				$taxonomy 	= get_taxonomy ( get_query_var('taxonomy') );
				$term 		= get_query_var('term');
				$output .= $taxonomy->label .': '.bold_or_not( $term );
			} else {
				$output .= bold_or_not(get_the_title());
			}
		} else {
			$post = $wp_query->get_queried_object();

			// If this is a top level Page, it's simple to output the breadcrumb
			if ( 0 == $post->post_parent ) {
				$output = $homelink." ".$attr['sep']." ".bold_or_not(get_the_title());
			} else {
				if (isset($post->ancestors)) {
					if (is_array($post->ancestors))
						$ancestors = array_values($post->ancestors);
					else 
						$ancestors = array($post->ancestors);				
				} else {
					$ancestors = array($post->post_parent);
				}

				// Reverse the order so it's oldest to newest
				$ancestors = array_reverse($ancestors);

				// Add the current Page to the ancestors list (as we need it's title too)
				$ancestors[] = $post->ID;

				$links = array();			
				foreach ( $ancestors as $ancestor ) {
					$tmp  = array();
					$tmp['title'] 	= strip_tags( get_the_title( $ancestor ) );
					$tmp['url'] 	= get_permalink($ancestor);
					$tmp['cur'] = false;
					if ($ancestor == $post->ID) {
						$tmp['cur'] = true;
					}
					$links[] = $tmp;
				}

				$output = $homelink;
				foreach ( $links as $link ) {
					$output .= ' '.$attr['sep'].' ';
					if (!$link['cur']) {
						$output .= '<a href="'.$link['url'].'">'.$link['title'].'</a>';
					} else {
						$output .= bold_or_not($link['title']);
					}
				}
			}
		}
		if ($attr['prefix'] != "") {
			$output = $attr['prefix']." ".$output;
		}
		
			return $output;
		
	}
	

	

?>
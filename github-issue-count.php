<?php

	add_shortcode('github-issues','shortcode_github_issues');
	add_shortcode('github-issue-count','shortcode_github_issue_count');
	
	/**
	* [github-issues] Shortcode Callback
	*
	*
	*/
	function shortcode_github_issues($atts) {	
		// extract the defaults
		extract(shortcode_atts(array(		
			'user'     => null,
			'project'     => null,
			'template' => '{link}{body}{comments}',
		), $atts));
		
		if (!$user || !$project) {
			return;
		}
		
		
		
		$json = $this->shortcode_github_fetch_project_issues($user,$project);
		$data = json_decode($json);
		
		$output = '<ul class="github-issues github-issues-' . $user . '-' . $project. '">';
		foreach ($data->issues as $key => $issue) {
			$output .= '<li class="github-issue">' . $this->shortcode_github_template($template,$issue) . '</li>';
		}
		return $output;	
	} // function
	
	
	
	/**
	* [github-issue-count] Shortcode Callback
	*
	*
	*/
	function shortcode_github_issue_count($atts) {	
		// extract the defaults
		extract(shortcode_atts(array(		
			'user'     => null,
			'project'     => null,
		), $atts));
		
		if (!$user || !$project) {
			return;
		}
		
		$json = $this->shortcode_github_fetch_project_issues($user,$project);
		$data = json_decode($json);
		return count($data->issues);	
	} // function
	
	function shortcode_github_template($template,$issue) {
		$output = str_replace('{title}','<span class="github-issue-title">' . $issue->title . '</span>' ,$template);
		$output = str_replace('{link}','<a href="' . $issue->html_url. '" >'. $issue->title . '</a>',$output);
		$output = str_replace('{body}','<div class="github-issue-body">' . $issue->body . '</div>' ,$output);
		$output = str_replace('{comments}','<span class="github-issue-comments">' . $issue->comments . '</span>' ,$output);
		$output = str_replace('{url}',$issue->html_url,$output);
		$output = str_replace('{state}','<span class="github-issue-state">' .$issue->state . '</span>',$output);
		return $output;
	}
	
	function shortcode_github_fetch_project_issues($user,$project) {
		$transient = 'github-issues-' . $user . '-' . $project;
		// Get any existing copy of our transient data
		if ( false === ( $response = get_transient( $transient ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
			 $response = wp_remote_retrieve_body( wp_remote_get( 'http://github.com/api/v2/json/issues/list/' . $user . '/' . $project . '/open' ) );
			 set_transient( $transient,  $response, 60 );
		}
		return $response;
	} // function


?>
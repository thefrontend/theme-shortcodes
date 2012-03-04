<?php
	
	add_shortcode('github-projects','shortcode_github_projects');

	/**
	* [github-projects] Shortcode Callback
	*
	*
	*/
	function shortcode_github_projects($atts) {	
		// extract the defaults
		extract(shortcode_atts(array(		
			'user'     => null,
		), $atts));
		
		if (!$user) {
			return;
		}
		
		$data = $this->shortcode_github_fetch_projects($user);

		$xml          = new SimpleXMLElement($data);
		$repositories = array();		
	
		foreach ($xml->repositories->repository as $repository)	{
			$result = array();
			foreach ($repository->children() as $key => $value) {
				$result[$key] = (string) $value;
			}
			$repositories[] = $result;
		}
		
		$output = '<div class"github-projects"><ul class="github-projects-list">';
		foreach ($repositories as $repository) {
			$output .=  '<li class="github-projects-list-item"><a href="' . $repository['url'] . '" title="' . str_replace('"', "'", $repository['description']) .  '">' . $repository['name'] . '</a></li>';
		}
		$output .=  '</ul></div>';

		return $output;	
	} // function


	function shortcode_github_fetch_projects($user) {
		$transient = 'github-' . $user;
		// Get any existing copy of our transient data
		if ( false === ( $response = get_transient( $transient ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
			 $response = wp_remote_retrieve_body( wp_remote_get( 'http://github.com/api/v1/xml/' . $user ) );
			 set_transient( $transient,  $response, 60 );
		}
		return $response;
	} // function
	
	
	
	
	
<?php

	add_shortcode('feedburner-circulation','shortcode_feedburner_circulation');

	/**
	* [circulation] Shortcode Callback
	*
	*
	*/
	function shortcode_feedburner_circulation($atts) {
	
		// extract the defaults
		extract(shortcode_atts(array(		
			'feed'     => null,
		), $atts));
		
		if (!$feed) {
		 return;
		}
		
		$data = $this->shortcode_plugin_downloads_get_data();
		return '<span class="feedburner-circulation">' . $data . '</span>';
	} // function


	function shortcode_feedburner_circulation_get_data() {
		$transient = 'feedburner-circulation';
		$cachetime = 15;
		
		$cache = get_transient($transient);
		if ( false !== $cache )
			return $cache;
			
			
			
		// Load FeedBurner API Data
		$xml = @simplexml_load_file("https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=htnet");

		if (!$xml) {
			// If for some reason we can't access the Feedburner API data XML, just display a realistic figure
			// Feel free to change to your own subscriber count
			set_transient($transient, '-', 60 );
		} else { 
			// All's well! Retrieve the feed count!
			$data = $xml->feed->entry['circulation'];
		}
			
		set_transient( $transient, 
		
		
		
		$data, $cachetime - 1 );
		return $data;
	
	} // function






?>
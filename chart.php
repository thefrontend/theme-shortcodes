<?php

	add_shortcode('chart','shortcode_chart');

	/**
	* chart		
	*
	* 
	*/
	function shortcode_chart( $atts ) {
		extract(shortcode_atts(array(
			'data' => '',
			'colors' => '',
			'size' => '400x200',
			'bg' => 'ffffff',
			'title' => '',
			'labels' => '',
			'advanced' => '',
			'type' => 'pie'
		), $atts));

		switch ($type) {
			case 'line' :
				$charttype = 'lc'; break;
			case 'xyline' :
				$charttype = 'lxy'; break;
			case 'sparkline' :
				$charttype = 'ls'; break;
			case 'meter' :
				$charttype = 'gom'; break;
			case 'scatter' :
				$charttype = 's'; break;
			case 'venn' :
				$charttype = 'v'; break;
			case 'pie' :
				$charttype = 'p3'; break;
			case 'pie2d' :
				$charttype = 'p'; break;
			default :
				$charttype = $type;
			break;
		}
		$string = '';
		if ($title) $string .= '&chtt='.$title.'';
		if ($labels) $string .= '&chl='.$labels.'';
		if ($colors) $string .= '&chco='.$colors.'';
		$string .= '&chs='.$size.'';
		$string .= '&chd=t:'.$data.'';
		$string .= '&chf='.$bg.'';

		return '<img class="google-chart" title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
	} // function




?>
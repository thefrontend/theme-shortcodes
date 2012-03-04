<?php

add_shortcode('gmap','shortcode_gmap');
/**
	* map		
	*
	* 
	*/
	function shortcode_map_print_styles() {
		if  ($this->gmap_flag) {
		?>
		<style type="text/css">
			.post-content img {max-width: 100000%; /* override */}
		</style> 
		<?php
		}
	} // function

	// insert the script for google maps
	function shortcode_map_register_scripts() {
		wp_register_script('gmap','http://maps.google.com/maps/api/js?sensor=false');		
	} // function

	// gmap scripts
	function shortcode_map_print_scripts() {
		if (!$this->gmap_flag) { return; }
		wp_print_scripts('gmap'); 
		print $this->gmap_inline_script;
	} // function

	
	
	
	// Based on code by http://gis.yohman.com/gmaps-plugin/
	function shortcode_gmap($attr) {
		$this->gmap_flag = true;
		// default atts
		$attr = shortcode_atts(array(	
										'lat'   => '0', 
										'lon'    => '0',
										'id' => 'map',
										'zoom' => '1',
										'width' => '400',
										'height' => '300',
										'maptype' => 'ROADMAP',
										'address' => '',
										'kml' => '',
										'kmlautofit' => 'yes',
										'marker' => '',
										'markerimage' => '',
										'traffic' => 'no',
										'bike' => 'no',
										'fusion' => '',
										'start' => '',
										'end' => '',
										'text' => '',
										'infowindowdefault' => 'yes',
										'directions' => '',
										'hidecontrols' => 'false',
										'scale' => 'false',
										'scrollwheel' => 'true'
										
										), $attr);
										
		$attr['id'] .=  md5(serialize($attr)) ;

		$returnme = '
		<div id="' .$attr['id'] . '"  style="width:' . $attr['width'] . 'px;height:' . $attr['height'] . 'px;"></div>
		';
		
		//directions panel
		if($attr['start'] != '' && $attr['end'] != '') 
		{
			$panelwidth = $attr['width']-20;
			$returnme .= '
			<div id="directionsPanel" style="width:' . $panelwidth . 'px;height:' . $attr['height'] . 'px;border:1px solid gray;padding:10px;overflow:auto;"></div><br>
			';
		}


		$this->gmap_inline_script .= '
		

		<script type="text/javascript">

			var latlng = new google.maps.LatLng(' . $attr['lat'] . ', ' . $attr['lon'] . ');
			var myOptions = {
				zoom: ' . $attr['zoom'] . ',
				center: latlng,
				scrollwheel: ' . $attr['scrollwheel'] .',
				scaleControl: ' . $attr['scale'] .',
				disableDefaultUI: ' . $attr['hidecontrols'] .',
				mapTypeId: google.maps.MapTypeId.' . $attr['maptype'] . '
			};
			var ' . $attr['id'] . ' = new google.maps.Map(document.getElementById("' . $attr['id'] . '"),
			myOptions);
			';
					
			//kml
			if($attr['kml'] != '') 
			{
				if($attr['kmlautofit'] == 'no') 
				{
					$this->gmap_inline_script .= '
					var kmlLayerOptions = {preserveViewport:true};
					';
				}
				else
				{
					$this->gmap_inline_script .= '
					var kmlLayerOptions = {preserveViewport:false};
					';
				}
				$returnme .= '
				var kmllayer = new google.maps.KmlLayer(\'' . html_entity_decode($attr['kml']) . '\',kmlLayerOptions);
				kmllayer.setMap(' . $attr['id'] . ');
				';
			}

			//directions
			if($attr['start'] != '' && $attr['end'] != '') 
			{
				$this->gmap_inline_script .= '
				var directionDisplay;
				var directionsService = new google.maps.DirectionsService();
				directionsDisplay = new google.maps.DirectionsRenderer();
				directionsDisplay.setMap(' . $attr['id'] . ');
				directionsDisplay.setPanel(document.getElementById("directionsPanel"));

					var start = \'' . $attr['start'] . '\';
					var end = \'' . $attr['end'] . '\';
					var request = {
						origin:start, 
						destination:end,
						travelMode: google.maps.DirectionsTravelMode.DRIVING
					};
					directionsService.route(request, function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {
							directionsDisplay.setDirections(response);
						}
					});


				';
			}
			
			//traffic
			if($attr['traffic'] == 'yes')
			{
				$this->gmap_inline_script .= '
				var trafficLayer = new google.maps.TrafficLayer();
				trafficLayer.setMap(' . $attr['id'] . ');
				';
			}
		
			//bike
			if($attr['bike'] == 'yes')
			{
				$this->gmap_inline_script .= '			
				var bikeLayer = new google.maps.BicyclingLayer();
				bikeLayer.setMap(' . $attr['id'] . ');
				';
			}
			
			//fusion tables
			if($attr['fusion'] != '')
			{
				$this->gmap_inline_script .= '			
				var fusionLayer = new google.maps.FusionTablesLayer(' . $attr['fusion'] . ');
				fusionLayer.setMap(' . $attr['id'] . ');
				';
			}
		
			//address
			if($attr['address'] != '')
			{
				$this->gmap_inline_script .= '
				var geocoder_' . $attr['id'] . ' = new google.maps.Geocoder();
				var address = \'' . $attr['address'] . '\';
				geocoder_' . $attr['id'] . '.geocode( { \'address\': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						' . $attr['id'] . '.setCenter(results[0].geometry.location);
						';
						
						if ($attr['marker'] !='')
						{
							//add custom image
							if ($attr['markerimage'] !='')
							{
								$this->gmap_inline_script .= 'var image = "'. $attr['markerimage'] .'";';
							}
							$this->gmap_inline_script.= '
							var marker = new google.maps.Marker({
								map: ' . $attr['id'] . ', 
								';
								if ($attr['markerimage'] !='')
								{
									$returnme .= 'icon: image,';
								}
							$this->gmap_inline_script .= '
								position: ' . $attr['id'] . '.getCenter()
							});
							';

							//infowindow
							if($attr['text'] != '') 
							{
								//first convert and decode html chars
								$thiscontent = htmlspecialchars_decode($attr['text']);
								$this->gmap_inline_script .= '
								var contentString = \'' . $thiscontent . '\';
								var infowindow = new google.maps.InfoWindow({
									content: contentString
								});
											
								google.maps.event.addListener(marker, \'click\', function() {
								  infowindow.open(' . $attr['id'] . ',marker);
								});
								';

								//infowindow default
								if ($attr['infowindowdefault'] == 'yes')
								{
									$this->gmap_inline_script .= '
										infowindow.open(' . $attr['id'] . ',marker);
									';
								}
							}
						}
				$this->gmap_inline_script .= '
					} else {
					alert("Geocode was not successful for the following reason: " + status);
				}
				});
				';
			}

			//marker: show if address is not specified
			if ($attr['marker'] != '' && $attr['address'] == '')
			{
				//add custom image
				if ($attr['markerimage'] !='')
				{
					$this->gmap_inline_script .= 'var image = "'. $attr['markerimage'] .'";';
				}

				$this->gmap_inline_script .= '
					var marker = new google.maps.Marker({
					map: ' . $attr['id'] . ', 
					';
					if ($attr['markerimage'] !='')
					{
						$returnme .= 'icon: image,';
					}
				$this->gmap_inline_script .= '
					position: ' . $attr['id'] . '.getCenter()
				});
				';

				//infowindow
				if($attr['text'] != '') 
				{
					$this->gmap_inline_script .= '
					var contentString = \'' . $attr['text'] . '\';
					var infowindow = new google.maps.InfoWindow({
						content: contentString
					});
								
					google.maps.event.addListener(marker, \'click\', function() {
					  infowindow.open(' . $attr['id'] . ',marker);
					});
					';
					//infowindow default
					if ($attr['infowindowdefault'] == 'yes')
					{
						$this->gmap_inline_script .= '
							infowindow.open(' . $attr['id'] . ',marker);
						';
					}				
				}
			}

		$this->gmap_inline_script .= '</script>';
			
			return $returnme;

	} // function



?>
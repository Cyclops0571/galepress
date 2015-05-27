<!DOCTYPE html>
<html>
  <head>
    <title>Galepress Map View</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
<style type="text/css">
	#map_canvas { height:100%; width:100%; position: fixed !important; }
	#zoomBtn {    
        position: fixed;
        z-index: 9000000;
        top: 6%;
        width: 30px;
        height: 30px;
        right: 1%;
        font-size: 18px;
        line-height: 11px;
        color: rgb(127, 127, 127);
    }
    #zoomBtn.widget-icon.widget-icon-circle{
        background-color: #FFFFFF !important;
        webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
        
    }
     #zoomBtn span{
        line-height: 11px !important;
    }
    @media screen and ( max-height: 500px ){
    	#zoomBtn {    
	        top: 15%;
	    }
	}
</style>
        <!-- Begin CSS-->
        {{ HTML::style('css/print.css?v=' . APP_VER, array('media' => 'print')); }}
        {{ HTML::style('css/newdesign.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('css/general.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('css/fonts/open-sans-condensed/css/open-sans-condensed.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('css/myApp.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('uploadify/uploadify.css?v=' . APP_VER, array('media' => 'screen')); }}
        {{ HTML::style('js/chosen_v1.0.0/chosen.css?v=' . APP_VER,array('media' => 'screen'));}}
        {{ HTML::style('css/btn_interactive.css?v=' . APP_VER,array('media' => 'screen'));}}

        <link rel="stylesheet" href="/css/template-chooser/master.css?v=<?php echo APP_VER; ?>">
        <link rel="stylesheet" href="/website/styles/device-mockups2.css?v=<?php echo APP_VER; ?>">

        <!-- Begin JavaScript -->
        {{ HTML::script('js/jquery-1.7.2.min.js'); }}
        {{ HTML::script('js/jquery-ui-1.10.4.custom.min.js'); }}
        {{ HTML::script('js/bootstrap.min.js'); }}
        {{ HTML::script('js/jquery.uniform.min.js'); }}
        {{ HTML::script('js/jquery.knob.js'); }}
        {{ HTML::script('js/flot/jquery.flot.js'); }}
        {{ HTML::script('js/flot/jquery.flot.animator.js'); }}
        {{ HTML::script('js/flot/jquery.flot.resize.js'); }}
        {{ HTML::script('js/flot/jquery.flot.grow.js'); }}
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		var initialLocation;
		var turkey = new google.maps.LatLng(38.9574155, 35.2415759);
		var browserSupportFlag = new Boolean();

		function initialize() {
			var myOptions = {
				zoom: 16,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			var markerSet = [];
			var zoomBtn = document.getElementById("zoomBtn");
			<?php foreach($googleMapSet as $googleMap): ?>
				markerSet.push(
					new google.maps.Marker({
						position: new google.maps.LatLng({{$googleMap->Latitude}}, {{$googleMap->Longitude}}),
						map: map,
						draggable: false
					})
				);
			<?php endforeach; ?>

			var locationImage = {
				url: '/img/maps/bullet_blue.png',
				// This marker is 20 pixels wide by 32 pixels tall.
				size: new google.maps.Size(32, 32),
				// The origin for this image is 0,0.
				origin: new google.maps.Point(0, 0),
				// The anchor for this image is the base of the flagpole at 0,32.
				anchor: new google.maps.Point(0, 32)
			};

			// Try W3C Geolocation (Preferred)
			if (navigator.geolocation) {
				browserSupportFlag = true;
				navigator.geolocation.getCurrentPosition(function (position) {
					initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					initialMarker = new google.maps.Marker({
						position: initialLocation,
						map: map,
						draggable: false,
						icon: locationImage,
					});
					map.setCenter(initialLocation);
				}, function () {
					handleNoGeolocation(browserSupportFlag);
				});
				// Try Google Gears Geolocation
			} else if (google.gears) {
				browserSupportFlag = true;
				var geo = google.gears.factory.create('beta.geolocation');
				geo.getCurrentPosition(function (position) {
					initialLocation = new google.maps.LatLng(position.latitude, position.longitude);
					initialMarker = new google.maps.Marker({
						position: initialLocation,
						map: map,
						draggable: false,
						icon: locationImage,
					});
					map.setCenter(initialLocation);
				}, function () {
					handleNoGeoLocation(browserSupportFlag);
				});
				// Browser doesn't support Geolocation
			} else {
				browserSupportFlag = false;
				handleNoGeolocation(browserSupportFlag);
			}

			if(browserSupportFlag) {
				google.maps.event.addDomListener(zoomBtn, 'click', function () {
					if (initialLocation) {
						map.setCenter(initialLocation);
					}
					smoothZoom(map, 14, map.getZoom());
				});
			}

			function handleNoGeolocation(errorFlag) {
				if (errorFlag === true) {
					$("#zoomBtn").hide();
					alert("Geolocation service failed. We've placed you in Turkey.");
					initialLocation = turkey;
				} else {
					$("#zoomBtn").hide();
					alert("Your browser doesn't support geolocation. We've placed you in Turkey.");
					initialLocation = turkey;
				}
			}
		}

		function smoothZoom(map, max, cnt) {
			if (cnt >= max) {
				return;
			} else {
				z = google.maps.event.addListener(map, 'zoom_changed', function (event) {
					google.maps.event.removeListener(z);
					smoothZoom(map, max, cnt + 1);
				});
				setTimeout(function () {
					map.setZoom(cnt);
				}, 80);
			}
		}
		$(function () {
			initialize();
		})
	</script>
  </head>
  <body>
    <div id="map_canvas"></div>
	<a href="#" id="zoomBtn" class="widget-icon widget-icon-large widget-icon-circle"><span class="icon-location-arrow"></span></a>
  </body>
</html>
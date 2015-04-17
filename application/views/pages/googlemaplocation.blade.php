@layout('layouts.html')

@section('head')
    @parent
@endsection

@section('body')
<?php
if (FALSE) {
	$googleMapSet = new GoogleMap();
}
?>
<style type="text/css">
	#map_canvas { height:100%; width:100%; position: fixed !important; }
	#zoomBtn {    
        position: fixed;
        z-index: 9000000;
        top: 96px;
        width: 30px;
        height: 30px;
        left: 2%;
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
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
    var initialLocation;
    var turkey = new google.maps.LatLng(38.9574155, 35.2415759);
    var browserSupportFlag = new Boolean();

    function initialize() {
        var myOptions = {
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.HYBRID
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
<body class="bg-img-num1">
    <input type="hidden" id="currentlanguage" value="{{ Session::get('language') }}" />
    <div id="map_canvas"></div>
    <a href="#" id="zoomBtn" class="widget-icon widget-icon-large widget-icon-circle"><span class="icon-location-arrow"></span></a>
</body>
@endsection
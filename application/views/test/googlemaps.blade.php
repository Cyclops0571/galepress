<!DOCTYPE html>
<html>
	<head>
		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0; padding: 0 }
			#map-canvas { height: 100% }
		</style>
		<script type="text/javascript"
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABU5W1OsqdgiUWDEQm8EMW_iuFpQQUMNE">
		</script>
		<script type="text/javascript">
            function initialize() {
                var myLatLngSet = [];
                var mapOptions = {
                    zoom: 15
                };
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var myMarkerSet = [];
                var imageSrc = 'http://galepress.com/img/pin.png';
                var imageSrc = {
                    url: 'http://galepress.com/img/pin.png',
                    // This marker is 20 pixels wide by 32 pixels tall.
                    size: new google.maps.Size(50, 62),
                    // The origin for this image is 0,0.
                    origin: new google.maps.Point(0, 0),
                    // The anchor for this image is the base of the flagpole at 0,32.
                    anchor: new google.maps.Point(0, 32)
                };
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        map.setCenter(initialLocation);
                        myLatLngSet.push(initialLocation);
                        for (var i = 0; i < 5; i++) {
                            latitude = position.coords.latitude + Math.random() * i;
                            longitude = position.coords.longitude + Math.random() * i;
                            myLatLngSet.push(new google.maps.LatLng(latitude, longitude));
                        }
                        myLatLngSet.forEach(function (myLanLin) {
                            var m = new google.maps.Marker({
                                position: myLanLin,
                                map: map,
                                // This marker is 20 pixels wide by 32 pixels tall.
                                title: 'Lat:' + myLanLin.lat() + " - Lon:" + myLanLin.lat(),
                                icon: imageSrc,
                                animation: google.maps.Animation.DROP,
                            });
                            myMarkerSet.push(m);
                        });
						myMarkerSet.forEach(function(myMarker){
							google.maps.event.addListener(myMarker, 'click', function(){
								toggleBounce(myMarker);
							});
						});
//                        var infowindow = new google.maps.InfoWindow();
//                        myMarkerSet.forEach(function (myMarker) {
//                            google.maps.event.addListener(myMarker, 'click', function () {
//                                infowindow.open(map, myMarker);
//
//                            });
//                        });
                    });

                }

            }

            function toggleBounce(marker) {

                if (marker.getAnimation() != null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }
		</script>
	</head>
	<body onload="initialize()">
		<div id="map-canvas"></div>
	</body>
</html>
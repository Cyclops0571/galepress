<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		html { height: 100%; }
		body { height: 100%; margin: 0; padding: 0; }
		#map-canvas { height: 100%; }
	</style>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		function initialize() {
			var locations = [
				{lat: 40.98373015924737, lng: 28.90139088569608, description: 'asd 1'},
				{lat: 41.02143682201253, lng: 29.01213290474483, description: 'asd 2'},
				{lat: 40.99151532169524, lng: 28.87121954935498, description: 'asd 3'},
				{lat: 41.017552221671, lng: 28.58988635155501, description: 'asd 4'},
				{lat: 37.33461946, lng: -122.03478727, description: 'asd 5'}
			];
			var mapOptions = {};
			var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
			var bounds = new google.maps.LatLngBounds();
			for(var i = 0; i < locations.length; i++)
			{
				var location = locations[i];
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(location.lat, location.lng),
					map: map,
					title: location.description
				});
				bounds.extend(marker.position);
			}
			map.setCenter(bounds.getCenter());
			map.fitBounds(bounds);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>
<body>
	<div id="map-canvas"/>
</body>
</html>
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



<?php
/*
<script>

var json = {
	"results" : [
		{
			"address_components" : [
				{
					"long_name" : "1-5",
					"short_name" : "1-5",
					"types" : [ "street_number" ]
				},
				{
					"long_name" : "Sütçü İmam Caddesi",
					"short_name" : "Sütçü İmam Cd",
					"types" : [ "route" ]
				},
				{
					"long_name" : "Kısıklı Mh.",
					"short_name" : "Kısıklı Mh.",
					"types" : [ "neighborhood", "political" ]
				},
				{
					"long_name" : "Üsküdar",
					"short_name" : "Üsküdar",
					"types" : [ "sublocality", "political" ]
				},
				{
					"long_name" : "Istanbul",
					"short_name" : "Istanbul",
					"types" : [ "locality", "political" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				},
				{
					"long_name" : "34398",
					"short_name" : "34398",
					"types" : [ "postal_code" ]
				}
			],
			"formatted_address" : "Kısıklı Mh., Sütçü İmam Caddesi 1-5, 34696 Üsküdar/Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.024192,
						"lng" : 29.083771
					},
					"southwest" : {
						"lat" : 41.02410099999999,
						"lng" : 29.083106
					}
				},
				"location" : {
					"lat" : 41.0241712,
					"lng" : 29.0835951
				},
				"location_type" : "RANGE_INTERPOLATED",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0254954802915,
						"lng" : 29.08478748029149
					},
					"southwest" : {
						"lat" : 41.0227975197085,
						"lng" : 29.08208951970849
					}
				}
			},
			"types" : [ "street_address" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34696",
					"short_name" : "34696",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Istanbul",
					"short_name" : "Istanbul",
					"types" : [ "locality", "political" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34696 Istanbul/Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.0496229,
						"lng" : 29.1376104
					},
					"southwest" : {
						"lat" : 40.9340745,
						"lng" : 28.9746965
					}
				},
				"location" : {
					"lat" : 41.0187695,
					"lng" : 29.0750837
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0266038,
						"lng" : 29.0939898
					},
					"southwest" : {
						"lat" : 41.00327160000001,
						"lng" : 29.0547206
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34764",
					"short_name" : "34764",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Istanbul",
					"short_name" : "Istanbul",
					"types" : [ "locality", "political" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34764 Istanbul/Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.0463732,
						"lng" : 29.1492404
					},
					"southwest" : {
						"lat" : 40.970889,
						"lng" : 29.0750837
					}
				},
				"location" : {
					"lat" : 41.0401411,
					"lng" : 29.0983524
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0463732,
						"lng" : 29.1041691
					},
					"southwest" : {
						"lat" : 41.0077284,
						"lng" : 29.0750837
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34692",
					"short_name" : "34692",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34692, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.0627962,
						"lng" : 29.1347028
					},
					"southwest" : {
						"lat" : 40.9946189,
						"lng" : 28.9746965
					}
				},
				"location" : {
					"lat" : 41.02803170000001,
					"lng" : 29.0750837
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0537617,
						"lng" : 29.095444
					},
					"southwest" : {
						"lat" : 41.0125359,
						"lng" : 29.0561752
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34768",
					"short_name" : "34768",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34768 Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.0842847,
						"lng" : 29.2001113
					},
					"southwest" : {
						"lat" : 40.8878757,
						"lng" : 28.9746965
					}
				},
				"location" : {
					"lat" : 41.0182327,
					"lng" : 29.1274334
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0647939,
						"lng" : 29.140518
					},
					"southwest" : {
						"lat" : 41.003898,
						"lng" : 29.0809012
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34762",
					"short_name" : "34762",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34762, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.041654,
						"lng" : 29.146333
					},
					"southwest" : {
						"lat" : 40.952923,
						"lng" : 28.9746965
					}
				},
				"location" : {
					"lat" : 41.0123599,
					"lng" : 29.0983524
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.03021469999999,
						"lng" : 29.1114396
					},
					"southwest" : {
						"lat" : 40.9954344,
						"lng" : 29.0809012
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34776",
					"short_name" : "34776",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34776 Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.0494439,
						"lng" : 29.1972048
					},
					"southwest" : {
						"lat" : 40.9539547,
						"lng" : 29.0503567
					}
				},
				"location" : {
					"lat" : 41.0053855,
					"lng" : 29.1739513
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.02926540000001,
						"lng" : 29.1972048
					},
					"southwest" : {
						"lat" : 40.9776004,
						"lng" : 29.1390642
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "Ümraniye",
					"short_name" : "Ümraniye",
					"types" : [ "sublocality", "political" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "Ümraniye/Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.065545,
						"lng" : 29.1971902
					},
					"southwest" : {
						"lat" : 40.988965,
						"lng" : 29.0803129
					}
				},
				"location" : {
					"lat" : 41.0303,
					"lng" : 29.1065
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.065545,
						"lng" : 29.1971902
					},
					"southwest" : {
						"lat" : 40.988965,
						"lng" : 29.0803129
					}
				}
			},
			"types" : [ "sublocality", "political" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34760",
					"short_name" : "34760",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34760 Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.1011366,
						"lng" : 29.2277197
					},
					"southwest" : {
						"lat" : 40.9773944,
						"lng" : 29.06053889999999
					}
				},
				"location" : {
					"lat" : 41.0182327,
					"lng" : 29.1274334
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0521136,
						"lng" : 29.2277197
					},
					"southwest" : {
						"lat" : 40.9773944,
						"lng" : 29.06053889999999
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34660",
					"short_name" : "34660",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34660, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.0960648,
						"lng" : 29.1841252
					},
					"southwest" : {
						"lat" : 40.898312,
						"lng" : 28.865506
					}
				},
				"location" : {
					"lat" : 41.0189417,
					"lng" : 29.0576298
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.0582121,
						"lng" : 29.1085314
					},
					"southwest" : {
						"lat" : 40.97580420000001,
						"lng" : 28.9674195
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34700",
					"short_name" : "34700",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34700, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.1669163,
						"lng" : 29.2131896
					},
					"southwest" : {
						"lat" : 40.925916,
						"lng" : 28.8640496
					}
				},
				"location" : {
					"lat" : 40.9993388,
					"lng" : 29.1623231
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.031406,
						"lng" : 29.2131896
					},
					"southwest" : {
						"lat" : 40.9524795,
						"lng" : 29.0110762
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34398",
					"short_name" : "34398",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34398, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.6215733,
						"lng" : 32.6836885
					},
					"southwest" : {
						"lat" : 40.7285602,
						"lng" : 28.8596804
					}
				},
				"location" : {
					"lat" : 41.0121805,
					"lng" : 29.1158017
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.1793896,
						"lng" : 29.2320784
					},
					"southwest" : {
						"lat" : 40.974386,
						"lng" : 28.8596804
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "34980",
					"short_name" : "34980",
					"types" : [ "postal_code" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "34980, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.2091804,
						"lng" : 29.8505634
					},
					"southwest" : {
						"lat" : 40.8905512,
						"lng" : 29.0459927
					}
				},
				"location" : {
					"lat" : 41.1755753,
					"lng" : 29.4601074
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.2091804,
						"lng" : 29.7883989
					},
					"southwest" : {
						"lat" : 41.0565678,
						"lng" : 29.3349935
					}
				}
			},
			"types" : [ "postal_code" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "Istanbul",
					"short_name" : "Istanbul",
					"types" : [ "locality", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "Istanbul, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.199239,
						"lng" : 29.4288052
					},
					"southwest" : {
						"lat" : 40.811404,
						"lng" : 28.5955538
					}
				},
				"location" : {
					"lat" : 41.00527,
					"lng" : 28.97696
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.199239,
						"lng" : 29.4288052
					},
					"southwest" : {
						"lat" : 40.811404,
						"lng" : 28.5955538
					}
				}
			},
			"types" : [ "locality", "political" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "Istanbul Province",
					"short_name" : "Istanbul Province",
					"types" : [ "administrative_area_level_1", "political" ]
				},
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "Istanbul Province, Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 41.5845128,
						"lng" : 29.9157052
					},
					"southwest" : {
						"lat" : 40.802689,
						"lng" : 27.9713729
					}
				},
				"location" : {
					"lat" : 41.00527,
					"lng" : 28.97696
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 41.5845128,
						"lng" : 29.9157052
					},
					"southwest" : {
						"lat" : 40.802689,
						"lng" : 27.9713729
					}
				}
			},
			"types" : [ "administrative_area_level_1", "political" ]
		},
		{
			"address_components" : [
				{
					"long_name" : "Turkey",
					"short_name" : "TR",
					"types" : [ "country", "political" ]
				}
			],
			"formatted_address" : "Turkey",
			"geometry" : {
				"bounds" : {
					"northeast" : {
						"lat" : 42.106239,
						"lng" : 44.818128
					},
					"southwest" : {
						"lat" : 35.8076804,
						"lng" : 25.6636372
					}
				},
				"location" : {
					"lat" : 38.963745,
					"lng" : 35.243322
				},
				"location_type" : "APPROXIMATE",
				"viewport" : {
					"northeast" : {
						"lat" : 42.106091,
						"lng" : 44.818128
					},
					"southwest" : {
						"lat" : 35.8076804,
						"lng" : 25.6636372
					}
				}
			},
			"types" : [ "country", "political" ]
		}
	],
	"status" : "OK"
}
console.log(json);
</script>


<?php
/*
	 class Placemark
	 {
		  const ACCURACY_UNKNOWN      = 0;
		  const ACCURACY_COUNTRY      = 1;
		  const ACCURACY_REGION       = 2;
		  const ACCURACY_SUBREGION    = 3;
		  const ACCURACY_TOWN         = 4;
		  const ACCURACY_POSTCODE     = 5;
		  const ACCURACY_STREET       = 6;
		  const ACCURACY_INTERSECTION = 7;
		  const ACCURACY_ADDRESS      = 8;
 
		  protected $_point;
		  protected $_address;
		  protected $_accuracy;
 
		  // other code
		  public function setAddress($address)
		  {
				$this->_address = (string) $address;
		  }
 
		  public function getAddress()
		  {
				return $this->_address;
		  }
 
		  public function __toString()
		  {
				return $this->getAddress();
		  }

		  public function setPoint(Point $point)
		  {
				$this->_point = $point;
		  }
 
		  public function getPoint()
		  {
				return $this->_point;
		  }

		  public function setAccuracy($accuracy)
		  {
				$this->_accuracy = (int) $accuracy;
		  }
 
		  public function getAccuracy()
		  {
				return $this->_accuracy;
		  }

		  public static function FromSimpleXml($xml)
		  {
				require_once('Point.php');
				$point = Point::Create($xml->Point->coordinates);
 
				$placemark = new self;
				$placemark->setPoint($point);
				$placemark->setAddress($xml->address);
				$placemark->setAccuracy($xml->AddressDetails['Accuracy']);
 
				return $placemark;
		  }



	 }

class Point
	 {
		  protected $_lat;
		  protected $_lng;
 
		  public function __construct($latitude, $longitude)
		  {
				$this->_lat = $latitude;
				$this->_lng = $longitude;
		  }

		  public function getLatitude()
		  {
				return $this->_lat;
		  }
 
		  public function getLongitude()
		  {
				return $this->_lng;
		  }

		  public static function Create($str)
		  {
				list($longitude, $latitude, $elevation) = explode(',', $str, 3);
 
				return new self($latitude, $longitude);
		  }


 
		  // other code
	 }


class Geocoder
{
	 public static $url = 'https://maps.googleapis.com/maps/api/geocode/json';

	 const G_GEO_SUCCESS             = 200;
	 const G_GEO_BAD_REQUEST         = 400;
	 const G_GEO_SERVER_ERROR        = 500;
	 const G_GEO_MISSING_QUERY       = 601;
	 const G_GEO_MISSING_ADDRESS     = 601;
	 const G_GEO_UNKNOWN_ADDRESS     = 602;
	 const G_GEO_UNAVAILABLE_ADDRESS = 603;
	 const G_GEO_UNKNOWN_DIRECTIONS  = 604;
	 const G_GEO_BAD_KEY             = 610;
	 const G_GEO_TOO_MANY_QUERIES    = 620;

	 protected $_apiKey;

	 public function __construct($key)
	 {
		  $this->_apiKey = $key;
	 }

	 public function performRequest($latitude, $longitude)
	 {
		//https://developers.google.com/maps/documentation/javascript/examples/geocoding-reverse
		//http://www.phpriot.com/articles/google-maps-geocoding/10
		//https://developers.google.com/maps/documentation/geocoding/#GeocodingRequests
		//https://developers.google.com/maps/documentation/geocoding/#ReverseGeocoding
		//https://maps.googleapis.com/maps/api/geocode/json?latlng=41.02413618009633,29.08359048890796&sensor=false&key=AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4
		//https://maps.googleapis.com/maps/api/geocode/json?latlng=41.02413618009633,29.08359048890796&sensor=false&key=AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4
		  $url = sprintf('%s?latlng=%s,%s&sensor=false&key=%s',
							  self::$url,
							  $latitude,
							  $longitude,
							  $this->_apiKey);

		  $ch = curl_init($url);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  $response = curl_exec($ch);
		  curl_close($ch);

		  return $response;
	 }


public function lookup($search)
		  {
				$response = $this->performRequest($search, 'xml');
				$xml      = new SimpleXMLElement($response);
				$status   = (int) $xml->Response->Status->code;
 
				switch ($status) {
					 case self::G_GEO_SUCCESS:
						  require_once('Placemark.php');
 
						  $placemarks = array();
						  foreach ($xml->Response->Placemark as $placemark)
								$placemarks[] = Placemark::FromSimpleXml($placemark);
 
						  return $placemarks;
 
					 case self::G_GEO_UNKNOWN_ADDRESS:
					 case self::G_GEO_UNAVAILABLE_ADDRESS:
						  return array();
 
					 default:
						  throw new Exception(sprintf('Google Geo error %d occurred', $status));
				}
		  }



}

$address  = '1600 Pennsylvania Ave Washington DC';
$geocoder = new Geocoder('AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4');
//$geocoder = new Geocoder('AIzaSyCDbnAGTW5OUJKt72NXQH05Jy_CAjtVnX4');

$json = $geocoder->performRequest($address, 'json');

var_dump($json);
*/
?>
@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
    $googleMap = new GoogleMap();
}


if ($googleMap) {
    $ApplicationID = $googleMap->ApplicationID;
    $GoogleMapID = $googleMap->GoogleMapID;
    $Name = $googleMap->Name;
    $Address = $googleMap->Address;
    $Description = $googleMap->Description;
    $Latitude = $googleMap->Latitude;
    $Longitude = $googleMap->Longitude;
} else {
    $GoogleMapID = 0;
    $Name = '';
    $Address = '';
    $Description = '';
    $Latitude = 0;
    $Longitude = 0;
}
?>
<style type="text/css">
    #map_canvas { height:600px;}
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
    var markerLat = {{$Latitude}};
    var markerLog = {{$Longitude}};
    var initialLocation;
    var turkey = new google.maps.LatLng(38.9574155, 35.2415759);
    var browserSupportFlag = new Boolean();

    $( window ).resize(function() {
        $('#map_canvas').css('height',$(this).height()-110);
    });

    function initialize() {
        var myOptions = {
            zoom: 6,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var marker;
        if(markerLat != 0 || markerLog != 0) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(markerLat, markerLog),
                map: map,
                draggable: true
            });
        }
        myListener = google.maps.event.addListener(map, 'mouseup', function (event) {
            placeMarker(event.latLng);
        });

        // Try W3C Geolocation (Preferred)
        if (navigator.geolocation) {
            browserSupportFlag = true;
            navigator.geolocation.getCurrentPosition(function (position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
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
                map.setCenter(initialLocation);
                var zoomBtn = document.getElementById("zoomBtn");
                google.maps.event.addDomListener(zoomBtn, 'click', function () {
                    if (initialLocation) {
                        map.setCenter(initialLocation);
                    }
                    smoothZoom(map, 16, map.getZoom());
                });
            }, function () {
                handleNoGeoLocation(browserSupportFlag);
            });
            // Browser doesn't support Geolocation

        } else {
            browserSupportFlag = false;
            handleNoGeolocation(browserSupportFlag);
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

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    draggable: true
                });
            }
            populateInputs(location);
        }

        function populateInputs(pos) {
            document.getElementById("latitude").value = pos.lat();
            document.getElementById("langitude").value = pos.lng();
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
<div class="col-xs-12 col-sm-7 col-md-9 col-lg-9">
    <div id="map_canvas"></div>
</div>
<div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">

    <div class="block block-drop-shadow" style="min-width:264px;">
        <div class="header text-center">
            <span class="icon-map-marker" style="font-size:18px;"></span>
        </div>
        {{ Form::open(__('route.maps_detail'), 'POST') }}
        {{ Form::token() }}
        <input type="hidden" name="GoogleMapID" id="GoogleMapID" value="{{ $GoogleMapID }}" />
        @if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
        <input type="hidden" name="applicationID" id="ApplicationID" value="{{ $ApplicationID }}" />
        @endif
        <div class="content np">
            <div class="list list-contacts">
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.map_form_name')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="name" name="name" value="{{$Name}}" />
                        </div>
                    </div>                                
                </a>
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.map_form_address')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="address" name='address' value="{{$Address}}" />
                        </div>
                    </div>                                
                </a>                            
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.map_form_desc')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="description" name='description' value="{{$Description}}" />
                        </div>
                    </div>                                
                </a>
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.map_form_latitude')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="latitude" name='latitude' value="{{$Latitude}}" />
                        </div>
                    </div>                                
                </a>
                <a href="#" class="list-item">
                    <div class="list-text">
                        <span class="list-text-name">{{__('common.map_form_longitude')}}:</span>                                    
                        <div class="list-text-info">
                            <input type="text" id="langitude" name='langitude' value="{{$Longitude}}" />
                        </div>
                    </div>                                
                </a>
                <a href="#" class="list-item text-center" style="padding:10px;">

                    <div class="btn-group">
                      <button type="button" style="max-width:95px;" class="btn" onclick="javascript:location.href='{{ URL::to(__('route.maps').'?applicationID='.$ApplicationID) }}'">{{__('common.map_form_return')}}</button>
                      <button type="button" class="btn my-btn-send hide" id="zoomBtn">{{__('common.map_form_location')}}</button>
                      <button type="button" style="max-width:76px;" class="btn my-btn-success" onclick="cGoogleMap.save();">{{__('common.detailpage_save')}}</button>
                    </div>

                </a>                        
            </div>                        
        </div>
        {{ Form::close(); }}
    </div>

</div>


@endsection
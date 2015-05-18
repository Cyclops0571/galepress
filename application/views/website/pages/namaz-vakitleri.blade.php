<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link rel="manifest" href="compass/manifest.json">
  <link rel="icon" sizes="192x192" href="compass/images/logo-app.png">
  <link rel="apple-touch-icon" href="compass/images/logo-app.png">
  <title>Namaz Vakitleri</title>
  <meta name="keywords" content="Namaz, Vakit, Kıble, Pusula" />
  <meta name="description" content="Namaz Vakitleri">
  <meta name="author" content="Hakan SARIER">

  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="/website/namaz/compass/css/app.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:200, 400,600' rel='stylesheet' type='text/css'>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
  <script src="/website/namaz/jquery.simpleWeather.min.js"></script>
  <style type="text/css">
    body{
      background-color:#5E82A0;
      background-image:url('/website/namaz/background.jpg');
      background-repeat:no-repeat;
      /*background-attachment:fixed;*/
      background-size:cover;
      background-position:center center;
    }
    *{
      font-family: 'Titillium Web', sans-serif !important;
      font-weight: 400 !important;
      font-size: 1.02em !important;
    }
    .fontBold{
      font-weight: 600 !important;
    }
    .fontLight{
      color:#fff !important;
    }
    .prayerTimes{
      font-size: 1.1em !important;
    }
    .col-xs-2{
      padding: 0;
      text-align: center;
      margin: 5px;
    }
    .topShadow{
      -webkit-box-shadow: 0px -5px 15px 0px rgba(0,0,0,0.65);
      -moz-box-shadow: 0px -5px 15px 0px rgba(0,0,0,0.65);
      box-shadow: 0px -5px 15px 0px rgba(0,0,0,0.65);
    }
    .prayerTime p{
      font-size: 3em !important;
      font-weight: 200 !important;
      margin: 0;
    }
    #map-canvas {
      height: 100%;
      margin: 0px;
      padding: 0px
    }
  </style>
</head>
<body>
<div class="container">

    <div class="row">

        <div class="col-xs-12">

          <div class="row text-center prayerTime">
            <h1 class="fontLight" style="opacity:0;"><span class="futurePrayer">...</span> namazına kalan süre:</h1>
            <p class="fontBold fontLight" style="opacity:0;">...</p>
          </div>
          <div class="row namaz">
            <div class="col-xs-offset-1 col-xs-2">
              <h2>Sabah</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Öğle</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>İkindi</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Akşam</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Yatsı</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
          </div>
        </div>

    </div>

    <div class="row topShadow">

        <div class="col-xs-12">

          <div class="row text-center prayerLocation">
            <h1><span>...</span> / <span>...</span></h1>
            <p style="font-size:2.5em !important;">...</p>
          </div>
          <div class="row weathers">
            <div class="col-xs-offset-1 col-xs-2">
              <h2>Cmt</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Paz</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Pzt</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Sal</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Çar</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
          </div>
        </div>

    </div>

    <div class="row topShadow" style="padding:10px;">

        <div class="col-xs-12">

            <div class="row text-center">

              <div class="compass" style="font-size:0.3em !important;">

                <div id="rose" class="compass__rose">

                  <svg class="compass__rose__dial" viewBox="0 0 130 130" version="1.1" xmlns="http://www.w3.org/2000/svg">

                    <circle cx="65" cy="65" r="56" stroke="white" stroke-width="1" fill="none" />
                    <polyline points="63,9  67,9  65,13" fill="white"/>
                    <polyline points="121,63  121,67  119,65" fill="white"/>
                    <polyline points="63,121  67,121  65,119" fill="white"/>
                    <polyline points="9,63  9,67  11,65" fill="white"/>

                    <text x="65" y="4.2" font-size="5" text-anchor="middle" fill="white">K</text>
                    <text x="127" y="67" font-size="5" text-anchor="middle" fill="white">D</text>
                    <text x="65" y="129" font-size="5" text-anchor="middle" fill="white">G</text>
                    <text x="2.8" y="67" font-size="5" text-anchor="middle" fill="white">B</text>

                  </svg>

                </div>

                <svg class="compass__pointer" viewBox="0 0 130 130" version="1.1" xmlns="http://www.w3.org/2000/svg">

                  <polyline points="60,60  70,60  65,15" fill="#b60000"/>
                  <polyline points="60,70  70,70  65,115" fill="white"/>
                  <circle cx="65" cy="65" r="7" stroke="#b60000" stroke-width="7" fill="none" />

                </svg>

              </div>

              <div class='status hide'>

                <div id='debug-orientation-default'></div>
                <div id='debug-orientation'></div>

                <div class='position row'>
                  <div class='column-33'>
                    <div class='label'>HDG</div>
                    <div id='position-hng'>n/a</div>
                  </div
                  ><div class='column-33'>
                    <div class='label'>Lat</div>
                    <div id='position-lat'>&#8943;</div>
                  </div
                  ><div class='column-33'>
                    <div class='label'>Lng</div>
                    <div id='position-lng'>&#8943;</div>
                  </div>
                </div>

                <div class="options row">

                  <button id="btn-lock-orientation" class="btn btn--hide options__btn column-25" type="button">

                    <svg alt="lock off" class="btn__icon btn__icon--inactive" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                      <path id="lock-15-icon" d="M256,90.001c91.74,0,166,74.243,166,166c0,91.74-74.243,165.998-166,165.998
                      c-91.741,0-166-74.241-166-165.998C90,164.259,164.243,90.001,256,90.001 M256,50.001c-113.771,0-206,92.229-206,206
                      s92.229,205.998,206,205.998c113.771,0,206-92.227,206-205.998S369.771,50.001,256,50.001L256,50.001z M358.999,242.667V347h-148
                      V242.667H358.999z M238.667,196.333v31.334h25v-31.334c0-30.511-24.822-55.333-55.334-55.333c-30.51,0-55.332,24.822-55.332,55.333
                      v31.334h25v-31.334c0-16.726,13.607-30.333,30.332-30.333C225.06,166,238.667,179.607,238.667,196.333z" fill="white" />
                    </svg>

                    <svg alt="lock on" class="btn__icon btn__icon--active" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                      <path id="lock-13-icon" d="M256,90.001c91.74,0,166,74.243,166,166c0,91.74-74.243,165.998-166,165.998
                      c-91.741,0-166-74.241-166-165.998C90,164.259,164.243,90.001,256,90.001 M256,50.001c-113.771,0-206,92.229-206,206
                      s92.229,205.998,206,205.998c113.771,0,206-92.227,206-205.998S369.771,50.001,256,50.001L256,50.001z M201.225,227.537v-31.585
                      c0-30.755,25.021-55.776,55.775-55.776s55.775,25.021,55.775,55.776v31.585h-25.2v-31.585c0-16.859-13.716-30.576-30.575-30.576
                      s-30.575,13.717-30.575,30.576v31.585H201.225z M182.409,242.656v105.169h149.182V242.656H182.409z" fill="white" />
                    </svg>


                  </button

                  ><button id="btn-nightmode" class="btn options__btn column-33" type="button">

                    <svg lock="nightmode off" class="btn__icon btn__icon--inactive" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                       width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                      <path d="M255.5,156c-55.141,0-100,44.86-100,100c0,55.141,44.859,100,100,100s100-44.859,100-100
                        C355.5,200.86,310.641,156,255.5,156z M255.5,316c-33.084,0-60-26.916-60-60s26.916-60,60-60s60,26.916,60,60S288.584,316,255.5,316
                        z M150.779,179.064l-54.586-54.586l28.285-28.284l54.664,54.664C168.305,158.75,158.73,168.272,150.779,179.064z M332.436,151.28
                        l55.086-55.086l28.285,28.284l-55.164,55.165C352.75,168.805,343.229,159.229,332.436,151.28z M127.039,276H50v-40h77.039
                        c-1.012,6.521-1.539,13.2-1.539,20C125.5,262.801,126.027,269.479,127.039,276z M236,127.463V50h40v77.622
                        c-6.68-1.062-13.525-1.622-20.5-1.622C248.873,126,242.362,126.502,236,127.463z M179.143,361.143l-54.664,54.664l-28.285-28.285
                        l54.586-54.585C158.729,343.729,168.305,353.251,179.143,361.143z M462,236v40h-78.039c1.012-6.521,1.539-13.199,1.539-20
                        c0-6.8-0.527-13.479-1.539-20H462z M276,384.378V462h-40v-77.463c6.362,0.962,12.873,1.463,19.5,1.463
                        C262.475,386,269.32,385.441,276,384.378z M360.643,332.357l55.164,55.164l-28.285,28.285l-55.086-55.086
                        C343.229,352.771,352.751,343.195,360.643,332.357z" fill="white" />
                    </svg>

                    <svg class="btn__icon btn__icon--active" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                      <circle cx="256" cy="256" r="206" fill="white"/>
                    </svg>

                  </button

                  ><button id="btn-map" class="btn options__btn column-33" type="button">

                    <svg alt="map" class="btn__icon btn__icon--inactive" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                       width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                      <path id="location-icon" d="M256,50c-72.072,0-130.5,58.427-130.5,130.5c0,72.073,57.114,155.833,130.5,281.5
                      c73.388-125.666,130.5-209.427,130.5-281.5C386.5,108.427,328.074,50,256,50z M256,224.133c-25.848,0-46.801-20.953-46.801-46.8
                      s20.953-46.8,46.801-46.8s46.801,20.953,46.801,46.8S281.848,224.133,256,224.133z" fill="white" />
                    </svg>

                  </button


                  ><button id="btn-info" class="btn btn-popup options__btn column-33" type="button" data-name='info'>

                    <svg alt="info" class="btn__icon btn__icon--inactive" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

                      <path id="info-2-icon" d="M255.998,90.001c91.74,0,166.002,74.241,166.002,165.998c0,91.741-74.245,166-166.002,166
                      c-91.74,0-165.998-74.243-165.998-166C90,164.259,164.243,90.001,255.998,90.001 M255.998,50.001
                      C142.229,50.001,50,142.229,50,255.999c0,113.771,92.229,206,205.998,206c113.771,0,206.002-92.229,206.002-206
                      C462,142.229,369.77,50.001,255.998,50.001L255.998,50.001z M285.822,367.567h-57.646V230.6h57.646V367.567z M257,202.268
                      c-17.522,0-31.729-14.206-31.729-31.73c0-17.522,14.206-31.729,31.729-31.729c17.524,0,31.728,14.206,31.728,31.729
                      C288.728,188.062,274.524,202.268,257,202.268z" fill="white" />

                    </svg>

                  </button

                ></div>

              </div>


              <div id="popup hide" class="popup">

                <div id="popup-content" class="popup__content">

                  <div id="popup-contents" class="popup__contents">
                    <div id="popup-inner-info" class="popup__inner popup__inner--hide">
                      <p>
                      For best results calibrate the accelerometer in your device by tracing out a figure of 8 in the air several times vertically and horizontally. The heading can also be affected by nearby magnetic fields.
                      </p>
                      <p>
                      For more information, bugs or comments please visit <a href='https://github.com/lamplightdev/compass'>the repo on github</a>.
                      </p>
                    </div>

                    <div id="popup-inner-noorientation" class="popup__inner popup__inner--hide">
                      <p>
                        Unfortunately this browser doesn't support orientation so will not show your correct heading.
                      </p>
                    </div>
                  </div>

                  <button id="popup-close" class="popup__close" href='#'>close</button>

                </div>

              </div>

            </div> 
        </div>

    </div>

</div>

<script type="text/javascript">
// Docs at http://simpleweatherjs.com
$(document).ready(function() {
  // Note: This example requires that you consent to location sharing when
  // prompted by your browser. If you see a blank space instead of the map, this
  // is probably because you have denied permission for location sharing.
  function initialize() {

      // Try HTML5 geolocation
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var pos = new google.maps.LatLng(position.coords.latitude,
                                           position.coords.longitude);

        var geocoder = new google.maps.Geocoder();
          geocoder.geocode({'latLng': new google.maps.LatLng(position.coords.latitude, position.coords.longitude)}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK && results.length) {
                  results = results[0].address_components;
                  var loopBreak=true;
                  for (i = 0; i < results.length; i++) {
                    if(loopBreak){
                      for (j = 0; j < results[i].types.length; j++) {
                        if(results[i].types[j].indexOf("sublocality_level_1")!=-1){
                          $('.prayerLocation h1 span:first-child').text(results[i].long_name);
                          $('.prayerLocation h1 span:first-child').trigger('change');
                          loopBreak=false;
                          break;
                        }
                        else{
                        	if(results[i].types[j].indexOf("administrative_area_level_1")!=-1){
	                          $('.prayerLocation h1 span:first-child').text(results[i].long_name);
                            $('.prayerLocation h1 span:first-child').trigger('change');
	                        }
                        }
                      }
                    }
                    else {
                      break;
                    }
                  }
              }
          });
      }); 
    }
  }
  google.maps.event.addDomListener(window, 'load', initialize);
   

  var settings = {
      template: "{saat}:{dakika}:{saniye}",
      zamanGoster: '.prayerTime p'
  };


  function calculatePrayerTime(settings){

    var zaman = new Date(),
            saat = zaman.getHours(),
            dakika = zaman.getMinutes(),
            saniye = zaman.getSeconds(),
            ezanVakti = false;
        
        $('.namaz div').each(function(){
            var dZaman = $('p', this).text().split(':'),
                dToplam = ( dZaman[0] * (60 * 60) ) + ( dZaman[1] * 60 ),
                nToplam = (saat * (60 * 60)) + ( dakika * 60 );
            if ( dToplam <= nToplam ){
                $(this).removeClass('suan gecmedi').addClass('gecti');
            } else {
                $(this).removeClass('suan gecti').addClass('gecmedi');
            }
            // console.log(saniye);
            /* eğer namaz okunuyorsa */
            if ( dZaman[0] == saat && dZaman[1] == dakika ) {
              // console.log("girdi",saniye);
                ezanVakti = true;
                $(this).addClass('suan');
                if(saniye == 0)
                {
                  $('body').fadeOut(200);
                  location.reload();
                }
            }
        });
        
        if ( !$('.namaz div').hasClass('gecmedi') ){
            $('.namaz div:first').removeClass('gecti').addClass('gecmedi');
        }
        
        var YNZ = $('.namaz div.gecmedi:first p').text().split(':'),
            saatFark = YNZ[0] - saat,
            dakikaFark = (YNZ[1] - dakika) - 1,
            saniyeFark = 59 - saniye;
        
        if ( dakikaFark < 0 ){
            saatFark = saatFark - 1;
            dakikaFark = 60 + dakikaFark;
        }

        if ( saatFark < 0 ){
            saatFark = 24 + saatFark;
        }
        
        saatFark = saatFark < 10 ? '0' + saatFark : saatFark;
        dakikaFark = dakikaFark < 10 ? '0' + dakikaFark : dakikaFark;
        saniyeFark = saniyeFark < 10 ? '0' + saniyeFark : saniyeFark;
        
        $(settings.zamanGoster).html( settings.template.replace('{saat}', saatFark).replace('{dakika}', dakikaFark).replace('{saniye}', saniyeFark) );
        
        $('.namaz div.gecti').removeClass('songecen').filter(':last').addClass('songecen');
        
        if ( !$('.namaz div').hasClass('gecti') ){
            $('.namaz div:last').addClass('songecen');
        }

        $('span.futurePrayer').text($('.namaz .gecmedi:first h2').text());       
  }

  calculatePrayerTime(settings);
  setInterval(function() {
      calculatePrayerTime(settings);
  }, 1000);

  var daysInWeek = ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt'];

  function getToday(){
    var d = new Date();
    var n = d.getDay();
    var nLong="";
    switch(n) {
      case 0:
          nLong = "Pazar";
          break;
      case 1:
          nLong = "Pazartesi";
          break;
      case 2:
          nLong = "Salı";
          break;
      case 3:
          nLong = "Çarşamba";
          break;
      case 4:
          nLong = "Perşembe";
          break;
      case 5:
          nLong = "Cuma";
          break;
      case 6:
          nLong = "Cumartesi";
          break;     
    }
    $('.prayerLocation h1 span:eq(1)').text(nLong);
    for(var i=0;i<5;i++) {
      $('.weathers h2:eq('+i+')').text(daysInWeek[n]);
      n++;
      if(n>7)
        n=0;
    }
  }
  getToday();

  function detectTomorrow(){
      if(window.newdaytimer) clearTimeout(newdaytimer);
      var now= new Date,
      tomorrow= new Date(now.getFullYear(), now.getMonth(), now.getDate()+1); 
      window.newdaytimer= setTimeout(newdayalarm, tomorrow-now);
      
  }
  function newdayalarm(){
      $('body').fadeOut(200);
      location.reload();
  }

  detectTomorrow();

  $.simpleWeather({
    location: 'Üsküdar',
    unit: 'c',
    success: function(weather) {
      $('.prayerLocation p').text(weather.forecast[0].high+'°');
      for(var i=0;i<weather.forecast.length;i++) {
        $('.weathers p:eq('+i+')').text(weather.forecast[i].high+'°');
      }
    },
    error: function(error) {
      
    }
  });

  $('.prayerLocation h1 span:first-child').change(function(){
    var myLocation = $('.prayerLocation h1 span:first-child').text();
    $('.prayerTime h1').delay(750).fadeTo(1200,1);
    $('.prayerTime p').delay(750).fadeTo(1200,1);
    // var myLocation = 'Şebinkarahisar';
    $.ajax({
        async: false,
        type: 'POST',
        url: 'namaz-vakitleri',
        data: {location:myLocation},
        success: function (response) {
          // console.log(response);
          var imsak = jQuery.parseJSON(response)['imsak'];
          var ogle = jQuery.parseJSON(response)['ogle'];
          var ikindi = jQuery.parseJSON(response)['ikindi'];
          var aksam = jQuery.parseJSON(response)['aksam'];
          var yatsi = jQuery.parseJSON(response)['yatsi'];
          $('.namaz p:eq(0)').text(imsak.substr(0,5));
          $('.namaz p:eq(1)').text(ogle.substr(0,5));
          $('.namaz p:eq(2)').text(ikindi.substr(0,5));
          $('.namaz p:eq(3)').text(aksam.substr(0,5));
          $('.namaz p:eq(4)').text(yatsi.substr(0,5));
            
        }
    });
  });
});
</script>
<script src="/website/namaz/compass/js/app.js"></script>
</body>
</html>
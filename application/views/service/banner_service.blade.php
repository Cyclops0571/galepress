<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>GALERPESS BANNER SLIDER</title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="/css/masterslider/style/masterslider.css" />
		<link href="/css/masterslider/skins/black-2/style.css" rel='stylesheet' type='text/css'>
		<link href='/css/masterslider/style/ms-gallery-style.css' rel='stylesheet' type='text/css'>

		<script src="/js/masterslider/jquery-1.10.2.min.js"></script>
		<script src="/js/masterslider/jquery.easing.min.js"></script>
		<script src="/js/masterslider/masterslider.min.js"></script>

		<style>			
			#ms-gallery-1{
				margin:0 auto;
			}
			body{
				margin:0;
			}
			.ms-gallery-template .ms-gallery-botcont{
				position: fixed !important;
				bottom:0 !important;
				width: 100% !important;
				opacity: 0.7;
			}
			.ms-gallery-template .ms-bullets.ms-dir-h{
				right: 50% !important;
			}
			.ms-gallery-template .ms-slide-info{
				padding: 20px 0px !important;
				font-size: 0.8em !important;
			}
		</style>

	</head>

	<body>
		<div class="ms-gallery-template" id="ms-gallery-1">
				<!-- masterslider -->
				<div class="master-slider ms-skin-black-2 round-skin" id="masterslider">
				    <div class="ms-slide">
				        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/1.jpg" alt="lorem ipsum dolor sit"/> 
				        <img src="/img/bannerSlider/thumbs/1.jpg" alt="thumb-1" class="ms-thumb"/>
				        <div class="ms-info">
				        	LOREM IPSUM DOLOR SIT AMET
				        </div>
				    </div>
				    <div class="ms-slide">
				        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/2.jpg" alt="lorem ipsum dolor sit"/>     
				         <img src="/img/bannerSlider/thumbs/2.jpg" alt="thumb-2" class="ms-thumb"/>
				         <div class="ms-info">
				        	CONSECTETUR ADIPISCING ELIT
				        </div>
				    </div>
				    <div class="ms-slide">
				        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/3.jpg" alt="lorem ipsum dolor sit"/>    
				          <img src="/img/bannerSlider/thumbs/3.jpg" alt="thumb-3" class="ms-thumb"/>
				         <div class="ms-info">
				        	SUSPENDISSE UT PULVINAR MAURIS
				        </div>   
				    </div>
				    <div class="ms-slide">
				        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/4.jpg" alt="lorem ipsum dolor sit"/>    
				         <img src="/img/bannerSlider/thumbs/4.jpg" alt="thumb-4" class="ms-thumb"/>
				         <div class="ms-info">
				        	SED DAPIBUS SIT AMET FELIS
				        </div>  
				    </div>
				    <div class="ms-slide">
				        <img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/5.jpg" alt="lorem ipsum dolor sit"/>    
				         <img src="/img/bannerSlider/thumbs/5.jpg" alt="thumb-4" class="ms-thumb"/>
				         <div class="ms-info">
				        	SED DAPIBUS SIT AMET FELIS
				        </div>  
				    </div>
				</div>
		</div>
	</body>

	<script type="text/javascript">
	var slider = new MasterSlider();
	
	var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1; // Detect Android devices
    if (isAndroid) {
    	var screenOrientation = (screen.width > screen.height) ? 90 : 0;
		if (screenOrientation === 90) {
			slider.setup('masterslider' , {
				width:740,
				height:window.innerHeight,
				space:0,
				view:'fadeBasic',
				layout: 'partialview',
				fillMode: 'stretch',
				speed: 20
			});
		}
		else {
		    slider.setup('masterslider' , {
				width:740,
				height:window.innerHeight,
				space:0,
				view:'fadeBasic',
				layout: 'fullscreen',
				fillMode: 'stretch',
				speed: 20
			});
		}
    }
    else {
		function doOnOrientationChange()
		{
			switch(window.orientation) 
			{  
			  case -90:
			  case 90:			    
				slider.setup('masterslider' , {
					width:740,
					height:window.innerHeight,
					space:0,
					view:'fadeBasic',
					layout: 'partialview',
					fillMode: 'stretch',
					speed: 20
				});
			    break; 
			  default:
			 	slider.setup('masterslider' , {
					width:740,
					height:window.innerHeight,
					space:0,
					view:'fadeBasic',
					layout: 'fullscreen',
					fillMode: 'stretch',
					speed: 20
				});
			    break; 
			}
		}
		doOnOrientationChange();
    }
	// slider.control('arrows');	
	var gallery = new MSGallery('ms-gallery-1' , slider);
	gallery.setup();
	slider.api.addEventListener(MSSliderEvent.CHANGE_START , function(){
		$( ".ms-gallery-botcont" ).stop(true);
		$( ".ms-gallery-botcont" ).animate( {opacity: 0.7}, 750);
	});

	slider.api.addEventListener(MSSliderEvent.CHANGE_END , function(){
	    $( ".ms-gallery-botcont" ).delay(2500).animate( {opacity: 0}, 2500);
	});
	</script>
</html>

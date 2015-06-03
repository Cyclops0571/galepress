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
			.ms-gallery-template .ms-bullets.ms-dir-h,.ms-bullets.ms-dir-h .ms-bullets-count {
				right: 3% !important;
			}
			.ms-gallery-template .ms-gallery-botcont{
				position: fixed !important;
				bottom:0 !important;
				width: 100% !important;
				opacity: 0.7;
				height: 13% !important;
			}
			.ms-gallery-template .ms-slide-info{
				padding: 0px 20px !important;
				font-size: 0.8em !important;
			}
			.ms-info{
				display: table-cell !important;
				vertical-align: middle !important;
			}
			.ms-bullets-count{
				display: table-cell !important;
				vertical-align: middle !important;
			}
			.ms-gallery-template .ms-gal-playbtn{
				display: none !important;
			}
			.ms-gallery-template .ms-gal-thumbtoggle{
				display: none !important;
			}
			.ms-timerbar{
				display: none !important;
			}
			.ms-slide-info.ms-dir-h,.ms-bullets.ms-dir-h{
				height: 100% !important;
				display: table !important;
				top:0 !important;
			}
			*{
				-webkit-tap-highlight-color: rgba(0,0,0,0) !important;
			}
		</style>

	</head>

	<?php
	if (false) {
		$savedBanner = new Banner();
		$application = new Application();
	}
	$Autoplay = $application->BannerAutoplay;
	$IntervalTime = $application->BannerIntervalTime;
	$TransitionRate = $application->BannerTransitionRate;
	?>
	<body>
		<div class="ms-gallery-template" id="ms-gallery-1">
			<div class="master-slider ms-skin-black-2 round-skin" id="masterslider">
				<?php foreach ($bannerSet as $savedBanner): ?>
					<div class="ms-slide" data-delay="{{$IntervalTime}}">
						<?php $imgPath = $savedBanner->getImagePath($application); ?>
						<img src="/img/bannerSlider/blank.gif" data-src="{{$imgPath}}" />
						<div class="ms-info">{{$savedBanner->Description}}</div>
						<!-- <a href="//{{$savedBanner->TargetUrl}}" target="_blank"></a> -->
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</body>

	<script type="text/javascript">
	var slider = new MasterSlider();
	var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > - 1; // Detect Android devices
	if (isAndroid) {
var screenOrientation = (screen.width > screen.height) ? 90 : 0;
	if (screenOrientation === 90) {
slider.setup('masterslider', {
width:740,
	height:window.innerHeight,
	space:0,
	view:'fadeBasic',
	layout: 'partialview',
	fillMode: 'stretch',
	speed: {{$TransitionRate}},
	autoplay: <?php echo json_encode($Autoplay == 1 ? true : false); ?>
});
	}
else {
slider.setup('masterslider', {
width:740,
	height:window.innerHeight,
	space:0,
	view:'fadeBasic',
	layout: 'fullscreen',
	fillMode: 'stretch',
	speed: {{$TransitionRate}},
	autoplay: <?php echo json_encode($Autoplay == 1 ? true : false); ?>
});
	}
}
else {
function doOnOrientationChange()
	{
	switch (window.orientation)
		{
		case - 90:
			case 90:
			slider.setup('masterslider', {
			width:740,
				height:window.innerHeight,
				space:0,
				view:'fadeBasic',
				layout: 'partialview',
				fillMode: 'stretch',
				speed: {{$TransitionRate}},
				autoplay: <?php echo json_encode($Autoplay == 1 ? true : false); ?>
			});
			break;
			default:
			slider.setup('masterslider', {
			width:740,
				height:window.innerHeight,
				space:0,
				view:'fadeBasic',
				layout: 'fullscreen',
				fillMode: 'stretch',
				speed: {{$TransitionRate}},
				autoplay: <?php echo json_encode($Autoplay == 1 ? true : false); ?>
			});
			break;
			}
	}
doOnOrientationChange();
	}
// slider.control('arrows');	
var gallery = new MSGallery('ms-gallery-1', slider);
	gallery.setup();
	slider.api.addEventListener(MSSliderEvent.CHANGE_START, function(){
	$(".ms-gallery-botcont").stop(true);
		$(".ms-gallery-botcont").animate({opacity: 0.7}, 750);
	});
	slider.api.addEventListener(MSSliderEvent.CHANGE_END, function(){
	$(".ms-gallery-botcont").delay(2500).animate({opacity: 0}, 2500);
	});
	$('#ms-gallery-1').click(function(){
$("#ms-gallery-1 .ms-gallery-botcont").stop(true);
	if ($("#ms-gallery-1 .ms-gallery-botcont").css('opacity') > 0){
$("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0}, 250);
	}
else{
$("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0.7}, 250);
	}
});
	$(".ms-info").each(function() {
if ($(this).text().length > 50){
var infoText = $(this).text();
	infoText = infoText.substring(0, 50);
	$(this).text(infoText + "...");
	}
});
	</script>
</html>

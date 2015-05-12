<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>GALERPESS BANNER SLIDER</title>	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="/css/masterslider/style/masterslider.css" />
		<link href="/css/masterslider/skins/default/style.css" rel='stylesheet' type='text/css'>
		<link href='/css/masterslider/ms-partialview.css' rel='stylesheet' type='text/css'>
		<script src="/js/masterslider/jquery-1.10.2.min.js"></script>
		<script src="/js/masterslider/jquery.easing.min.js"></script>
		<script src="/js/masterslider/masterslider.min.js"></script>

		<style type="text/css">
			body{
				margin:0;
			}
		</style>

	</head>

	<body>
		<div class="ms-partialview-template" id="partial-view-1">
			<div class="master-slider ms-skin-default" id="masterslider">
				<div class="ms-slide">
					<img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>    
				</div>
				<div class="ms-slide">
					<img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>     
				</div>
				<div class="ms-slide">
					<img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>    
				</div>
				<div class="ms-slide">
					<img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/>      
				</div>
				<div class="ms-slide">
					<img src="/img/bannerSlider/blank.gif" data-src="/img/bannerSlider/default.jpg"/> 
				</div>
			</div>
		</div>
	</body>

	<script type="text/javascript">
	var slider = new MasterSlider();

	slider.control('arrows');
	slider.control('bullets');

	var screenOrientation = (screen.width > screen.height) ? 90 : 0;

	if (screenOrientation === 90) {
		slider.setup('masterslider', {
		width: 740,
		height: window.innerHeight,
		space: 10,
		view: 'fadeWave',
		layout: 'partialview',
		speed: 20
		});
	}
	else {
		slider.setup('masterslider', {
		width: 740,
		height: 320,
		space: 10,
		view: 'basic',
		layout: 'fullscreen',
		speed: 20
		});
	}
	</script>
</html>

<?php
$index = 0;
$newWidth = 0;
$newHeight = 0;
if(!isset($files)) $files = array();	
if(!isset($modal)) $modal = 0;
if(!isset($transparent)) $transparent = 0;
if(!isset($bgcolor)) $bgcolor = '#151515';

foreach($files as $file)
{
	//$filename = path('public').$file->Value;
	$filename = path('public').$file;
	if(File::exists($filename) && is_file($filename))
	{
		if($index == 0)
		{
			$im = new imagick($filename);
			$geo = $im->getImageGeometry();
			$imageWidth = $geo['width'];
			$imageHeight = $geo['height'];
			$newWidth = $h * $imageWidth / $imageHeight;
			$newHeight = $h;
		}
	}
	$index = $index + 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>GalePress</title>
	<meta content="Touch-enabled image gallery and content slider plugin, that focuses on providing great user experience on every desktop and mobile device." name="description">
	<meta name="keywords" content="content slider, gallery, plugin, jquery, banner rotator">
	<meta name="author" content="Dmitry Semenov">
	<meta name="viewport" content="user-scalable=no">
	<!-- slider JS files -->
	<script class="rs-file" src="{{ $baseDirectory }}comp_{{ $id }}/assets/royalslider/jquery-1.8.3.min.js"></script>
	<script class="rs-file" src="{{ $baseDirectory }}comp_{{ $id }}/assets/royalslider/jquery.royalslider.min.js"></script>
	<link class="rs-file" href="{{ $baseDirectory }}comp_{{ $id }}/assets/royalslider/royalslider.css" rel="stylesheet">
	<!-- syntax highlighter -->
	<script src="{{ $baseDirectory }}comp_{{ $id }}/assets/preview-assets/js/highlight.pack.js"></script>
	<script src="{{ $baseDirectory }}comp_{{ $id }}/assets/preview-assets/js/jquery-ui-1.8.22.custom.min.js"></script>
	<script> hljs.initHighlightingOnLoad();</script>
	<!-- preview-related stylesheets -->
	<link href="{{ $baseDirectory }}comp_{{ $id }}/assets/preview-assets/css/reset.css" rel="stylesheet">
	<link href="{{ $baseDirectory }}comp_{{ $id }}/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css" rel="stylesheet">
	<link href="{{ $baseDirectory }}comp_{{ $id }}/assets/preview-assets/css/github.css" rel="stylesheet">
	<!-- slider stylesheets -->
	<link class="rs-file" href="{{ $baseDirectory }}comp_{{ $id }}/assets/royalslider/skins/default-inverted/rs-default-inverted.css" rel="stylesheet">
	<!-- slider css -->
	<style>
		html { overflow:hidden; width:100%; height: 100%; }
		body 
		{
			overflow: hidden;
			/*
			width: {{ $w }}px;
			height: {{ $h }}px;
			*/
			width: 100%;
			height: 100%;
			@if((int)$transparent == 1)
			background: transparent !important;
			@else
			background: {{ $bgcolor }} !important;
			@endif
		}
		#slider-in-laptop {
			@if((int)$modal == 1)
			margin:0 auto;
			padding:0px;
			text-align: center;
			@else
			width:100% !important;
			height:100% !important;
			padding: 0% 0% 0%;
			@endif
			background: none;
		}
		#slider-in-laptop .rsOverflow,
		#slider-in-laptop .rsSlide,
		#slider-in-laptop .rsVideoFrameHolder,
		#slider-in-laptop .rsThumbs {
			/*background: #151515;*/
			background: transparent !important;
		}
		.imgBg {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: auto;
		}
		.laptopBg {
			position: relative;
			width: 100%;
			height: auto;
		}
		#slider-in-laptop .rsBullets {
			bottom: 30px;
		}
		#page-navigation { display: none; }

		@if((int)$modal == 1)
		#slider-in-laptop .rsSlide img { }
		.royalSlider {
			width: 100%;
			height: 100%;
		}
		.rsOverflow .grab-cursor{
			width: 100%;
			height: 100%;
		}
		@else
		#slider-in-laptop .rsSlide img { width:100% !important; height:100% !important; }
		@endif

	</style>
</head>
<body>
	<!-- slider code start -->
	<div id="slider-in-laptop" class="royalSlider rsDefaultInv">
		<?php
		//var_dump($files);
		foreach($files as $file)
		{
			//$filename = path('public').$file->Value;
			$filename = path('public').$file;
			if(File::exists($filename) && is_file($filename)) {
				$fname = File::name($filename);
				$fext = File::extension($filename);
				$filename = $fname.'.'.$fext;
				
				if(!$preview)
				{
					//$vFile = 'comp_'.$id.'/'.$filename;
					$vFile = $baseDirectory.'comp_'.$id.'/'.$filename;
				}
				else
				{
					$vFile = '/'.$file;	
				}
				//echo '<img src="'.$vFile.'" width="'.$newWidth.'" height="'.$newHeight.'" />';
				//echo '<img src="'.$vFile.'" />';

				echo '<img src="'.$vFile.'"/>';
			}
		}
		?>
	</div>

	<script id="addJS">
		jQuery(document).ready(function($) {

			@if((int)$modal == 1)
			$.extend($.rsProto, {
				_initGlobalCaption: function() {
					var self = this;
					self.ev.on('rsAfterInit', function() {
						setTimeout(function() {

							var imgHeight = $('.rsMainSlideImage').height();

			     			if(imgHeight < $( document ).height())
			     			{
			     				var verticalCalc = ($( document ).height() - imgHeight) / 2;
					     		//$('img').animate({marginTop:verticalCalc});
					     		$('img').css('marginTop', verticalCalc);
			     			}
		     			}, 200);
					});
				}
			});
			$.rsModules.globalCaption = $.rsProto._initGlobalCaption;
     		@endif

			var rsi = $('#slider-in-laptop').royalSlider({
				autoHeight: false,
				arrowsNav: false,
				fadeinLoadedSlide: false,
				controlNavigationSpacing: 0,
				imageScaleMode: 'fit-if-smaller',
				imageAlignCenter: false,
				@if((int)$modal != 1)
				loop: true,
				@endif
				loopRewind: false,
				numImagesToPreload: 6,
				keyboardNavEnabled: true,
				autoScaleSlider: false,  
				autoScaleHeight: false
				/*
				imgWidth: {{ $newWidth }},
				imgHeight: {{ $newHeight }}
				*/
			}).data('royalSlider');
			
			$('#slider-next').click(function() {
				rsi.next();
			});

			$('#slider-prev').click(function() {
				rsi.prev();
			});
			$(document).bind(
				'touchmove',
				function(e) {
					e.preventDefault();
				}
			);
		});
	</script>
</body>
</html>
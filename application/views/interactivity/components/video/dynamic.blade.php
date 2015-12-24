<?php
$vFile = path('public').$filename;
if(File::exists($vFile) && is_file($vFile)) {
	$fname = File::name($vFile);
	$fext = File::extension($vFile);
	$vFile = $fname.'.'.$fext;
}
else {
	$vFile = '';
}

$vPosterImageFile = path('public').$posterimagename;
if(File::exists($vPosterImageFile) && is_file($vPosterImageFile)) {
	$fname = File::name($vPosterImageFile);
	$fext = File::extension($vPosterImageFile);
	$vPosterImageFile = $fname.'.'.$fext;
}
else {
	$vPosterImageFile = '';
}

if(!$preview)
{
	$vFile = $baseDirectory.'comp_'.$id.'/'.$vFile;
	$vPosterImageFile = $baseDirectory.'comp_'.$id.'/'.$vPosterImageFile;
}
else
{
	$vFile = '/'.$filename;
	$vPosterImageFile = '/'.$posterimagename;
}

/*
if((int)$modal == 1) {
	//$w = '100%';
	//$h = '100%';
}
else {
	$w = $w - 20;
	$h = $h - 10;
}
*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
	<script src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery.js"></script>
	<title>GalePress</title>
	<link href="{{ $baseDirectory }}comp_{{ $id }}/css/video-js.css" rel="stylesheet" type="text/css">
	<script src="{{ $baseDirectory }}comp_{{ $id }}/js/video.js" type="text/javascript"></script>
	<style>
	*{
		overflow:hidden !important;
	}
	body{
		margin: 0 !important;

	}
	.video-js{
		position: fixed !important;
		width,height: 100% !important;
	}
	.vjs-control-bar{
		position: fixed !important;
	}
	/*Video JS Css*/
    .vjs-default-skin .vjs-big-play-button {
      left: 50%;
      margin-top: -22px;
      margin-left: -22px;
      top: 50%;
      font-size: 2em;
      width: 2em;
      height: 2em;
      -webkit-border-radius: 50%;
      -moz-border-radius: 50%;
      border-radius: 50%;
    }
    .vjs-default-skin .vjs-big-play-button:before {
      line-height: 1.5em;
    }

	</style>
	<script type="text/javascript">
		$(document).ready(function($)
		{
			if({{$modal}}==1){
				$( "*" ).css('opacity','0');
				$( "html" ).css('background','black');
				$( "html" ).css('opacity','1');
			}

			if({{$videodelay}}!=0){
				setTimeout(function() {			
		      		$("video")[0].play();
				}, {{$videodelay}});
			}
		});

		function startVideo () {
			var o = videojs('example_video_1');
			if(o.paused()) {
				o.play();
			}
			else {
				o.pause();
			}
		}
	</script>
</head>
<body>
	<video id="example_video_1" onclick="startVideo()" class="video-js vjs-default-skin" {{($videoinit=='onload' ? 'autoplay' : '')}} {{($showcontrols==1 ? 'controls' : '')}} {{($restartwhenfinished==1 ? 'loop' : '')}} {{($mute==1 ? 'mute' : '')}} preload="auto" width="{{$w}}" height="{{$h}}"
	      poster="{{$vPosterImageFile}}"
	      data-setup="{}" style="position:fixed; height:100% !important;">
	    <source src="{{ ($option==1 ? $vFile : $url) }}" type='video/mp4' />
	</video>
	<script type="text/javascript">
			$(document).ready(function($)
			{
				$('#example_video_1').css('width','100%');
				$('#example_video_1').css('height','100%');
					setTimeout(function() {
					    $('#example_video_1').css('width','100%');
						$('#example_video_1').css('height','100%');
						$( "*" ).delay(200).animate({opacity: 1}, 300);
					}, 150);
			});
	</script>
</body>
</html>



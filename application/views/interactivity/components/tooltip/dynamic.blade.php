<?php
if(!isset($transparent)) $transparent = 0;
if(!isset($bgcolor)) $bgcolor = '#151515';
if(!isset($iconcolor)) $iconcolor = '#da0606';
if(!isset($boxopacity)) $boxopacity = 1;
if($transparent == 1)
{
	$bgcolor = "transparent";
	$boxopacity = 0;
}


$vFile = path('public').$filename;
if(File::exists($vFile) && is_file($vFile)) {
    $fname = File::name($vFile);
    $fext = File::extension($vFile);
    $vFile = $fname.'.'.$fext;
}
else {
    $vFile = '';
}

if(!$preview)
{
    $vFile = $baseDirectory.'comp_'.$id.'/'.$vFile;
}
else
{
    $vFile = '/'.$filename;
}

$vFile2 = path('public').$filename2;
if(File::exists($vFile2) && is_file($vFile2)) {
    $fname2 = File::name($vFile2);
    $fext2 = File::extension($vFile2);
    $vFile2 = $fname2.'.'.$fext2;
}
else {
    $vFile2 = '';
}

if(!$preview)
{
    $vFile2 = $baseDirectory.'comp_'.$id.'/'.$vFile2;
}
else
{
    $vFile2 = '/'.$filename2;
}

//hex to rgb
$hex = str_replace("#", "", $bgcolor);

if(strlen($hex) == 3) {
  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
} else {
  $r = hexdec(substr($hex,0,2));
  $g = hexdec(substr($hex,2,2));
  $b = hexdec(substr($hex,4,2));
}
$rgb = array($r, $g, $b);

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8" />
	<title>GalePress</title>
	<meta name="description" content="" />
	<meta name="keywords" value="" />
	<meta name="viewport" content="width=100%, initial-scale=1, maximum-scale=1"/>
	<link rel="stylesheet" href="{{ $baseDirectory }}comp_{{ $id }}/css/layout.css" type="text/css" />
	<link rel="stylesheet" href="{{ $baseDirectory }}comp_{{ $id }}/css/hotspot.css" type="text/css" />
	<style type="text/css">
	body{
		position: absolute;
		width: 100%;
		height: 100%;
	}
	#hotspot{
		position: absolute;
	}
	.hs-spot-object{
		{{($init == 'right' || $init == 'bottom' ? 'top:0; left:0;' : ($init == 'left' ? 'top:0; right:0;' : ($init == 'top' ? 'bottom:0; left:0;' : '')))}};
	}
	@if($option == 2)
	.hs-spot-object{
		background-image: url("{{$vFile}}");
		background-repeat: no-repeat;
	}
	@endif
	.hs-spot.visible .hs-spot-shape-inner{
		background: {{ $iconcolor }} !important;
	}
	@if( $init == "right")
	.hs-spot-object.right .hs-tooltip:before{
		border-right: 8px solid rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }}) !important;
	}
	@elseif( $init == "left")
	.hs-spot-object.left .hs-tooltip:before{
		border-left: 8px solid rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }}) !important;
	}
	@elseif( $init == "top")
	.hs-spot-object.top .hs-tooltip:before{
		border-top: 8px solid rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }}) !important;
	}
	@elseif( $init == "bottom")
	.hs-spot-object.bottom .hs-tooltip:before{
		border-bottom: 8px solid rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }}) !important;
	}
	@endif
	.hs-tooltip{
		background: rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }}) !important;
		padding: 0;
		padding-left: 10px;
  		padding-right: 10px;
  		@if($option==1)
		margin: auto 1px;
		@endif
	}
	.hs-tooltip-wrap{
		padding: 0 !important;
		/*top: 0 !important;*/
		{{($init == 'right' ? 'top:0 !important;' : ($init == 'left' ? 'top:0 !important;' : ($init == 'top' ? 'left:0 !important;' : '')))}};
	}
	*{
		-webkit-tap-highlight-color: transparent !important;
	}
	#myScrollableDiv{
		padding-top: 5px;
	}
	#myScrollableDiv p{
		word-wrap: break-word;
		overflow-y: scroll;
		overflow-x: hidden;
	}
	</style>
</head>
<body>
	<div id="hotspot" class="hs-wrap hs-loading">
		@if( $option==1)
		<div class="hs-spot-object" data-type="spot" data-popup-position="{{ $init }}" data-visible="visible">
			<div id="myScrollableDiv">
				{{ $content }}
			</div>
    		<br>
		</div>
		@endif
		@if( $option==2)
		<div class="hs-spot-object" data-type="spot" data-popup-position="{{ $init }}" data-visible="invisible">
			<div id="myScrollableDiv">
    			{{ $content }}
    		</div>
    		<br>
		</div>
		@endif
	</div>

	<script src="{{ $baseDirectory }}comp_{{ $id }}/js/lib/jquery-1.7.1.min.js"></script>
	<script src="{{ $baseDirectory }}comp_{{ $id }}/js/hotspot.js"></script>
	<script>
		$(document).ready(function() {
			$('#hotspot').hotspot({ "show_on" : "click" });
			@if( $option==1)
			function opacityAnimate(){
				$('.hs-spot-shape').animate({ opacity: 0.25 }, function(){ 
					$(this).animate({ opacity: 0.15 },opacityAnimate())
				});
			}
			opacityAnimate();
			@endif
			@if($option==2)
			var focused=false;
			$('#hotspot').click(function(){
				if(!focused)
				{
					$('.hs-spot-object').css('background-image','url("' + <?php echo json_encode($vFile2) ?> + '")');
					focused=true;
				}	
				else
				{
					$('.hs-spot-object').css('background-image','url("' + <?php echo json_encode($vFile) ?> + '")');
					focused=false;
				}
			});
			@endif

			var bodyHeight=$(window).height();
			var bodyWidth=$(window).width();

			var bodyWidthFromTasarlayici={{$w}};
			var bodyHeightFromTasarlayici={{$h}};

			var calcBodyWidth=(bodyWidthFromTasarlayici/bodyWidth)*100;
			var calcBodyHeight=(bodyHeightFromTasarlayici/bodyHeight)*100;

			$('#hotspot').css('width',calcBodyWidth+'%').css('height',calcBodyHeight+'%');
			
			@if($option==2)
			var image = new Image();
			image.src = "{{$vFile}}";
			image.onload = function() {
				var imgWidth=this.width;
				var calcWidth=(imgWidth/bodyWidthFromTasarlayici)*100;
				var imgHeight=this.height;
				var calcHeight=(imgHeight/bodyHeightFromTasarlayici)*100;

				$('#image').css('height',calcHeight+'%');
				
				$('.hs-spot-object').css('width',calcWidth+'%').css('height',calcHeight+'%').css('position','fixed');
				$('.hs-spot-object').css('background-size','100% 100%');

				var diffIconWidth = (calcWidth * bodyWidthFromTasarlayici)/100;
				var diffIconHeight = (calcHeight * bodyHeightFromTasarlayici)/100;
				$('.hs-tooltip-wrap').css('width',(bodyWidth-diffIconWidth)+'px');
				$('.hs-tooltip').css('height',bodyHeight+'px');
				$('#myScrollableDiv p').css('height',bodyHeight+'px');

				@if($init=="top")
				$('.hs-tooltip').css('height',(bodyHeight-diffIconHeight)+'px');
				$('.hs-tooltip').css('top','0').css('position','fixed');
				$('#myScrollableDiv p').css('height',(bodyHeight-diffIconHeight)+'px');
				@endif

				@if($init=="bottom")
				$('.hs-tooltip').css('height',(bodyHeight-diffIconHeight)+'px');
				$('#myScrollableDiv p').css('height',(bodyHeight-diffIconHeight)+'px');
				@endif
			};
			@endif
			/**********img.load fonksiyonu sebebiyle kodlarin tekrarlanmasi lazim**********/
			@if($option==1)
				var imgWidth=30;
				var calcWidth=(imgWidth/bodyWidthFromTasarlayici)*100;
				var imgHeight=30;
				var calcHeight=(imgHeight/bodyHeightFromTasarlayici)*100;
			
				$('#image').css('height',calcHeight+'%');
				
				$('.hs-spot-object').css('width',calcWidth+'%').css('height',calcHeight+'%').css('position','fixed');
				$('.hs-spot-object').css('background-size','100% 100%');

				var diffIconWidth = (calcWidth * bodyWidthFromTasarlayici)/100;
				var diffIconHeight = (calcHeight * bodyHeightFromTasarlayici)/100;
				$('.hs-tooltip-wrap').css('width',(bodyWidth-diffIconWidth)+'px');
				$('.hs-tooltip').css('height',bodyHeight+'px');
				$('#myScrollableDiv p').css('height',bodyHeight+'px');

				@if($init=="top")
				$('.hs-tooltip').css('height',(bodyHeight-diffIconHeight)+'px');
				$('.hs-tooltip').css('top','0').css('position','fixed');
				$('#myScrollableDiv p').css('height',(bodyHeight-diffIconHeight)+'px');
				@endif
				
				@if($init=="bottom")
				$('.hs-tooltip').css('height',(bodyHeight-diffIconHeight)+'px');
				$('#myScrollableDiv p').css('height',(bodyHeight-diffIconHeight)+'px');
				@endif
			@endif
		});
	</script>
</body>
</html>
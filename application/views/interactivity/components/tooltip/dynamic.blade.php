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
	}
	.hsmap-image{
		display: none !important;
	}
	*{
		-webkit-tap-highlight-color: transparent !important;
	}
	#myScrollableDiv{
		word-wrap: break-word;
	}
	/**/
	</style>
</head>
<body style="width:100%;height:100%;">
	<div id="hotspot" class="hs-wrap hs-loading" style="position: absolute; {{($init == 'right' || $init == 'bottom' ? 'top:12px; left:12px;' : ($init == 'left' ? 'top:12px; right:32px;' : ($init == 'top' ? 'bottom:32px; left:12px;' : '')))}}">
		@if( $option==1)
		<div class="hs-spot-object" data-type="spot" data-width="30" data-height="30" data-popup-position="{{ $init }}" data-visible="visible">
			<div id="myScrollableDiv">
				{{ $content }}
			</div>
    		<br>
		</div>
		@endif
		@if( $option==2)
		<div class="hs-spot-object" data-type="spot" data-width="{{$iconwidth}}" data-height="{{$iconheight}}" data-popup-position="{{ $init }}" data-visible="invisible">
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
			$('#hotspot').hide();
			$('#hotspot').hotspot({ "show_on" : "click" });
			@if( $option==1)
			<?php $iconwidth=49;?>
			function opacityAnimate(){
				$('.hs-spot-shape').animate({ opacity: 0.25 }, function(){ 
					$(this).animate({ opacity: 0.15 },opacityAnimate())
				});
			}
			opacityAnimate();
			@endif
			setTimeout(function(){
				var heightCalc=$(document).height()-77;
				if({{$iconheight}}>0 && {{$option}}==2)
				{
					heightCalc-={{$iconheight}};
				}
				$('#hotspot').fadeIn(500);
				$('.hs-tooltip').css("height",heightCalc);
				$('.hs-tooltip #myScrollableDiv').css("height",heightCalc).css("overflow-y","scroll");
				$('.hs-tooltip-wrap').css('width',$(document).width()-{{$iconwidth}}-35);
				@if( $option==2 && $init=='left')
				$('#hotspot').css('right',{{$iconwidth}}+1);
				$('.hs-tooltip-wrap').css('width',$(document).width()-{{$iconwidth}}-17);
				@endif
				@if( $option==2 && $init=='right')
				$('.hs-tooltip').css("height",heightCalc+{{$iconheight}});
				$('.hs-tooltip #myScrollableDiv').css("height",heightCalc+{{$iconheight}});
				@endif
				@if( $option==2 && $init=='top')
				$('#hotspot').css('bottom',{{$iconheight}});
				$('.hs-tooltip').css("height",heightCalc);
				$('.hs-tooltip #myScrollableDiv').css("height",heightCalc);
				$('.hs-tooltip-wrap').css('width',$(document).width()-35);
				@endif
				@if( $option==2 && $init=='bottom')
				$('#hotspot').css('top',1).css('left',1);
				$('.hs-tooltip').css("height",heightCalc);
				$('.hs-tooltip #myScrollableDiv').css("height",heightCalc);
				$('.hs-tooltip-wrap').css('width',$(document).width()-35);
				@endif
				@if( $option==1 && $init=='top')
				$('#hotspot').css('bottom',31);
				$('.hs-tooltip').css("height",heightCalc);
				$('.hs-tooltip #myScrollableDiv').css("height",heightCalc);
				$('.hs-tooltip-wrap').css('width',$(document).width()-35);
				@endif
				@if( $option==1 && $init=='bottom')
				$('#hotspot').css('top',1).css('left',1);
				$('.hs-tooltip').css("height",heightCalc);
				$('.hs-tooltip #myScrollableDiv').css("height",heightCalc);
				$('.hs-tooltip-wrap').css('width',$(document).width()-15);
				@endif
			},200);
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
			})
			@endif
		});
	</script>
</body>
</html>
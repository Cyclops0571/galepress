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
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
	<link href="{{ $baseDirectory }}comp_{{ $id }}/css/prettify.css" type="text/css" rel="stylesheet" />
	<style type="text/css">
	body{
		overflow: hidden;
	}
	*{
		margin: 0;
		padding: 0;
		-webkit-tap-highlight-color: transparent !important;
	}
	.hs-spot-object{
		position: fixed;
		cursor: pointer;
		z-index:1;
		@if($option == 1)
		width: auto;
		height:auto;
		border-radius:50%;
	    -moz-border-radius:50%;
	    -webkit-border-radius:50%;
	    -khtml-border-radius: 50%;
		color: #058ae5;
		border: 2px solid #d2d2d2;
		background: {{ $iconcolor }};
		padding: 6%;
		background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANtJREFUeNrs2LENwjAQhWHbgt59Go/ABuANmCYt1HTZADZgA9gARqChT5+GO8USJBLlRUr0P+kUuYn1OXKK551h1qd3lMdNZiPTyuSurp5W+wVnm32BaBR2sNzMGpNG6zhnzKQBAwYMGDBgwIABAwYMGDBgwPyNL3WQtijJ4P1bmd3P+iVzMdhHa6yrYh7uWwfNOW1YCEQTQ/lEi8hKJru+abQo6NLoLurBWdWzjbc8KbmPRzesZO9dXWV+zWDAgAEDBgwYMGDAgAEDBgwYMBNhzm7YyzWWm30EGADiORxNIOidwAAAAABJRU5ErkJggg==');
		background-size: 75% 75%;
		background-repeat: no-repeat;
		background-position: center center;
		@endif
		{{($init == 'right' || $init == 'bottom' ? 'top:1px; left:1px;' : ($init == 'left' ? 'top:1px; right:1px;' : ($init == 'top' ? 'bottom:1px; left:1px;' : '')))}};
	}
	.hs-spot-object .hs-spot-object-inner{
		background: {{ $iconcolor }} !important;
	}
	@if($option == 2)
	.hs-spot-object{
		background-image: url("{{$vFile}}");
		background-size: 100% 100%;
		background-repeat: no-repeat;
	}
	@endif
	#myScrollableDiv{
		position: fixed;
		word-wrap: break-word;
		overflow-y: scroll;
		overflow-x: hidden;
		z-index:0;
		background: rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }});
		text-align:center;
	}
	#myScrollableDiv p,#myScrollableDiv div{
		padding: 8% 15% 8% 1%;
	}
	.closed{
		display: none;
	}
	/*SCROLLBAR ADDITIONAL STYLES*/
	.slimScrollDiv{
		position: fixed !important;
		display: none;

	}
	.slimScrollBar{
		background: #058ae5 !important;
		-webkit-box-shadow: 1px 1px 3px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 1px 1px 3px 0px rgba(0,0,0,0.75);
		box-shadow: 1px 1px 3px 0px rgba(0,0,0,0.75);
		right: 2.5% !important;
		width: 5% !important;
		opacity: 0.75 !important;
		margin: 1.5% 2%;
	}
	.slimScrollRail{
		right: 4% !important;
		width: 3% !important;
		margin: 1.5% 1.3%;
		height: 97% !important;
	}
	</style>
</head>
<body>
	<div class="hs-spot-object" style="display:none;"></div>
	<div id="myScrollableDiv" class="closed">
		{{$content}}
	</div>
	<script src="{{ $baseDirectory }}comp_{{ $id }}/lib/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/prettify.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery.slimscroll.min.js"></script>
	<script>
		$(document).ready(function() {

			$('#myScrollableDiv').slimScroll({
		      alwaysVisible: true,
		      railVisible: true
		  	});
			
			var bodyHeight=$(document).height();
			var bodyWidth=$(document).width();

			var bodyWidthFromTasarlayici={{$w}};
			var bodyHeightFromTasarlayici={{$h}};

			var calcIconWidth=(35/bodyWidthFromTasarlayici)*100;
			$('.hs-spot-object').css('padding',(calcIconWidth/2)+'%');
			$('.hs-spot-object').fadeIn(1000);

			@if($option==1)
			$('.hs-spot-object').click(function(){
				if($('#myScrollableDiv').hasClass('closed'))
				{
					setTimeout(function(){
						$('#myScrollableDiv').slimScroll().attachWheel;
						// $('.slimScrollBar').scrollTop(10);
					},500);
					$('#myScrollableDiv,.slimScrollDiv').removeClass('closed').css('display','block');
					$(this).css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAadJREFUeNrU2sttwkAQBuD9LeWee5pIB4gKUkKggoQLReQCHUAnKQGniNy555JZwJJl2d7XzOx4pJHBzIr5JFhpVoajePr6PdDl092jpVz/7V+uzngM+wbd8G8OgzrzIOr7RJdN/15DuRqpfaX8pgXPS4F0mJ+JNSZBU5AOc6S8LgE0B7lhHv+LtXVQCEKxRa/41jTlVNPVNoUYCPV1xmCROVAsxL/AyGIzoBTIKMYKKBUyiakNyoHMYmqBciFBjDaoBBKF0QKVQqIx0iAOSBJGCsQFScZwgzghWRguEDckG1MKkoAUYXJBUpBiTCpIEsKCSQC1khA2TCTISUJYMQUgFgg7JgPEBhHB9ECXQNmOIEfO722EZquPiJp37kMSiZ9ZaPsVm4dQEcIOahQh4udyjRJk6xQOGqEB6bZf6YkVWhCNiRWaEGkQtCGSINSASIFQCyIBQk0INwi1IZwgWIBwgWAFwgGCJUgpCNYgJSBYhOSCYBWSA4JlSCoI1iEpIP9Uk0ecLENiQX7SfFsCxAf10s5NrHNPNZmCxIA85jzygUlICPQvwAAYXM4RLb8QqQAAAABJRU5ErkJggg==')");
					$(this).css('background-size','60% 60%');
				}	
				else
				{
					checkAndroid();
					$('#myScrollableDiv,.slimScrollDiv').addClass('closed').css('display','none');;
					$(this).css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANtJREFUeNrs2LENwjAQhWHbgt59Go/ABuANmCYt1HTZADZgA9gARqChT5+GO8USJBLlRUr0P+kUuYn1OXKK551h1qd3lMdNZiPTyuSurp5W+wVnm32BaBR2sNzMGpNG6zhnzKQBAwYMGDBgwIABAwYMGDBgwPyNL3WQtijJ4P1bmd3P+iVzMdhHa6yrYh7uWwfNOW1YCEQTQ/lEi8hKJru+abQo6NLoLurBWdWzjbc8KbmPRzesZO9dXWV+zWDAgAEDBgwYMGDAgAEDBgwYMBNhzm7YyzWWm30EGADiORxNIOidwAAAAABJRU5ErkJggg==')");
					$(this).css('background-size','75% 75%');
				}
				render();
			});
			@endif

			@if($option==2)
			$('.hs-spot-object').click(function(){
				if($('#myScrollableDiv').hasClass('closed'))
				{
					$(this).css('background-image','url("' + <?php echo json_encode($vFile2) ?> + '")');
					$('#myScrollableDiv,.slimScrollDiv').removeClass('closed').css('display','block');
				}	
				else
				{
					checkAndroid();
					$(this).css('background-image','url("' + <?php echo json_encode($vFile) ?> + '")');
					$('#myScrollableDiv,.slimScrollDiv').addClass('closed').css('display','none');;
				}
			});

			var calcHeight;
			var calcWidth;
			var image = new Image();
			image.src = "{{$vFile}}";
			image.onload = function() {
				var imgWidth={{$iconwidth}};
				calcWidth=(imgWidth/bodyWidthFromTasarlayici)*100;
				var imgHeight={{$iconheight}};
				calcHeight=(imgHeight/bodyHeightFromTasarlayici)*100;
				$('.hs-spot-object').css('width',calcWidth+'%').css('height',calcHeight+'%');
				render();
			};
			@endif

			function render(){
				var spotWidth = $('.hs-spot-object').outerWidth();
				var spotHeight = $('.hs-spot-object').outerHeight();

				  ('{{$init}}' == 'right' || '{{$init}}' == 'bottom' ? $('#myScrollableDiv').css('left',spotWidth/2).css('top',spotHeight/2)
				: ('{{$init}}' == 'left' ? $('#myScrollableDiv').css('right',spotWidth/2).css('top',spotHeight/2)
				: ('{{$init}}' == 'top' ? $('#myScrollableDiv').css('left',spotWidth/2).css('bottom',spotHeight/2) : '')));

				@if($option==1)
				  $('#myScrollableDiv').css('width',100-spotWidth/2+'%');
				  $('#myScrollableDiv').css('height',100-spotHeight/2+'%');
				@endif
				@if($option==2)
				  $('#myScrollableDiv').css('width',(100-calcWidth)-10+'%');
				  $('#myScrollableDiv').css('height',(100-calcHeight)-10+'%');
				@endif
				$('.slimScrollDiv').attr('style',$('#myScrollableDiv').attr('style'));
			}
			function checkAndroid(){
				var ua = navigator.userAgent.toLowerCase();
				var isAndroid = ua.indexOf("android") > -1;
				if(isAndroid) {
					$('.hs-spot-object').fadeOut( 500, function() {
				    	window.location.reload();
				  	});
				};
			}
		});
	</script>
</body>
</html>
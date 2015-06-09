<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>GalePress</title>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
	<link href="{{ $baseDirectory }}comp_{{ $id }}/css/prettify.css" type="text/css" rel="stylesheet" />
	<style type="text/css">
		html,body{
			margin: 0;
			padding: 0;	
		}
		.overview{
			width: 100%;
			height: 100% !important;
			padding: 0 10%;
		}
		.slimScrollDiv{
			position: fixed !important;
			height: 100% !important;
		}
	</style>
</head>
<body>
	<div class="overview">
     	{{$content}}
	</div>
	<script src="{{ $baseDirectory }}comp_{{ $id }}/lib/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/prettify.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery.slimscroll.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.overview').slimScroll({
	      alwaysVisible: true,
	      railVisible: true
	  	});
     	var ua = navigator.userAgent.toLowerCase();
		var isAndroid = ua.indexOf("android") > -1;
		var isMobile = ua.indexOf("mobile") > -1;
		if(isAndroid && isMobile) {
			document.body.style.fontSize = "50%";
		}
		else if(isAndroid){ //KARICALANMA PROBLEMİ İÇİN...
			setInterval(function(){
				$('body').css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M0FGRDNDQ0EwRUIwMTFFNThENTJGODhCQzcyNDE1NjQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6M0FGRDNDQ0IwRUIwMTFFNThENTJGODhCQzcyNDE1NjQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozQUZEM0NDODBFQjAxMUU1OEQ1MkY4OEJDNzI0MTU2NCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozQUZEM0NDOTBFQjAxMUU1OEQ1MkY4OEJDNzI0MTU2NCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhYwDdYAAAAPSURBVHjaYvj//z9AgAEABf4C/i3Oie4AAAAASUVORK5CYII=')");
			},100);
		}
	});
    </script>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>GalePress</title>
	<meta name="viewport" content="width=device-width,user-scalable=no" />
	<link rel="stylesheet" href="{{ $baseDirectory }}comp_{{ $id }}/css/website.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}comp_{{ $id }}/js/jquery.tinyscrollbar.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#scrollbar1").tinyscrollbar({ trackSize: 250, scrollInvert : true });
		});
	</script>
    <style type="text/css">
		.viewport{
			position: fixed !important;
			top: 0 !important;;
			left: 0 !important;;
		}
		*{
			padding: 0 !important;
		}
		.scrollbar{
			display: none;
		}
    </style>
</head>
<body>
	<div id="scrollbar1">
		<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
		<div class="viewport">
			 <div class="overview">
             	{{ $content }}<br>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('.viewport').width(100 + '%');
		$('.viewport').height(100 + '%');
		$( "p" ).first().css( "margin-top", "0" );
	</script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>GalePress</title>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
	<style type="text/css">
		html,body{
			margin: 0;
			padding: 0;	
		}
		.overview{
			position: absolute;
			width: 100%;
			height: 100%;
			overflow-y: scroll;
			overflow-x: hidden;
		}

	</style>
</head>
<body>
	<div class="overview">
     	{{$content}}
	</div>
	<script type="text/javascript">
     	var ua = navigator.userAgent.toLowerCase();
		var isAndroid = ua.indexOf("android") > -1;
		var isMobile = ua.indexOf("mobile") > -1;
		if(isAndroid && isMobile) {
			document.body.style.fontSize = "50%";
		}
     </script>
</body>
</html>
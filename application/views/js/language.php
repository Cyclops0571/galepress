<script type="text/javascript">
	<!--
	var route = new Array();
	<?php
	// For language cache
	$langRoute = __('route.login')->get();
	$langNotification = __('notification.success')->get();
	$langNotification = __('interactivity.ok')->get();
	
	$keys = Lang::$lines["application"][Session::get('language')]["route"];
	foreach($keys as $key => $val) {
		
		echo 'route["'.$key.'"] = "'.$val.'";'."\n";
	}

	echo 'var notification = new Array();'."\n";
	$keys = Lang::$lines["application"][Session::get('language')]["notification"];
	foreach($keys as $key => $val) {
		
		echo 'notification["'.$key.'"] = "'.$val.'";'."\n";
	}
	
	if(!(strrpos(Request::uri(), __('route.interactivity')->get()) === false))
	{
		echo 'var interactivity = new Array();'."\n";
		$keys = Lang::$lines["application"][Session::get('language')]["interactivity"];
		foreach($keys as $key => $val) {
			
			echo 'interactivity["'.$key.'"] = "'.$val.'";'."\n";
		}
	}
	?>
	// -->
</script>

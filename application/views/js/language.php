<script type="text/javascript">
	<!--
	var route = new Array();
	<?php
	// For language cache
	$langRoute = __('route.login')->get();
	$langNotification = __('interactivity.ok')->get();
	$myCurrentLang = Session::get('language') != NULL ? Session::get('language') : 'tr';
	
	$keys = \Laravel\Lang::$lines["application"][$myCurrentLang]["route"];
	foreach($keys as $key => $val) {
		echo 'route["'.$key.'"] = "'.$val.'";'."\n";
	}

	echo 'var notification = new Array();'."\n";
	echo "//" . __('notification.validation') . "\n"; //eager loading... notification onceden yuklensin diye yapiyorum bunu.
	if(isset(\Laravel\Lang::$lines["application"][$myCurrentLang]["notification"])) {
	    $notificationKeys = \Laravel\Lang::$lines["application"][$myCurrentLang]["notification"];
	    foreach($notificationKeys as $key => $val) {
		    echo 'notification["'.$key.'"] = "'.$val.'";'."\n";
	    }
	}
	
	if(!(strrpos(Request::uri(), __('route.interactivity')->get()) === false))
	{
		echo 'var interactivity = new Array();'."\n";
		$interactivityKeys = \Laravel\Lang::$lines["application"][$myCurrentLang]["interactivity"];
		foreach($interactivityKeys as $key => $val) {
			
			echo 'interactivity["'.$key.'"] = "'.$val.'";'."\n";
		}
	}
	?>
	// -->
</script>

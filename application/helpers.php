<?php

HTML::macro('nav_link', function($route, $text)
{
    $class = (URI::is($route) || URI::is($route.'/*')) ? ' class="active"' : '';
    $href = URL::to($route);
    
    $action = Request::route();
    $action = $action->action;
    
    if(isset($action['as']))
    {
        $class = (($action['as'] == $route) || ($action['as'] == $route.'/*')) ? ' class="active"' : '';
        //$href = URL::to_route($route);
    }
    
    return '<li'.$class.'><a href="'.$href.'">'.$text.'</a></li>';
});

HTML::macro('oddeven', function($name = 'default')
{
	static $status = array();

	if(!isset($status[$name]))
	{
		$status[$name] = 0;
	}

	$status[$name] = 1 - $status[$name];
	return ($status[$name] % 2 == 0) ? 'even' : 'odd';
});


function localDateFormat($format = 'dd.MM.yyyy') {
    $currentLang = Config::get('application.language');
    if($currentLang != 'usa') {
	return $format;
    } else {
	if($format == 'dd.MM.yyyy') {
	    return 'mm/dd/yyyy';
	}
    }
    
}
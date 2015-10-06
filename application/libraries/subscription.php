<?php

class Subscription {
    const week = 1;
    const mounth = 2;
    const year = 3;
    
    public static function types() {
	return array(
	    1 => "week_subscription",
	    2 => "month_subscription",
	    3 => "year_subscription",
	);
    }
    
}

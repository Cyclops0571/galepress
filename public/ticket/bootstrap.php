<?php
/**
 * 	Support Tickets		- Bootstrap for application use
 *	Copyright Dalegroup Pty Ltd 2013
 *	support@dalegroup.net
 *
 *
 * @package     tickets
 * @author      Michael Dale <mdale@dalegroup.net>
 */

namespace sts;

//it would be nice to have this above the namespace as currently it isn't too useful.
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	die('This program requires PHP 5.3.0 or higher to run.');
}

//get the directory root info
define(__NAMESPACE__ . '\ROOT', __DIR__);
define(__NAMESPACE__ . '\SYSTEM', ROOT . '/system');
if (isset($_COOKIE['ticket_user_lang'])) {
    switch ($_COOKIE['ticket_user_lang']) {
        case 'tr':
            define(__CURRENT_LANGUAGE__, 'tr');
            break;
        default:
            define(__CURRENT_LANGUAGE__, 'en');
            break;
    }
} else {
    define(__CURRENT_LANGUAGE__, 'en');
}
/**
 * Loader does all the important startup stuff.
 */	
include(SYSTEM . '/loader.php');


?>
<?php
function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if(!isset($_SERVER["REMOTE_ADDR"])) {
	return $output;
    }
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
	$ip = $_SERVER["REMOTE_ADDR"];
	if ($deep_detect) {
	    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
    }
    $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
	"AF" => "Africa",
	"AN" => "Antarctica",
	"AS" => "Asia",
	"EU" => "Europe",
	"OC" => "Australia (Oceania)",
	"NA" => "North America",
	"SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
	$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
	if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
	    switch ($purpose) {
		case "location":
		    $output = array(
			"city" => @$ipdat->geoplugin_city,
			"state" => @$ipdat->geoplugin_regionName,
			"country" => @$ipdat->geoplugin_countryName,
			"country_code" => @$ipdat->geoplugin_countryCode,
			"continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
			"continent_code" => @$ipdat->geoplugin_continentCode
		    );
		    break;
		case "address":
		    $address = array($ipdat->geoplugin_countryName);
		    if (@strlen($ipdat->geoplugin_regionName) >= 1)
			$address[] = $ipdat->geoplugin_regionName;
		    if (@strlen($ipdat->geoplugin_city) >= 1)
			$address[] = $ipdat->geoplugin_city;
		    $output = implode(", ", array_reverse($address));
		    break;
		case "city":
		    $output = @$ipdat->geoplugin_city;
		    break;
		case "state":
		    $output = @$ipdat->geoplugin_regionName;
		    break;
		case "region":
		    $output = @$ipdat->geoplugin_regionName;
		    break;
		case "country":
		    $output = @$ipdat->geoplugin_countryName;
		    break;
		case "countrycode":
		    $output = @$ipdat->geoplugin_countryCode;
		    break;
	    }
	}
    }
    return $output;
}

$defaultLang = 'tr';
$userInfo = ip_info();
if(!empty($userInfo) && !empty($userInfo["country_code"]) &&  $userInfo["country_code"] != "TR") {
    $defaultLang = 'usa';
}

if (Laravel\Request::env() == ENV_TEST) {
    $defaultLang = 'usa';
} else if (Laravel\Request::env() == ENV_LOCAL) {
    $defaultLang = 'usa';
}

return array(
    /*
      |--------------------------------------------------------------------------
      | Application URL
      |--------------------------------------------------------------------------
      |
      | The URL used to access your application without a trailing slash. The URL
      | does not have to be set. If it isn't, we'll try our best to guess the URL
      | of your application.
      |
     */

    'url' => '',
    /*
      |--------------------------------------------------------------------------
      | Asset URL
      |--------------------------------------------------------------------------
      |
      | The base URL used for your application's asset files. This is useful if
      | you are serving your assets through a different server or a CDN. If it
      | is not set, we'll default to the application URL above.
      |
     */
    'asset_url' => '',
    /*
      |--------------------------------------------------------------------------
      | Application Index
      |--------------------------------------------------------------------------
      |
      | If you are including the "index.php" in your URLs, you can ignore this.
      | However, if you are using mod_rewrite to get cleaner URLs, just set
      | this option to an empty string and we'll take care of the rest.
      |
     */
    'index' => '',
    /*
      |--------------------------------------------------------------------------
      | Application Key
      |--------------------------------------------------------------------------
      |
      | This key is used by the encryption and cookie classes to generate secure
      | encrypted strings and hashes. It is extremely important that this key
      | remains secret and it should not be shared with anyone. Make it about 32
      | characters of random gibberish.
      |
     */
    'key' => 'jG0iWqpgISTfmrunAxNBizUmLAiHMRx0',
    /*
      |--------------------------------------------------------------------------
      | Profiler Toolbar
      |--------------------------------------------------------------------------
      |
      | Laravel includes a beautiful profiler toolbar that gives you a heads
      | up display of the queries and logs performed by your application.
      | This is wonderful for development, but, of course, you should
      | disable the toolbar for production applications.
      |
     */
    'profiler' => false,
    /*
      |--------------------------------------------------------------------------
      | Application Character Encoding
      |--------------------------------------------------------------------------
      |
      | The default character encoding used by your application. This encoding
      | will be used by the Str, Text, Form, and any other classes that need
      | to know what type of encoding to use for your awesome application.
      |
     */
    'encoding' => 'UTF-8',
    /*
      |--------------------------------------------------------------------------
      | Default Application Language
      |--------------------------------------------------------------------------
      |
      | The default language of your application. This language will be used by
      | Lang library as the default language when doing string localization.
      |
     */
    'language' => $defaultLang,
    /*
      |--------------------------------------------------------------------------
      | Supported Languages
      |--------------------------------------------------------------------------
      |
      | These languages may also be supported by your application. If a request
      | enters your application with a URI beginning with one of these values
      | the default language will automatically be set to that language.
      |
     */
    'languages' => array('tr', 'en', 'de', 'usa'),
    // Languages with ID for quick lookup
    'langs' => array(
	'tr' => 1,
	'en' => 2,
	'de' => 3,
	'usa' => 4,
    ),
    /*
      |--------------------------------------------------------------------------
      | SSL Link Generation
      |--------------------------------------------------------------------------
      |
      | Many sites use SSL to protect their users' data. However, you may not be
      | able to use SSL on your development machine, meaning all HTTPS will be
      | broken during development.
      |
      | For this reason, you may wish to disable the generation of HTTPS links
      | throughout your application. This option does just that. All attempts
      | to generate HTTPS links will generate regular HTTP links instead.
      |
     */
    'ssl' => true,
    /*
      |--------------------------------------------------------------------------
      | Application Timezone
      |--------------------------------------------------------------------------
      |
      | The default timezone of your application. The timezone will be used when
      | Laravel needs a date, such as when writing to a log file or travelling
      | to a distant star at warp speed.
      |
     */
    'timezone' => 'Europe/Istanbul',
    /*
      |--------------------------------------------------------------------------
      | Class Aliases
      |--------------------------------------------------------------------------
      |
      | Here, you can specify any class aliases that you would like registered
      | when Laravel loads. Aliases are lazy-loaded, so feel free to add!
      |
      | Aliases make it more convenient to use namespaced classes. Instead of
      | referring to the class using its full namespace, you may simply use
      | the alias defined here.
      |
     */
    'aliases' => array(
	'Auth' => 'Laravel\\Auth',
	'Authenticator' => 'Laravel\\Auth\\Drivers\\Driver',
	'Asset' => 'Laravel\\Asset',
	'Autoloader' => 'Laravel\\Autoloader',
	'Blade' => 'Laravel\\Blade',
	'Bundle' => 'Laravel\\Bundle',
	'Cache' => 'Laravel\\Cache',
	'Config' => 'Laravel\\Config',
	'Controller' => 'Laravel\\Routing\\Controller',
	'Cookie' => 'Laravel\\Cookie',
	'Crypter' => 'Laravel\\Crypter',
	'DB' => 'Laravel\\Database',
	'Eloquent' => 'Laravel\\Database\\Eloquent\\Model',
	'Event' => 'Laravel\\Event',
	'File' => 'Laravel\\File',
	'Filter' => 'Laravel\\Routing\\Filter',
	'Form' => 'Laravel\\Form',
	'Hash' => 'Laravel\\Hash',
	'HTML' => 'Laravel\\HTML',
	'Input' => 'Laravel\\Input',
	'IoC' => 'Laravel\\IoC',
	'Lang' => 'Laravel\\Lang',
	'Log' => 'Laravel\\Log',
	'Memcached' => 'Laravel\\Memcached',
	'Paginator' => 'Laravel\\Paginator',
	'Profiler' => 'Laravel\\Profiling\\Profiler',
	'URL' => 'Laravel\\URL',
	'Redirect' => 'Laravel\\Redirect',
	'Redis' => 'Laravel\\Redis',
	'Request' => 'Laravel\\Request',
	'Response' => 'Laravel\\Response',
	'Route' => 'Laravel\\Routing\\Route',
	'Router' => 'Laravel\\Routing\\Router',
	'Schema' => 'Laravel\\Database\\Schema',
	'Section' => 'Laravel\\Section',
	'Session' => 'Laravel\\Session',
	'Str' => 'Laravel\\Str',
	'Task' => 'Laravel\\CLI\\Tasks\\Task',
	'URI' => 'Laravel\\URI',
	'Validator' => 'Laravel\\Validator',
	'View' => 'Laravel\\View',
    ),
);

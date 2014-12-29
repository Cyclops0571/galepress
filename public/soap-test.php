<?php
/*
 *	$Id: wsdlclient1.php,v 1.3 2007/11/06 14:48:48 snichol Exp $
 *
 *	WSDL client sample.
 *
 *	Service: WSDL
 *	Payload: document/literal
 *	Transport: http
 *	Authentication: none
 */
require($_SERVER["DOCUMENT_ROOT"]."/lib/nusoap-0.9.5/nusoap.php"); 

$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
//$client = new nusoap_client('http://www.galepress.com/soap.php?wsdl', 'wsdl', $proxyhost, $proxyport, $proxyusername, $proxypassword);
$client = new nusoap_client('http://localhost/soap.php?wsdl', 'wsdl', $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
// Doc/lit parameters get wrapped

$result = $client->call('getAppVersion', array('applicationID' => 10), '', '', false, true);
//$result = $client->call('getAppDetail', array('applicationID' => 10), '', '', false, true);
//$result = $client->call('getAppCategories', array('applicationID' => 10), '', '', false, true);
//$result = $client->call('getCategoryDetail', array('categoryID' => 167), '', '', false, true);
//$result = $client->call('getAppContents', array('applicationID' => 95), '', '', false, true);
//$result = $client->call('getAppContents', array('applicationID' => 10, 'applicationToken' => '', 'deviceToken' => '', 'username' => '', 'password' => ''), '', '', false, true);
//$result = $client->call('getAppContentsWithCategories', array('applicationID' => 10, 'applicationToken' => '', 'deviceToken' => '', 'username' => '', 'password' => '', 'categoryID' => -1), '', '', false, true);
//$result = $client->call('getAppContentsWithCategories', array('applicationID' => 10, 'applicationToken' => '', 'deviceToken' => '', 'username' => '', 'password' => '', 'categoryID' => 167), '', '', false, true);
//$result = $client->call('getContentVersion', array('contentID' => 1075), '', '', false, true);
//$result = $client->call('getContentDetail', array('contentID' => 1075), '', '', false, true);
//$result = $client->call('getContentDetailWithCategories', array('contentID' => 1075), '', '', false, true);
//$result = $client->call('getContentCoverImage', array('contentID' => 1075, 'size' => 1), '', '', false, true);
//$result = $client->call('getContentFile', array('contentID' => 1075, 'password' => "password"), '', '', false, true);
//$result = $client->call('submitStatistic', array('id' => '5', 'type' => "1", 'time' => "43"), '', '', false, true);
//$result = $client->call('submitStatisticWithApplicationID', array('id' => '5', 'type' => "1", 'time' => "43", 'lat' => "0", 'long' => "0", 'deviceID' => "0", 'applicationID' => "0", 'contentID' => "0", 'page' => "0", 'param5' => "0", 'param6' => "0", 'param7' => "0"), '', '', false, true);

// Check for a fault
if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r(htmlentities($result));
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
}
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';



/*
//$client = new nusoap_client('http://www.galepress.com/soap.php?wsdl', true);
$client = new nusoap_client('http://www.galepress.com/soap.php?wsdl', 'wsdl', '', '', '', '');

$result = $client->call('testFunction', 
    array('param'=>2322)
);

print_r($result);
*/

?>

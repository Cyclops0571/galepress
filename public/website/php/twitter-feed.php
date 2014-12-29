<?php
session_start();
require_once("twitteroauth/twitteroauth.php");

$twitteruser = "GalePress";
$notweets = 1;
$consumerkey = "0MRgvuU9hOczYbqD4Okc3Q";
$consumersecret = "8gpc71hTuZj5GKdI1ghVK5fgMFfNznFnAg8wkOnPfk";
$accesstoken = "867860762-wmTu8YFQsGbgNgsjFLUifdv7AUnm8g2X6wkVnHbE";
$accesstokensecret = "HaLOUGiMDxmFDmh3hvxoOBNSGxzYtbxf474cFVXXhKc";

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);

echo json_encode($tweets);
?>
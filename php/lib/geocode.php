<?php
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
/**
 * function to get latitude and longitude by address
 *
 * @param string $address profile address
 * @throws \InvalidArgumentException if $address is not a string or insecure
 *
 */
function getLatLongByAddress ($address) : \stdClass {
	if(empty($address) === true) {
		throw(new \InvalidArgumentException("address content is empty or insecure"));
	}
	$address = filter_var($address, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$url = 'https://maps.googleapis.com/maps/api/geocode/json';
	$config = readConfig("/etc/apache2/capstone-mysql/beer.ini");
	$api = $config["google"];
	$json = file_get_contents($url . '?address=' . urlencode($address) . '&key=' . $api);
	$jsonObject = json_decode($json);
	$lat = $jsonObject->results[0]->geometry->location->lat;
	$long = $jsonObject->results[0]->geometry->location->lng;
	$reply = new stdClass();
	$reply->lat = $lat;
	$reply->long = $long;
	return $reply;
}
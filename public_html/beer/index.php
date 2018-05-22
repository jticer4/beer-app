<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\Beer\{
	Beer,
	// we only use the profile class for testing purposes
	Profile
};

/**
 * Api for the Beer Class
 *
 * @author Deep Dive Coding, Cohort 20, Gang of Four
 */

//verify session, start if not active
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache/capstone-mysql/beer-app.ini");

	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$beerProfileId === filter_input(INPUT_GET, "beerProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// TODO get more information on what inputs are requisite for API calls

	//make sure the id is valid for methods that require it
	if (($method === "DELETE" || $method === "PUT") && empty($id) === true) {
		throw
		(new InvalidArgumentException("id cannot be empty", 405));
	}






} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

//encode and return replay to front end caller
header("Content-type: application/json");
echo json_encode($reply);


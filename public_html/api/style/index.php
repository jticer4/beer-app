<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Beer\Style;

/**
 * API for the Style class
 * @author <bkie3@cnm.edu>
 *
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/beer.ini");

	// determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// handle GET request - if id is present that style is returned, otherwise all styles are returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific style or all styles and update reply
		if(empty($id) === false) {
			$reply->data = Style::getStyleByStyleId($pdo, $id);
		} else {
			$reply->data = Style::getAllStyles($pdo)->toArray();
		}
	}
} catch(\Exception | \TypeError $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
}

// encode and return reply to the front end caller
header("Content-type: application/json");
echo json_encode($reply);


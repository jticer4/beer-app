<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Beer;
/**
*api for handling sign-in
*
* @author Carlos Marquez
*
**/
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apace2/capstone-mysql/beer-app.ini");
	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
		//make sure the XSRF Token is  valid
		verifyXsrf();
		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//check to make sure the password and email field is not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Wrong email address.", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("", 401));
		}
		//if the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null) {
			throw (new \InvalidArgumentException("you are not allowed to sign in unless you have activated your account", 403));
		}
		//hash the password  given to make sure it matches
		$hash = hash_pbkdf2("sha512", $profilePassword, $profile->getProfileSalt(), 262144);
		//verify that the hash is correct
		if($hash !== $profile->getProfileHash()) {
			throw(new \InvalidArgumentException("Password or email is incorrect.", 401));
		}
		if($profile->getProfilePrivilege() == "1") {
			$_SESSION["profile"] = $profile;
			$authObject = (object) [
				"profileId" =>$profile->getProfileId(),
				"profilePrivilege" => $profile->getProfilePrivilege()
			];
			// create
		}
	}
}

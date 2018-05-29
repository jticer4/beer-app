<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";

use Edu\Cnm\Beer\Profile;

/**
 * Cloudinary API for image upload
 *
 * @author brentTheDev | bkie3@cnm.edu
 * @version 1.01 modeled after Marty Bonacci aka BIG DADDY MUSTACHE
 * @team Fullstack PHP Cohort 20 | Gang of Four
 */


// start session
if(session_status() !==PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {

			// Grab the mySQL Connection
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/beer-app.ini");

			// determine which HTTP method is being used
			$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

			$profileId = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			$config = readConfig("/etc/apache2/capstone-mysql/beer-app.ini");
			$cloudinary = json_decode($config["cloudinary"]);
			\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

			// make sure the id is valid for methods that require it
			if($method === "POST") {

				// verify that the end user has XSRF token.
				verifyXsrf();

				if(empty($_SESSION["profile"]) === true) {
					throw (new \InvalidArgumentException("You must be logged in to upload images", 401));
				}

				// assigning variable to the user profile, add image extension
				$tempUserFileName = $_FILES["image"]["tmp_name"];

				// upload image to Cloudinary and get public id
				$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop"=> "scale"));

				// after sending the image to Cloudinary, get the image.
				$profile = Profile::getProfileByProfileId($pdo,$_SESSION["profile"]->getProfileId());
				if($profile === null) {
					throw(new RuntimeException("Profile not found", 404));
				}

				$profile->setProfileImage($cloudinaryResult["secure_url"]);
				$profile->update($pdo);
				$reply->message = "Image uploaded ok";
			}
} catch(Exception $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
echo json_encode($reply);
<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Beer\ {
	Profile
};

use Geocoder\StatefulGeocoder;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Http\Adapter\Guzzle6\Client;

/**
 * API for Profile
 *
 * @author Gkephart
 * @version 1.0
 */
//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/beer.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileUsername = filter_input(INPUT_GET, "profileUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileLocation = filter_input(INPUT_GET,"profileLocation", FILTER_VALIDATE_BOOLEAN);

	// make sure the id is valid for methods that require it
	if(($method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a profile
		if(empty($id) === false) {
			if($profileLocation === true) {
				$config = readConfig("/etc/apache2/capstone-mysql/beer.ini");
				$api = $config["google"];
				$guzzle = new Client();
				$google = new GoogleMaps($guzzle, "en", $api);
				$geocoder = new StatefulGeocoder($google);
				$profile = Profile::getProfileByProfileId($pdo, $id);

				//get profile address information
				$cat1 = $profile->getProfileAddressLine1();
				$cat2 = $profile->getProfileCity();
				$cat3 = $profile->getProfileState();
				$cat4 = $profile->getProfileZip();
				$finalFuzzy = $cat1 . " " . $cat2  . " " . $cat3  . " " . $cat4;

				//TODO grab city state zip from known breweries
				$result = $geocoder->geocodeQuery(GeocodeQuery::create($finalFuzzy));



				// $result = $geocoder->geocodeQuery(GeocodeQuery::create("Donald Trump's Competent Cabinet"));
				if(count($result) > 0) {
					$coordinates = $result->first()->getCoordinates();
					$reply->data = new stdClass();
					$reply->data->latitude = $coordinates->getLatitude();
					$reply->data->longitude = $coordinates->getLongitude();
				}
			} else {
				$reply->data = Profile::getProfileByProfileId($pdo, $id);
			}
		} else if(empty($profileActivationToken) === false) {
			$reply->data = Profile::getProfileByProfileActivationToken($pdo, $profileActivationToken);
			} else if(empty($profileEmail) === false) {
			$reply->data = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			} else if(empty($profileUsername) === false) {
			$reply->data = Profile::getProfileByProfileUsername($pdo, $profileUsername);
			}


	} elseif($method === "PUT") {
		//enforce that the XSRF token is present in the header
		verifyXsrf();
		//enforce the end user has a JWT token
		//validateJwtHeader();
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		validateJwtHeader();
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}
		//profile about | if null use the profile about that is in the database
		if(empty($requestObject->profileAbout) === true) {
			$requestObject->profileAbout = $profile->getProfileAbout();
		}
		//profile activation token | if null use the activation token that is in the database
		if(empty($requestObject->profileActivationToken) === true) {
			$requestObject->profileActivationToken = $profile->getProfileActivationToken();
		}
		//profile address line 1 | if null use the profile address that is in the database
		if(empty($requestObject->profileAddressLine1) === true) {
			$requestObject->profileAddressLine1 = $profile->getProfileAddressLine1();
		}
		//profile address line 2 | if null use the profile address that is in the database
		if(empty($requestObject->profileAddressLine2) === true) {
			$requestObject->profileAddressLine2 = $profile->getProfileAddressLine2();
		}
		//profile city | if null use the profile city that is in the database
		if(empty($requestObject->profileCity) === true) {
			$requestObject->profileCity = $profile->getProfileCity();
		}
		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("No profile email present", 405));
		}
		//profile name | if null use the profile name that is in the database
		if(empty($requestObject->profileName) === true) {
			$requestObject->profileName = $profile->getProfileName();
		}
		//profile state | if null use the profile state that is in the database
		if(empty($requestObject->profileState) === true) {
			$requestObject->profileState = $profile->getProfileState();
		}
		//profile username is a required field
		if(empty($requestObject->profileUsername) === true) {
			$requestObject->profileUsername = $profile->getProfileUsername();
		}
		//profile zip | if null use the profile zip that is in the database
		if(empty($requestObject->profileZip) === true) {
			$requestObject->profileZip = $profile->getProfileZip();
		}

		$profile->setProfileAbout($requestObject->profileAbout);
		$profile->setProfileAddressLine1($requestObject->profileAddressLine1);
		$profile->setProfileAddressLine2($requestObject->profileAddressLine2);
		$profile->setProfileCity($requestObject->profileCity);
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfileName($requestObject->profileName);
		$profile->setProfileState($requestObject->profileState);
		$profile->setProfileUsername($requestObject->profileUsername);
		$profile->setProfileZip($requestObject->profileZip);
		$profile->update($pdo);
		// update reply
		$reply->message = "Profile information updated";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
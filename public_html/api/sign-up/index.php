<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Beer\Profile;

/**
* api for handling sign-in
* @author Carlos Marquez
* @author James Ticer
**/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apace2/capstone-mysql/beer-app.ini");

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {

		//make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and email field is not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("No email address present", 405));
		}

		//verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//verify that the confirm password is present
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//if the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null) {
			throw (new \InvalidArgumentException("you are not allowed to sign in unless you have activated your account", 403));
		}

		$hash = password_hash($requestObject->profilePassword, PASSWORD_ARGON2I, ["time_cost" => 384]);

		$profileActivationToken = bin2hex(random_bytes(32));

		// create the profile object and prepare to insert into the database
		$profile = new Profile(generateUuidV4(), $requestObject->profileAbout, $profileActivationToken, $requestObject->profileAddressLine1,
		$requestObject->profileAddresLine2, $requestObject->profileCity, $requestObject ->profileEmail, $hash, $requestObject->profileImage,
		$requestObject->profileName, $requestObject->profileState, $requestObject ->profileUsername, $requestObject->profileUsertype, $requestObject->profileZip);

		//insert the profile into the database
		$profile->insert($pdo);

		//compose the email message to send with th activation token
		$messageSubject = "One step closer -- Account Activation";

		//building the activation link that can travel to another server and still work . this is the link that will be clicked to confirm the account
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

		//create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;

		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

		//compose the message to send with email
		$message = <<< EOF

<h2>Welcome to "name of app".</h2>
<p>In order to use the app, please confirm your account</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;

		//create swift email
		$swiftMessage = new Swift_Message();

		//attach the sender to the message
		//this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["cmarquez69@cnm.edu" => "cmarquez"]);

		/**
		*attach recipients to the message
		**/
		//define who the recipient is
		$recipients = [$requectObject->profileEmail];

		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);

		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);

		/**
		*attach the message to the email
		**/
		//attach the html version of the message
		$swiftMessage->setBody($message, "text/html");
		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");
		/**
		*send the email via SMTP;
		* @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		**/

		//setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25);
		$mailer = new Swift_Mailer($smtp);

		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);

		/**
		 *the send method returns the number of recipients that accepted the email
		 * if the number of attempted sign ups is not the number accepted its an exception
		 **/
		if($numSent !== count($recipients)) {

		//the $failedRecipients parameter passed in the send() method now contains an array of the emails that failed to pass
		throw(new RuntimeException("Unable to send email", 400));
		}

		//update reply
		$reply->message = "Thank you for creating an account with !!!";
		} else {
		throw (new \InvalidArgumentException("invalid http request"));
		}
} catch(\TypeError $typeError) {
		$reply->status = $typeError->getCode();
		$reply->message = $typeError->getMessage();
		$reply->trace = $exception->getTraceAsString();
}

header("Content-type: application/json");
echo json_encode($reply);


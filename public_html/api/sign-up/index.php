<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Beer\Profile;
/**
*api for handling sign-in
*
* @author Carlos Marquez
*
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
	if($method === "POST")

		//make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and email field is not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Wrong email address.", 401));
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

			// create the profile object and prepare to insert into the database
			$profile = new Profile(generateUuidV4(), $profileActivationToken, $requestObject - profileEmail, $profileHash, $requestObject - profileName, 0, $profileSalt, $requestObject - profileUsername);

			//insert the profile into the database
			$profile->insert($pdo);

			//compose the email message to send with the activation token
			$messageSubject = "One more step before you can start playing Kmaru, just confirm your account through your email.";

			//building the activation link that can travel to another server and still work . this is the link that will be clicked to confirm the account
			//make sure the URL is /public_html/api/activation/$activation
			$basepath = dirname($_SERVER['SCRIPT_NAME'], 3);

			//create the path
			$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;

			//create the redirect link
			$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

			//compose message to send with email
			$message = <<< EOF
<h2> Welcome!!!</h2>
<p>In order to use this "app" please confirm your account.</p>
<p><a href="confirmLink">$confirmLink</a></p>
EOF;

			//create swift email
			$swiftMessage = new Swift_Message();

			//attach the sender to the message
			//this takes the form of an associative array where the email is the key to a real name
			$swiftMessage->setFrom(["cmarquez69@cnm.edu" => "cmarquez"]);

			/**
			 *attach recipients to the message
			 *this is an array that can include or omit the recipient's name
			 *use the recipient's real name where possible
			 *this reduces the probability of the email being marked as spam
			 **/
			//define who the recipient is
			$recipients = [$requectObject->profileEmail];

			//set the recipient to the swift message
			$swiftMessage->setTo($recipients);

			//attach the subject line to the email message
			$swiftMessage->setSubject($messageSubject);

			/**
			 *attach the message to the email
			 *two versions of this message: an html formatted version and a filter_var()ed version of the message in plain text
			 *notice that the tactic thats used is to display the entire $confirmLink to plain text
			 *this lets users who are not viewing the html content to still access the link
			 **/
			//attach the html version of the message
			$swiftMessage->setBody($message, "text/html");
			//attach the plain text version of the message
			$swiftMessage->addPart(html_entity_decode($message), "text/plain");
			/**
			 *send the email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
			 *this default may or may not be available on all web hosts: consult their documentation for details
			 *SwiftMailer supports many different transport methods; SMTP was chosen because it's most compatibile and has the best error handling
			 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
			 **/

			//setup smtp
			$smtp = new Swift_SmtpTransport(
				"localhost", 25);
			$mailer = new Swift_Mailer($smtp);

			//send the message
			$sumSent = $mailer->send($swiftMessage, $failedRecipients);
			/**
			 *the send method returns the number of recipients that accepted the email
			 * if the number of attempted sign ups is not the number accepted its an exception
			 **/
			if($numSent !== count($recipients)) {
				//the $failedRecipients parameter passed in the send() method now contains an array of the emails that failed to pass
				throw(new RuntimeException("Unable to send email", 400));
			}

			//update reply
			$reply->message = "Thank you for creating an account with !!! Please Verify your email address";
		} else {
		throw (new \InvalidArgumentException("invalid http request" , 418));
		}
	}

	catch(\TypeError $typeError) {
		$reply->status = $typeError->getCode();
		$reply->message = $typeError->getMessage();
	}
	header("Content-type: application/json");
	echo json_encode($reply);


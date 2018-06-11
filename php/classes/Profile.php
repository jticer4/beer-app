<?php

namespace Edu\Cnm\Beer;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * The profile class that will be used for each of the brewers that want to sign up
 *
 * This profile contains all of the information that will be displayed by the brewer
 **/
class Profile implements \JsonSerializable {

	use ValidateUuid;

	/**
	 * id for this Profile, this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;

	/**
	 * about section for the Profile
	 * @var string $profileAbout
	 **/
	private $profileAbout;

	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 *@var $profileActivationToken
	 **/
	private $profileActivationToken;

	/**
	 * address line 1 for the Profile
	 * @var string $profileAddressLine1
	 **/
	private $profileAddressLine1;

	/**
	 * address line 2 for the Profile
	 * @var string $profileAddressLine2
	 **/
	private $profileAddressLine2;

	/**
	 * city of the Profile
	 * @var string $profileCity
	 **/
	private $profileCity;

	/**
	 * email address for the Profile
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * hash for the Profile
	 * @var string $profileHash
	 **/
	private $profileHash;

	/**
	 * image for the Profile
	 * @var string $profileImage
	 **/
	private $profileImage;

	/**
	 * name of the Profile
	 * @var string $profileName
	 **/
	private $profileName;

	/**
	 * state of the Profile
	 * @var string $profileState
	 **/
	private $profileState;

	/**
	 * username of the Profile
	 * @var string $profileUsername
	 **/
	private $profileUsername;

	/**
	 * user type of the Profile
	 * @var string $profileUserType
	 **/
	private $profileUserType;

	/**
	 * zip code of the Profile
	 * @var string $profileZip
	 **/
	private $profileZip;

	/**
	 * Constructor for this Profile
	 *
	 * @param string|Uuid $newProfileId id for this profile or null if a new profile
	 * @param string $newProfileAbout string containing the profile about me content
	 * @param string $newProfileActivationToken activation token to safe guard against malicious accounts
	 * @param string $newProfileAddressLine1 string containing the profile address line 1
	 * @param string $newProfileAddressLine2 string containing the address line 2
	 * @param string $newProfileCity string containing the city of the profile
	 * @param string $newProfileEmail string containing the email address of the profile
	 * @param string $newProfileHash string containing the hash of the profile
	 * @param string $newProfileImage string containing the profile image
	 * @param string $newProfileName string containing the name of the profile
	 * @param string $newProfileState string containing the state of the profile
	 * @param string $newProfileUsername string containing the username of the profile
	 * @param string $newProfileUserType string containing the user type of the profile
	 * @param string $newProfileZip string containing the zip code of the profile
	 **/
	public function __construct( $newProfileId, ?string $newProfileAbout, ?string $newProfileActivationToken, string $newProfileAddressLine1, ?string $newProfileAddressLine2, string $newProfileCity, string $newProfileEmail, string $newProfileHash, ?string $newProfileImage, string $newProfileName, string $newProfileState, string $newProfileUsername, string $newProfileUserType, string $newProfileZip) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileAbout($newProfileAbout);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAddressLine1($newProfileAddressLine1);
			$this->setProfileAddressLine2($newProfileAddressLine2);
			$this->setProfileCity($newProfileCity);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileImage($newProfileImage);
			$this->setProfileName($newProfileName);
			$this->setProfileState($newProfileState);
			$this->setProfileUsername($newProfileUsername);
			$this->setProfileUserType($newProfileUserType);
			$this->setProfileZip($newProfileZip);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		}

	/**
	 * accessor method for profile Id
	 * @return Uuid value of profile Id
	 **/
	public function getProfileId(): Uuid {
		return($this->profileId);
	}

	/**
	 * mutator method of profile Id
	 * @param Uuid $newProfileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 **/
	public function setProfileId( $newProfileId): void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->profileId = $uuid;
	}


	/**
	 * accessor method for profile about section
	 * @return string value of profile about content
	 **/
	public function getProfileAbout(): string {
		return($this->profileAbout);
	}

	/**
	 * mutator method for profile about section
	 * @param string $newProfileAbout
	 * @throws \RangeException if $newProfileAbout is > 140 characters
	 * @throws \TypeError if $newProfileAbout is not a string
	 **/
	public function setProfileAbout(?string $newProfileAbout): void {
		if($newProfileAbout === null) {
			$this->profileAbout = null;
		}


		// verify the profile about content is secure
		$newProfileAbout = trim($newProfileAbout);
		$newProfileAbout = filter_var($newProfileAbout, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile about content will fit in the database
		if(strlen($newProfileAbout) > 140) {
			throw(new \RangeException("profile about content too large"));
		}

		// store the profile about content
		$this->profileAbout = $newProfileAbout;
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @return string value of the activation token
	 */
	public function getProfileActivationToken() : ?string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for the profile address line 1
	 * @return string value of profile address
	 **/
	public function getProfileAddressLine1(): string {
		return($this->profileAddressLine1);
	}

	/**
	 * mutator method for profile address line 1
	 * @param string $newProfileAddressLine1
	 * @throws \RangeException if $newProfileAddressLine1 is > 96 characters
	 * @throws \TypeError if $newProfileAddressLine1 is not a string
	 **/
	public function setProfileAddressLine1(string $newProfileAddressLine1): void {
		// verify the profile address line 1 content is secure
		$newProfileAddressLine1 = trim($newProfileAddressLine1);
		$newProfileAddressLine1 = filter_var($newProfileAddressLine1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile address line 1 content will fit in the database
		if(strlen($newProfileAddressLine1) > 96) {
			throw(new \RangeException("profile address line 1 content too large"));
		}

		// store the profile address line 1 content
		$this->profileAddressLine1 = $newProfileAddressLine1;
	}

	/**
	 * accessor method for profile address line 2
	 * @return string value of profile address line 2
	 **/
	public function getProfileAddressLine2(): string {
		return($this->profileAddressLine2);
	}

	/**
	 * mutator method for profile address line 2
	 * @param string $newProfileAddressLine2
	 * @throws \RangeException if $newProfileAddressLine2 is > 96 characters
	 * @throws \TypeError if $newProfileAddressLine2 is not a string
	 **/
	public function setProfileAddressLine2(?string $newProfileAddressLine2): void {
		if($newProfileAddressLine2 === null) {
			$this->profileAddressLine2 = null;
		}
		// verify the profile address line 2 content is secure
		$newProfileAddressLine2 = trim($newProfileAddressLine2);
		$newProfileAddressLine2 = filter_var($newProfileAddressLine2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile address line 2 content will fit in the database
		if(strlen($newProfileAddressLine2) > 96) {
			throw(new \RangeException("profile address line 2 content too large"));
		}

		// store the profile address line 2 content
		$this->profileAddressLine2 = $newProfileAddressLine2;
	}

	/**
	 * accessor method for profile city
	 * @return string value of profile city
	 **/
	public function getProfileCity(): string {
		return($this->profileCity);
	}

	/**
	 * mutator method for profile city
	 * @param string $newProfileCity
	 * @throws \RangeException if $newProfileCity is > 48 characters
	 * @throws \TypeError if $newProfileCity is not a string
	 **/
	public function setProfileCity(string $newProfileCity): void {
		// verify the profile city content is secure
		$newProfileCity = trim($newProfileCity);
		$newProfileCity = filter_var($newProfileCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile city content will fit in the database
		if(strlen($newProfileCity) > 48) {
			throw(new \RangeException("profile city content too large"));
		}

		// store the profile city content
		$this->profileCity = $newProfileCity;
	}

	/**
	 * accessor method for profile email
	 * @return string value of profile email
	 **/
	public function getProfileEmail(): string {
		return($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 * @param string $newProfileEmail
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \RangeException if $newProfileEmail is > 128 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the profile email content is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email content is empty or insecure") );
		}

		// verify the profile email content will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email content too large"));
		}

		// store the profile email content
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile hash
	 * @return string value of profile hash
	 **/
	public function getProfileHash(): string {
		return($this->profileHash);
	}

	/**
	 * mutator method for profile hash
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 97 characters
	 * @throws \TypeError if profile hash is not a string
	 **/
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile hash empty or insecure"));
		}

		//enforce the hash is really an Argon hash
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}

		//enforce that the hash is exactly 97 characters.
		if(strlen($newProfileHash) !== 97) {
			throw(new \RangeException("profile hash must be 97 characters"));
		}

		//store the hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile image
	 * @return string value of profile image
	 **/
	public function getProfileImage(): string {
		return($this->profileImage);
	}

	/**
	 * mutator method for profile image
	 * @param string $newProfileImage
	 * @throws \RangeException if $newProfileImage is > 255 characters
	 * @throws \TypeError if $newProfileImage is not a string
	 **/
	public function setProfileImage(?string $newProfileImage): void {
		if ($newProfileImage === null) {
			$this->profileImage = null;
		}

		// verify the profile image content is secure
		$newProfileImage = trim($newProfileImage);
		$newProfileImage = filter_var($newProfileImage, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile image content will fit in the database
		if(strlen($newProfileImage) > 255) {
			throw(new \RangeException("profile image content too large"));
		}

		// store the profile image content
		$this->profileImage = $newProfileImage;
	}

	/**
	 * accessor method for profile name
	 * @return string value of profile name
	 **/
	public function getProfileName(): string {
		return($this->profileName);
	}

	/**
	 * mutator method for profile name
	 * @param string $newProfileName
	 * @throws \RangeException if $newProfileName is > 64 characters
	 * @throws \TypeError if $newProfileName is not a string
	 **/
	public function setProfileName(string $newProfileName): void {
		// verify the profile name content is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile name content will fit in the database
		if(strlen($newProfileName) > 64) {
			throw(new \RangeException("profile name content too large"));
		}

		// store the profile name content
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for profile state
	 * @return string value of profile state
	 **/
	public function getProfileState(): string {
		return($this->profileState);
	}

	/**
	 * mutator method for profile state
	 * @param string $newProfileState
	 * @throws \RangeException if $newProfileState is > 2 characters
	 * @throws \TypeError if $newProfileState is not a string
	 **/
	public function setProfileState(string $newProfileState): void {
		// verify the profile state content is secure
		$newProfileState = trim($newProfileState);
		$newProfileState = filter_var($newProfileState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile state content will fit in the database
		if(strlen($newProfileState) > 2) {
			throw(new \RangeException("profile state content too large"));
		}

		// store the profile state content
		$this->profileState = $newProfileState;
	}

	/**
	 * accessor method for profile username
	 * @return string value of profile username
	 **/
	public function getProfileUsername(): string {
		return($this->profileUsername);
	}

	/**
	 * mutator method for profile username
	 * @param string $newProfileUsername
	 * @throws \InvalidArgumentException if $newProfileUsername is not a string or insecure
	 * @throws \RangeException if $newProfileUsername is > 48 characters
	 * @throws \TypeError if $newProfileUsername is not a string
	 **/
	public function setProfileUsername(string $newProfileUsername): void {
		// verify the profile username content is secure
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUsername) === true) {
			throw(new \InvalidArgumentException("profile username content is empty or insecure"));
		}

		// verify the profile username content will fit in the database
		if(strlen($newProfileUsername) > 48) {
			throw(new \RangeException("profile username content too large"));
		}

		// store the profile username content
		$this->profileUsername = $newProfileUsername;
	}

	/**
	 * accessor method for profile user type
	 * @return string value of profile user type
	 **/
	public function getProfileUserType(): string {
		return($this->profileUserType);
	}

	/**
	 * mutator method for profile user type
	 * @param string $newProfileUserType
	 * @throws \InvalidArgumentException if $newProfileUsername is not a string or insecure
	 * @throws \RangeException if $newProfileUserType is > 1 characters
	 * @throws \TypeError if $newProfileUserType is not a string
	 **/
	public function setProfileUserType(string $newProfileUserType): void {
		// verify the profile user type content is secure
		$newProfileUserType = trim($newProfileUserType);
		$newProfileUserType = filter_var($newProfileUserType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserType) === true) {
			throw(new \InvalidArgumentException("profile user type content is empty or insecure"));
		}

		// verify the profile user type content will fit in the database
		if(strlen($newProfileUserType) > 1) {
			throw(new \RangeException("profile user type content too large"));
		}

		// store the profile user type content
		$this->profileUserType = $newProfileUserType;
	}

	/**
	 * accessor method for profile zip
	 * @return string value of profile zip
	 **/
	public function getProfileZip(): string {
		return($this->profileZip);
	}

	/**
	 * mutator method for profile zip
	 * @param string $newProfileZip
	 * @throws \RangeException if $newProfileZip is > 10 characters
	 * @throws \TypeError if $newProfileZip is not a string
	 **/
	public function setProfileZip(string $newProfileZip): void {
		// verify the profile zip content is secure
		$newProfileZip = trim($newProfileZip);
		$newProfileZip = filter_var($newProfileZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify the profile zip content will fit in the database
		if(strlen($newProfileZip) > 10) {
			throw(new \RangeException("profile zip content too large"));
		}

		// store the profile zip content
		$this->profileZip = $newProfileZip;
	}


	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO profile(profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip) VALUES(:profileId, :profileAbout, :profileActivationToken, :profileAddressLine1, :profileAddressLine2, :profileCity, :profileEmail, :profileHash, :profileImage, :profileName, :profileState, :profileUsername, :profileUserType, :profileZip)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileAbout" => $this->profileAbout, "profileActivationToken" => $this->profileActivationToken, "profileAddressLine1" => $this->profileAddressLine1, "profileAddressLine2" => $this->profileAddressLine2, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileImage" => $this->profileImage, "profileName" => $this->profileName, "profileState" => $this->profileState, "profileUsername" => $this->profileUsername, "profileUserType" => $this->profileUserType, "profileZip" => $this->profileZip];
		$statement->execute($parameters);
	}


	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE profile SET profileAbout = :profileAbout, profileActivationToken = :profileActivationToken, profileAddressLine1 = :profileAddressLine1, profileAddressLine2 = :profileAddressLine2, profileCity = :profileCity, profileEmail = :profileEmail, profileHash = :profileHash, profileImage = :profileImage, profileName = :profileName, profileState = :profileState, profileUsername = :profileUsername, profileUserType = :profileUserType, profileZip = :profileZip WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);


		$parameters = ["profileId" => $this->profileId->getBytes(), "profileAbout" => $this->profileAbout, "profileActivationToken" => $this->profileActivationToken, "profileAddressLine1" => $this->profileAddressLine1, "profileAddressLine2" => $this->profileAddressLine2, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileImage" => $this->profileImage, "profileName" => $this->profileName, "profileState" => $this->profileState, "profileUsername" => $this->profileUsername, "profileUserType" => $this->profileUserType, "profileZip" => $this->profileZip];
		$statement->execute($parameters);
	}

	/**
	 * gets the Profile by profileId
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $profileId profile id to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?Profile {
		// sanitize the profileId before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);

		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileAbout"], $row["profileActivationToken"], $row["profileAddressLine1"], $row["profileAddressLine2"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row['profileImage'], $row["profileName"], $row["profileState"], $row["profileUsername"], $row["profileUserType"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * gets the Profile by profileUsername
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUsername profile username to search for
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileUsername(\PDO $pdo, string $profileUsername) : \SplFixedArray {
		// sanitize the description before searching
		$profileUsername = trim($profileUsername);
		$profileUsername = filter_var($profileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUsername) === true) {
			throw(new \PDOException("profile username is invalid"));
		}

		// escape any mySQL wild cards
		$profileUsername = str_replace("_", "\\_", str_replace("%", "\\%", $profileUsername));

		// create query template
		$query = "SELECT profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip FROM profile WHERE profileUsername LIKE :profileUsername";
		$statement = $pdo->prepare($query);

		// bind the profile content to the place holder in the template
		$profileUsername = "%$profileUsername%";
		$parameters = ["profileUsername" => $profileUsername];
		$statement->execute($parameters);

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileAbout"], $row["profileActivationToken"], $row["profileAddressLine1"], $row["profileAddressLine2"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row["profileImage"], $row["profileName"], $row["profileState"], $row["profileUsername"], $row["profileUserType"], $row["profileZip"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}

	/**
	 * gets the Profile by profile email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param String $profileEmail profile email to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, $profileEmail) : ?Profile {
		// sanitize the tweetId before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("profile email content is invalid"));
		}

		// create query template
		$query = "SELECT profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		// bind the profile email to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileAbout"], $row["profileActivationToken"], $row["profileAddressLine1"], $row["profileAddressLine2"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row["profileImage"], $row["profileName"], $row["profileState"], $row["profileUsername"], $row["profileUserType"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * get the profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		//create the query template
		$query = "SELECT  profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileAbout"], $row["profileActivationToken"], $row["profileAddressLine1"], $row["profileAddressLine2"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row["profileImage"], $row["profileName"], $row["profileState"], $row["profileUsername"], $row["profileUserType"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * gets all Profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Profiles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProfiles(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip FROM profile";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileAbout"], $row["profileActivationToken"], $row["profileAddressLine1"], $row["profileAddressLine2"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row["profileImage"], $row["profileName"], $row["profileState"], $row["profileUsername"], $row["profileUserType"], $row["profileZip"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * get all Profiles that have not been activated
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Profiles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllNonActiveProfiles(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT profileId, profileAbout, profileActivationToken, profileAddressLine1, profileAddressLine2, profileCity, profileEmail, profileHash, profileImage, profileName, profileState, profileUsername, profileUserType, profileZip FROM profile WHERE profileActivationToken IS NOT NULL";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileAbout"], $row["profileActivationToken"], $row["profileAddressLine1"], $row["profileAddressLine2"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row["profileImage"], $row["profileName"], $row["profileState"], $row["profileUsername"], $row["profileUserType"], $row["profileZip"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->profileId->toString();
		unset($fields['profileHash']);
		return($fields);
	}

}
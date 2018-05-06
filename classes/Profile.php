<?php

class Profile {

	/**
	 * id for this Profile, this is the primary key
	 * @var Uuid $profileId
	 **/
	protected $profileId;

	/**
	 * about section for the profile
	 * @var string $profileAbout
	 **/
	public $profileAbout;

	/**
	 * address line 1 for the profile
	 * @var string $profileAddressLine1
	 **/
	protected $profileAddressLine1;

	/**
	 * address line 2 for the profile
	 * @var string $profileAddressLine2
	 **/
	protected $profileAddressLine2;

	/**
	 * city of the profile
	 * @var string $profileCity
	 **/
	protected $profileCity;

	/**
	 * email address for the profile
	 * @var string $profileEmail
	 **/
	protected $profileEmail;

	/**
	 * hash for the profile
	 * @var string $profileHash
	 **/
	protected $profileHash;

	/**
	 * image for the profile
	 * @var string $profileImage
	 **/
	public $profileImage;

	/**
	 * name of the profile
	 * @var string $profileName
	 **/
	public $profileName;

	/**
	 * state of the profile
	 * @var string $profileState
	 **/
	protected $profileState;

	/**
	 * username of the profile
	 * @var string $profileUsername
	 **/
	public $profileUsername;

	/**
	 * user type of the profile
	 * @var string $profileUserType
	 **/
	public $profileUserType;

	/**
	 * zip code of the profile
	 * @var string $profileZip
	 **/
	protected $profileZip;

	/**
	 * accessor method for profile Id
	 * @return Uuid value of profile Id
	 */
	public function getProfileId(): Uuid {
		return($this->profileId);
	}

	/**
	 * mutator method of profile Id
	 * @param Uuid $newProfileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 */
	public function setProfileId(Uuid $newProfileId): void {
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
	 */
	public function getProfileAbout(): string {
		return($this->profileAbout);
	}

	/**
	 * mutator method for profile about section
	 * @param string $newProfileAbout
	 * @throws \InvalidArgumentException if $newProfileAbout is not a string or insecure
	 * @throws \RangeException if $newProfileAbout is > 140 characters
	 * @throws \TypeError if $newProfileAbout is not a string
	 */
	public function setProfileAbout(string $newProfileAbout): void {
		// verify the profile about content is secure
		$newProfileAbout = trim($newProfileAbout);
		$newProfileAbout = filter_var($newProfileAbout, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAbout) === true) {
			throw(new \InvalidArgumentException("profile about content is empty or insecure"));
		}

		// verify the profile about content will fit in the database
		if(strlen($newProfileAbout) > 140) {
			throw(new \RangeException("profile about content too large"));
		}

		// store the profile about content
		$this->profileAbout = $newProfileAbout;
	}

	/**
	 * accessor method for the profile address line 1
	 * @return string value of profile address
	 */
	public function getProfileAddressLine1(): string {
		return($this->profileAddressLine1);
	}

	/**
	 * mutator method for profile address line 1
	 * @param string $newProfileAddressLine1
	 * @throws \InvalidArgumentException if $newProfileAddressLine1 is not a string or insecure
	 * @throws \RangeException if $newProfileAddressLine1 is > 96 characters
	 * @throws \TypeError if $newProfileAddressLine1 is not a string
	 */
	public function setProfileAddressLine1(string $newProfileAddressLine1): void {
		// verify the profile address line 1 content is secure
		$newProfileAddressLine1 = trim($newProfileAddressLine1);
		$newProfileAddressLine1 = filter_var($newProfileAddressLine1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAddressLine1) === true) {
			throw(new \InvalidArgumentException("profile address line 1 content is empty or insecure"));
		}

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
	 */
	public function getProfileAddressLine2(): string {
		return($this->profileAddressLine2);
	}

	/**
	 * mutator method for profile address line 2
	 * @param string $newProfileAddressLine2
	 * @throws \InvalidArgumentException if $newProfileAddressLine2 is not a string or insecure
	 * @throws \RangeException if $newProfileAddressLine2 is > 96 characters
	 * @throws \TypeError if $newProfileAddressLine2 is not a string
	 */
	public function setProfileAddressLine2(string $newProfileAddressLine2): void {
		// verify the profile address line 2 content is secure
		$newProfileAddressLine2 = trim($newProfileAddressLine2);
		$newProfileAddressLine2 = filter_var($newProfileAddressLine2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAddressLine2) === true) {
			throw(new \InvalidArgumentException("profile address line 2 content is empty or insecure"));
		}

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
	 */
	public function getProfileCity(): string {
		return($this->profileCity);
	}

	/**
	 * mutator method for profile city
	 * @param string $newProfileCity
	 * @throws \InvalidArgumentException if $newProfileCity is not a string or insecure
	 * @throws \RangeException if $newProfileCity is > 48 characters
	 * @throws \TypeError if $newProfileCity is not a string
	 */
	public function setProfileCity(string $newProfileCity): void {
		// verify the profile city content is secure
		$newProfileCity = trim($newProfileCity);
		$newProfileCity = filter_var($newProfileCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileCity) === true) {
			throw(new \InvalidArgumentException("profile city content is empty or insecure"));
		}

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
	 */
	public function getProfileEmail(): string {
		return($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 * @param string $newProfileEmail
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \RangeException if $newProfileEmail is > 128 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the profile email content is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email content is empty or insecure"));
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
	 */
	public function getProfileHash(): string {
		return($this->profileHash);
	}

	/**
	 * mutator method for profile hash
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 97 characters
	 * @throws \TypeError if profile hash is not a string
	 */
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
	 */
	public function getProfileImage(): string {
		return($this->profileImage);
	}

	/**
	 * mutator method for profile image
	 * @param string $newProfileImage
	 * @throws \InvalidArgumentException if $newProfileImage is not a string or insecure
	 * @throws \RangeException if $newProfileImage is > 255 characters
	 * @throws \TypeError if $newProfileImage is not a string
	 */
	public function setProfileImage(string $newProfileImage): void {
		// verify the profile image content is secure
		$newProfileImage = trim($newProfileImage);
		$newProfileImage = filter_var($newProfileImage, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileImage) === true) {
			throw(new \InvalidArgumentException("profile image content is empty or insecure"));
		}

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
	 */
	public function getProfileName(): string {
		return($this->profileName);
	}

	/**
	 * mutator method for profile name
	 * @param string $newProfileName
	 * @throws \InvalidArgumentException if $newProfileName is not a string or insecure
	 * @throws \RangeException if $newProfileName is > 64 characters
	 * @throws \TypeError if $newProfileName is not a string
	 */
	public function setProfileName(string $newProfileName): void {
		// verify the profile name content is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("profile name content is empty or insecure"));
		}

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
	 */
	public function getProfileState(): string {
		return($this->profileState);
	}

	/**
	 * mutator method for profile state
	 * @param string $newProfileState
	 * @throws \InvalidArgumentException if $newProfileState is not a string or insecure
	 * @throws \RangeException if $newProfileState is > 2 characters
	 * @throws \TypeError if $newProfileState is not a string
	 */
	public function setProfileState(string $newProfileState): void {
		// verify the profile state content is secure
		$newProfileState = trim($newProfileState);
		$newProfileState = filter_var($newProfileState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileState) === true) {
			throw(new \InvalidArgumentException("profile state content is empty or insecure"));
		}

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
	 */
	public function getProfileUsername(): string {
		return($this->profileUsername);
	}

	/**
	 * mutator method for profile username
	 * @param string $newProfileUsername
	 * @throws \InvalidArgumentException if $newProfileUsername is not a string or insecure
	 * @throws \RangeException if $newProfileUsername is > 48 characters
	 * @throws \TypeError if $newProfileUsername is not a string
	 */
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
	 */
	public function getProfileUserType(): string {
		return($this->profileUserType);
	}

	/**
	 * mutator method for profile user type
	 * @param string $newProfileUserType
	 * @throws \InvalidArgumentException if $newProfileUserType is not a string or insecure
	 * @throws \RangeException if $newProfileUserType is > 1 characters
	 * @throws \TypeError if $newProfileUserType is not a string
	 */
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
	 */
	public function getProfileZip(): string {
		return($this->profileZip);
	}

	/**
	 * mutator method for profile zip
	 * @param string $newProfileZip
	 * @throws \InvalidArgumentException if $newProfileZip is not a string or insecure
	 * @throws \RangeException if $newProfileZip is > 10 characters
	 * @throws \TypeError if $newProfileZip is not a string
	 */
	public function setProfileZip(string $newProfileZip): void {
		// verify the profile zip content is secure
		$newProfileZip = trim($newProfileZip);
		$newProfileZip = filter_var($newProfileZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileZip) === true) {
			throw(new \InvalidArgumentException("profile zip content is empty or insecure"));
		}

		// verify the profile zip content will fit in the database
		if(strlen($newProfileZip) > 10) {
			throw(new \RangeException("profile zip content too large"));
		}

		// store the profile zip content
		$this->profileZip = $newProfileZip;
	}

}
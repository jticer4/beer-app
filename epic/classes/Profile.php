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
		return $this->profileId;
	}

	/**
	 * mutator method of profile Id
	 * @param Uuid $profileId
	 */
	public function setProfileId(Uuid $profileId): void {
		$this->profileId = $profileId;
	}

	/**
	 * accessor method for profile about section
	 * @return string value of profile about content
	 */
	public function getProfileAbout(): string {
		return $this->profileAbout;
	}

	/**
	 * mutator method for profile about section
	 * @param string $profileAbout
	 */
	public function setProfileAbout(string $profileAbout): void {
		$this->profileAbout = $profileAbout;
	}

	/**
	 * accessor method for the profile address line 1
	 * @return string value of profile address
	 */
	public function getProfileAddressLine1(): string {
		return $this->profileAddressLine1;
	}

	/**
	 * mutator method for profile address line 1
	 * @param string $profileAddressLine1
	 */
	public function setProfileAddressLine1(string $profileAddressLine1): void {
		$this->profileAddressLine1 = $profileAddressLine1;
	}

	/**
	 * accessor method for profile address line 2
	 * @return string
	 */
	public function getProfileAddressLine2(): string {
		return $this->profileAddressLine2;
	}

	/**
	 * mutator method for profile address line 2
	 * @param string $profileAddressLine2
	 */
	public function setProfileAddressLine2(string $profileAddressLine2): void {
		$this->profileAddressLine2 = $profileAddressLine2;
	}

	/**
	 * accessor method for profile city
	 * @return string
	 */
	public function getProfileCity(): string {
		return $this->profileCity;
	}

	/**
	 * mutator method for profile city
	 * @param string $profileCity
	 */
	public function setProfileCity(string $profileCity): void {
		$this->profileCity = $profileCity;
	}

	/**
	 * accessor method for profile email
	 * @return string
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for profile email
	 * @param string $profileEmail
	 */
	public function setProfileEmail(string $profileEmail): void {
		$this->profileEmail = $profileEmail;
	}

	/**
	 * accessor method for profile hash
	 * @return string
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash
	 * @param string $profileHash
	 */
	public function setProfileHash(string $profileHash): void {
		$this->profileHash = $profileHash;
	}

	/**
	 * accessor method for profile image
	 * @return string
	 */
	public function getProfileImage(): string {
		return $this->profileImage;
	}

	/**
	 * mutator method for profile image
	 * @param string $profileImage
	 */
	public function setProfileImage(string $profileImage): void {
		$this->profileImage = $profileImage;
	}

	/**
	 * accessor method for profile name
	 * @return string
	 */
	public function getProfileName(): string {
		return $this->profileName;
	}

	/**
	 * mutator method for profile name
	 * @param string $profileName
	 */
	public function setProfileName(string $profileName): void {
		$this->profileName = $profileName;
	}

	/**
	 * accessor method for profile state
	 * @return string
	 */
	public function getProfileState(): string {
		return $this->profileState;
	}

	/**
	 * mutator method for profile state
	 * @param string $profileState
	 */
	public function setProfileState(string $profileState): void {
		$this->profileState = $profileState;
	}

	/**
	 * accessor method for profile username
	 * @return string
	 */
	public function getProfileUsername(): string {
		return $this->profileUsername;
	}

	/**
	 * mutator method for profile username
	 * @param string $profileUsername
	 */
	public function setProfileUsername(string $profileUsername): void {
		$this->profileUsername = $profileUsername;
	}

	/**
	 * accessor method for profile user type
	 * @return string
	 */
	public function getProfileUserType(): string {
		return $this->profileUserType;
	}

	/**
	 * mutator method for profile user type
	 * @param string $profileUserType
	 */
	public function setProfileUserType(string $profileUserType): void {
		$this->profileUserType = $profileUserType;
	}

	/**
	 * accessor method for profile zip
	 * @return string
	 */
	public function getProfileZip(): string {
		return $this->profileZip;
	}

	/**
	 * mutator method for profile zip
	 * @param string $profileZip
	 */
	public function setProfileZip(string $profileZip): void {
		$this->profileZip = $profileZip;
	}


}
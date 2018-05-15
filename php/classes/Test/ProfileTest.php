<?php
namespace Edu\Cnm\Beer\Test;
use Edu\Cnm\Beer\Profile;
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class ProfileTest extends BeerAppTest {
	/**
	 * valid profile about to use
	 * @var string $VALID_ABOUT
	 */
	protected $VALID_ABOUT;
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;
	/**
	 * valid profile address line 1
	 * @var string $VALID_ADDRESS_LINE_1
	 */
	protected $VALID_ADDRESS_LINE_1;
	/**
	 * valid profile address line 2
	 * @var string $VALID_ADDRESS_LINE_2
	 */
	protected $VALID_ADDRESS_LINE_2;
	/**
	 * valid profile city
	 * @var string $VALID_CITY
	 */
	protected $VALID_CITY;
	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.de";
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;
	/**
	 * valid profile image to use
	 * @var $VALID_IMAGE
	 */
	protected $VALID_IMAGE;
	/**
	 * valid profile name to use
	 * @var $VALID_NAME
	 */
	protected $VALID_NAME;
	/**
	 * valid profile state to use
	 * @var $VALID_STATE
	 */
	protected $VALID_STATE;
	/**
	 * valid profile username to use
	 * @var $VALID_USERNAME
	 */
	protected $VALID_USERNAME;
	/**
	 * valid profile user type
	 * @var $VALID_USER_TYPE
	 */
	protected $VALID_USER_TYPE;
	/**
	 * valid profile zip
	 * @var $VALID_ZIP;
	 */
	protected $VALID_ZIP;

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp() : void {
		parent::setUp();
		//
		$password = "zuck123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}
	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ABOUT, $this->VALID_ACTIVATION, $this->VALID_ADDRESS_LINE_1, $this->VALID_ADDRESS_LINE_2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_IMAGE, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_USERNAME, $this->VALID_USER_TYPE, $this->VALID_ZIP);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileAbout(), $this->VALID_ABOUT);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAddressLine1(), $this->VALID_ADDRESS_LINE_1);
		$this->assertEquals($pdoProfile->getProfileAddressLine2(), $this->VALID_ADDRESS_LINE_2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_STATE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
		$this->assertEquals($pdoProfile->getProfileUserType(), $this->VALID_USER_TYPE);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_ZIP);
	}
	/**
	 *
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ABOUT,$this->VALID_ACTIVATION, $this->VALID_ADDRESS_LINE_1, $this->VALID_ADDRESS_LINE_2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_IMAGE, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_USERNAME, $this->VALID_USER_TYPE, $this->VALID_ZIP);
		$profile->insert($this->getPDO());
		// edit the Profile and update it in mySQL
		$profile->setProfileAbout($this->VALID_ABOUT);
		$profile->setProfileAddressLine1($this->VALID_ADDRESS_LINE_1);
		$profile->setProfileAddressLine2($this->VALID_ADDRESS_LINE_2);
		$profile->setProfileCity($this->VALID_CITY);
		$profile->setProfileEmail($this->VALID_EMAIL);
		$profile->setProfileImage($this->VALID_IMAGE);
		$profile->setProfileName($this->VALID_NAME);
		$profile->setProfileState($this->VALID_STATE);
		$profile->setProfileUsername($this->VALID_USERNAME);
		$profile->setProfileUserType($this->VALID_USER_TYPE);
		$profile->setProfileZip($this->VALID_ZIP);
		$profile->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileAbout(), $this->VALID_ABOUT);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAddressLine1(), $this->VALID_ADDRESS_LINE_1);
		$this->assertEquals($pdoProfile->getProfileAddressLine2(), $this->VALID_ADDRESS_LINE_2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_STATE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
		$this->assertEquals($pdoProfile->getProfileUserType(), $this->VALID_USER_TYPE);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_ZIP);
	}
	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());
		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());
		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}
	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}
	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeProfileId = generateUuidV4();
		$profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId );
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a profile by profile username
	 **/
	public function testGetValidProfileByUsername() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
		//grab the data from MySQL TODO come back and change this so its not get profile by at handle
		//$results = Profile::getProfileByProfileAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		//$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("profile"));
		//enforce no other objects are bleeding into profile
		$this->assertContainsOnlyInstancesOf("Edu\\CNM\\DataDesign\\Profile", $results);
		//enforce the results meet expectations
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}
	/**
	 * test grabbing a Profile by email
	 **/
	public function testGetValidProfileByEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}
	/**
	 * test grabbing a Profile by an email that does not exist
	 **/
	public function testGetInvalidProfileByEmail() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($profile);
	}
	/**
	 * test grabbing a profile by its activation
	 */
	public function testGetValidProfileByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}
	/**
	 * test grabbing a Profile by an activation token that does not exist
	 **/
	public function testGetInvalidProfileActivation() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
		$this->assertNull($profile);
	}
}
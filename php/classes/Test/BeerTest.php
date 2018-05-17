<?php

namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\{Profile, Beer};
//grab class
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
* Full PHPUnit test for the Beer class
*
* This is a complete unit test for the Beer class. It is complete because all mySQL/Pdo enabled methods are tested for both valid and invalid inputs
*
* @see Beer
* @author Carlos Marquez (carl.marq95@gmail.com)
**/
class BeerTest extends BeerAppTest {
	/**
	 * valid abv to use
	 * @var float $VALID_BEERABV
	 *
	 **/
	protected $VALID_BEERABV = .0625;
	/**
	 * valid description
	 * @var string $VALID_BEERDESCRIPTION
	 **/
	protected $VALID_BEERDESCRIPTION ="It’s pretty good. You should try it. Get Elevated!";
	/**
	* valid ibu to use
	* @var int $VALID_BEERIBU
	**/
	protected $VALID_BEERIBU = 100;
	/**
	* valid ibu to use
	* @var int $VALID_BEERIBU_2
	**/
	protected $VALID_BEERIBU_2 = 12;
	/**
	* valid name to use
	* @var string $VALID_BEERNAME
	**/
	protected $VALID_BEERNAME = "La Cumbre Elevated IPA";
	/**
	* valid name to use
	* @var string $VALID_BEERNAME_2
	**/
	protected $VALID_BEERNAME_2 = "ELEPHANTS ON PARADE";
	/*
	* valid hash to use
	**/
	protected $VALID_PROFILE_HASH;
	/*
	* valid activation token to create the profile object that created the beer
	**/
	protected $VALID_ACTIVATION;
/**
* create dependent objects before running each test
*/
public final function setUp(): void {
	// run the default setUp() method first
	parent::setUp();
	$password = "monkey";
	$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 383]);
	$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

	//create and insert a Profile to own the beer
	$this->profile = new Profile(generateUuidV4(), "!!!", $this->VALID_ACTIVATION, "6009 Oak St NW", "6008 Oak St NW",
		"Albuquerque", "iluvu@hotmail.com", $this->VALID_PROFILE_HASH, "", "Fredo", "NM", "hola0", "1", "87110");
	$this->profile->insert($this->getPDO());
}


	/**
*test inserting a valid beer and verify that the mySQL data matches
**/
public function testInsertValidBeer(): void {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	//create a beer and insert it into mySQL
	$beerId = generateUuidV4();
	$beer = new Beer($beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERIBU,
		$this->VALID_BEERNAME);
	$beer->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}

	/**
	* test inserting a beer, modifying it, and then updating it
	**/
public function testUpdateValidBeer() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	// create a new Beer and insert it into mySql
	$beerId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERIBU,
		$this->VALID_BEERNAME
	);
	$beer->insert($this->getPDO());
	// edit this beer and update it in mySql
	$beer->setBeerName($this->VALID_BEERNAME_2);
	$beer->update($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerbyBeerId($this->getPDO(), $beer->getBeerId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME_2);
}

/**
* test creating a beer and then deleting it
**/
public function TestDeleteValidBeer() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	$beerId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERNAME
	);
	$beer->insert($this->getPDO());
	// delete the beer from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
}

/**
*test inserting a beer and grabbing it again it from mySQL by beer id
**/
public function testGetValidBeerByBeerId() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	$beerId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERIBU,
		$this->VALID_BEERNAME
	);
	$beer->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}
/**
* test grabbing a beer that does not exist by beer id
**/
public function testGetInvalidBeerByBeerId() : void {
	// grab a beer id that exceeds the maximum allowable beer id
	$beer = Beer::getBeerByBeerId($this->getPDO(), generateUuidV4());
	$this->assertNull($beer);
}

/**
* test inserting a beer and grabbing it again from mySQL by profile id
**/
public function testGetValidBeerByProfileId() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	//create a new beer and insert it into mysql
	$beerId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERIBU,
		$this->VALID_BEERNAME
	);
	$beer->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Beer::getBeerByBeerProfileId($this->getPDO(), $beer->getBeerProfileId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer\\Beer", $results);

	//grab the result from the array and validate it
	$pdoBeer = $results[0];

	$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}
/**
*test grabbing a beer that doesn't exist
**/
public function testGetInvalidBeerByProfileId() : void {
	//grab a beer id that exceeds the maximum allowable profile id's
	$beer = Beer::getBeerByBeerProfileId($this->getPDO(), generateUuidV4());
	$this->assertCount(0, $beer);
}

	/**
	 * test grabbing a beer by its abv
	 */
	public function testGetValidBeerByBeerAbv() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");

		//create a new beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer(
			$beerId,
			$this->profile->getProfileId(),
			$this->VALID_BEERABV,
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERIBU,
			$this->VALID_BEERNAME);
		$beer->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Beer::getBeerByBeerAbv($this->getPDO(), $beer->getBeerAbv());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer\\Beer", $results);

		//grab the result from the array and validate it
		$pdoBeer = $results[0];

		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
	}

	/**
	 * test grabbing a beer that doesn't exist by the abv
	 **/
	public function testGetInvalidBeerByBeerAbv() : void {
		//grab a beer that doesn't exist
		$beer = Beer::getBeerByBeerAbv($this->getPDO(), 12);
		$this->assertCount(0, $beer);
	}

	/**
	 * test inserting a beer and grabbing it by the ibu
	 **/
	public function testGetValidBeerByIbu() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beer");
		//create a beer and insert it into mySQL
		$beerId = generateUuidV4();
		$beer = new Beer($beerId,
			$this->profile->getProfileId(),
			$this->VALID_BEERABV,
			$this->VALID_BEERDESCRIPTION,
			$this->VALID_BEERIBU,
			$this->VALID_BEERNAME);
		$beer->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Beer::getBeerByBeerIbu($this->getPDO(), $beer->getBeerIbu());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer\\Beer", $results);
		//grab the result from the array and validate it
		$pdoBeer = $results[0];

		$this->assertEquals($pdoBeer->getBeerId(), $beerId);
		$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
		$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
		$this->assertEquals($pdoBeer->getbeerIbu(), $this->VALID_BEERIBU);
		$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
	}

	/**
	 * test grabbing a beer that doesn't exist by the ibu
	 **/
	public function testGetInvalidBeerByIbu() : void {
		//grab a beer that doesn't exist
		$beer = Beer::getBeerByBeerIbu($this->getPDO(), 111);
		$this->assertCount(0, $beer);
	}

/**
* test inserting a beer and grabbing it by the beer name
**/
public function testGetValidBeerByBeerName() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	//create a new beer and insert it into mySQL
	$beerId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERIBU,
		$this->VALID_BEERNAME
		);
	$beer->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match out expectations
	$results = Beer::getBeerByBeerName($this->getPDO(), $beer->getBeerName());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertCount(1, $results);

	//enforce no other objects bleed into the test
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer\\Beer", $results);

	//grab the result from the array and validate it
	$pdoBeer = $results[0];
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getbeerProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}

/**
*test grabbing a beer that does not exist
**/
public function testGetInvalidBeerByName() : void {
	//grab a beer by a name that doesn't exist
	$beer = Beer::getBeerByBeerName($this->getPDO(), "Giraffes on Parade");
	$this->assertCount(0,$beer);
}

/**
* test grabbing all beers
**/
public function testGetAllValidBeers() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	// create a new beer and insert it into mySQL
	$beerId = generateUuidV4();
	$beer = new Beer($beerId,
		$this->profile->getProfileId(),
		$this->VALID_BEERABV,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERIBU,
		$this->VALID_BEERNAME);
	$beer->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Beer::getAllBeers($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer\\Beer", $results);

	//grab the result from the array and validate it
	$pdoBeer = $results[0];
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}
}

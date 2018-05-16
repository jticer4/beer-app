<?php

namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\Beer;

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
	* valid ibu to use
	* @var int $VALID_BEERIBU
	**/
	protected $VALID_BEERIBU = "100";
	/**
	* valid ibu to use
	* @var int $VALID_BEERIBU_2
	**/
	protected $VALID_BEERIBU_2 = "12";
	/**
	 * valid description
	 * @var string $VALID_BEERDESCRIPTION
	 **/
	protected $VALID_BEERDESCRIPTION ="It’s pretty good. You should try it. Get Elevated!";
	/**
	* valid abv to use
	* @var float $VALID_BEERABV
	**/
	protected $VALID_BEERABV = "7.2";
	/**
	* valid abv to use
	* @var float $VALID_BEERABV_2
	**/
	protected $VALID_BEERABV_2 = "5.5";
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

/**
*test inserting a valid beer and verify that the mySQL data matches
**/
public function testInsertValidBeer(): void {
	//count the number of row and save it for later
	$numRows = $this->getConnection()->getRowCount("Beer");
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME
		);
	$beer->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerProfileId($this->getPDO(), $beer->getBeerId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
}

	/**
	* test inserting a beer, modifying it, and then updating it
	**/
public function testUpdateValidBeer() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	// create a new Beer and insert it into mySql
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
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
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME_2);
}

/**
* test creating a beer and then deleting it
**/
public function TestDeleteValidBeer() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
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
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME
	);
	$beer->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerId($this->getPDO(), $beer->getBeerId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}
/**
* test grabbing a beer that does not exist by beer id
**/
public function testGetInvalidBeerByBeerId() : void {
	// grab a beer id that exceeds the maximum allowable beer id
	$beer = Beer::getBeerByBeerId($this->getPDO(), generateUuidV4());
	$this->assertCount(0, $beer);
}
/**
* test inserting a beer and grabbing it again from mySQL by profile id
**/
public function testGetValidBeerByProfileId() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	//create a new beer and insert it into mysql
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
	$this->VALID_BEERIBU,
	$this->VALID_BEERDESCRIPTION,
	$this->VALID_BEERABV,
	$this->VALID_BEERNAME
	);
	$beer->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerProfileId($this->getPDO(), $beer->getBeerProfileId());
	$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
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
* test inserting a beer and grabbing it by the beer name
**/
public function testGetValidBeerByBeerName() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	//create a new beer and insert it into mySQL
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME
		);
	$beer->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match out expectations
	$results = Beer::getBeerByBeerName($this->getPDO(), $beer->getBeerName());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertCount(1,$results);

	//enforce no other objects bleed into the test
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer", $results);

	//grab the result from the array and validate it
	$pdoBeer = $results[0];
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getbeerProfileId(), $this->profile->getProfileId());
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
* test inserting a beer and grabbing it by the ibu
**/
public function testGetValidBeerByIbu() : void {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME);
	$beer->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerIbu($this->getPDO(), $beer->getBeerIbu());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getbeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}
/**
* test grabbing a beer that doesn't exist by the ibu
**/
public function testGetInvalidBeerByIbu() : void {
	//grab a beer that doesn't exist
	$beer = Beer::getBeerByBeerIbu($this->getPDO(), "200");
	$this->assertCount(0, $beer);
}
/**
 * test grabbing a beer by its abv
 */
public function testGetValidBeerByBeerAbv() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME);
	$beer->insert($this->getPDO());
	//grab the date from mySQL and enforce the fields match our expectations
	$pdoBeer = Beer::getBeerByBeerAbv($this->getPDO(), $beer->getBeerIbu());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerDescription(), $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME);
}
/**
 * test grabbing a beer that doesn't exist by the abv
**/
public function testGetInvalidBeerByBeerAbv() : void {
	//grab a beer that doesn't exist
	$beer = Beer::getBeerByBeerAbv($this->getPDO(), "17");
	$this->assertCount(0, $beer);
}
/**
*test grabbing all beers
**/
public function testGetAllValidBeers() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");

	// create a new beer and insert it into mySQL
	$beerId = generateUuidV4();
	$beerProfileId = generateUuidV4();
	$beer = new Beer(
		$beerId,
		$this->beer->getBeerId(),
		$this->VALID_BEERIBU,
		$this->VALID_BEERDESCRIPTION,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME);

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Beer::getAllBeers($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer", $results);

	//grab the result from the array and validate it
	$pdoBeer = $results[0];
	$this->assertEquals($pdoBeer->getBeerId(), $beerId);
	$this->assertEquals($pdoBeer->getBeerProfileId(), $beerProfileId);
	$this->assertEquals($pdoBeer->getBeerIbu(), $this->VALID_BEERIBU);
	$this->assertEquals($pdoBeer->getBeerDescription, $this->VALID_BEERDESCRIPTION);
	$this->assertEquals($pdoBeer->getBeerAbv, $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName, $this->VALID_BEERNAME);
}
}

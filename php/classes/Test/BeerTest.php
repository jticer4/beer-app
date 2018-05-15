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
	* valid description
	* @var string $VALID_BEERDESCRIPTION
	**/
	protected $VALID_BEERDESCRIPTION ="It’s pretty good. You should try it. Get Elevated!";


/**
*test inserting a valid beer and verify that the mySQL data matches
**/
public function testInsertValidBeer(): void {
	//count the number of row and save it for later
	$numRows = $this->getConnection()->getRowCount("Beer");
	$beerId = null;
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME,
		$this->VALID_BEERDESCRIPTION
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
	$beerId = null;
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME,
		$this->VALID_BEERDESCRIPTION
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
	$this->assertEquals($pdoBeer->getBeerAbv(), $this->VALID_BEERABV);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERNAME_2);
	$this->assertEquals($pdoBeer->getBeerName(), $this->VALID_BEERDESCRIPTION);
}

/**
* test creating a beer and then deleting it
**/
public function TestDeleteValidBeer() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("beer");
	$beerId = null;
	$beer = new Beer(
		$beerId,
		$this->VALID_BEERIBU,
		$this->VALID_BEERABV,
		$this->VALID_BEERNAME,
		$this->VALID_BEERDESCRIPTION);
	$beer->insert($this->getPDO());
	// delete the beer from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beer"));
}
/**
*test inserting a beer and regrabbing it from mysql
**/




}
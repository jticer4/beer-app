<?php
namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\{
	Beer, BeerStyle, Style, Profile
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the BeerStyle class
 *
 * This is a complete PHPUnit test of the BeerStyle class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see BeerStyle
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class BeerStyleTest extends BeerAppTest {
	protected $profile = null;

	/**
	 * Beer from the beer/style relationship ; this is for foreign key relations
	 * @var Beer Beer
	 **/
	protected $beer = null;

	/**
	 * Style from the beer/style relationship ; this is for foreign key relations
	 * @var Style style
	 **/
	protected $style = null;

	protected $VALID_HASH;

	protected $VALID_ACTIVATION;


	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		parent::setUp();
		$password = "zuck123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert a Profile up here
		$this->profile = new Profile(generateUuidV4(), "I make grumpy beer from curmudgeonly back-enders",
			$this->VALID_ACTIVATION, "666 Diablo Rd",
			"", "Burque", "gKephart@beersnob.com", $this->VALID_HASH, "https://media.giphy.com/media/3o6Ztqojq5fHrODpjW/giphy.gif", "George K", "NM", "DeepDiveCodingBrewCrew","1", 87101);
		$this->profile->insert($this->getPDO());


		//Create and insert Beer from beer style composite
		$this->beer = new Beer(generateUuidV4(), $this->profile->getProfileId(),.032, "Pretty much budlight",10,"Shit Kicker IPA");
		$this->beer->insert($this->getPDO());

		//Create and insert Style from beer style composite
		$this->style = new Style(1, "piss lager");
		$this->style->insert($this->getPDO());

	}


	public function testInsertValidBeerStyle(): void {
		//count the number of rows
		$numRows = $this->getConnection()->getRowCount("beerStyle");
		// create new beer style and insert it into mySQL
		$beerStyle = new BeerStyle($this->beer->getBeerId(),$this->style->getStyleId());
		$beerStyle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(),$this->beer->getBeerId());
		$pdoBeerStyle = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerStyle"));
		$this->assertEquals($pdoBeerStyle->getBeerStyleBeerId(), $this->beer->getBeerId());
		$this->assertEquals($pdoBeerStyle->getBeerStyleStyleId(),$this->style->getStyleId());
	}







	public function testDeleteValidBeerStyle(): void {
		//count the number of rows save for later
		$numRows = $this->getConnection()->getRowCount("beerStyle");

		//create a new beer style and insert it into mySQL
		$beerStyle = new BeerStyle($this->beer->getBeerId(), $this->style->getStyleId());
		$beerStyle->insert($this->getPDO());

		//delete the beer style
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerStyle"));
		$beerStyle->delete($this->getPDO());

		//grab the data and enforce that beer style does not exits
		$pdoBeerStyle = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(), $this->beer->getBeerId());
		$this->assertNull($pdoBeerStyle);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("beerStyle"));
	}






	public function testGetBeerStyleByBeerStyleBeerId() : void{
		// count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beerStyle");

		//create a new Like and insert it into mySQL
		$newBeerStyle = new BeerStyle ($this->beer->getBeerId(),$this->style->getStyleId());
		$newBeerStyle->insert($this->getPDO());

		// grab data from mySQL, force fields to match our expectations
		$results = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(), $this->beer->getBeerId());
		$pdoBeerStyle = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount ("beerStyle"));
		$this->assertEquals($pdoBeerStyle->getBeerStyleBeerId(),$this->beer->getBeerId());
		$this->assertEquals($pdoBeerStyle->getBeerStyleStyleId(),$this->style->getStyleId());
	}

	public function testGetBeerStyleByBeerStyleStyleId() : void{
		//count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beerStyle");

		//create a new Like and insert it into mySQL
		$beerStyle = new BeerStyle ($this->beer->getBeerId(), $this->style->getStyleId());
		$beerStyle->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match our expectations
		$results = BeerStyle::getBeerStyleByBeerStyleStyleId($this->getPDO(), $this->style->getStyleId());
		$pdoBeerStyle = $results[0];

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerStyle"));
		$this->assertEquals($pdoBeerStyle->getBeerStyleBeerId(),$this->beer->getBeerId());
		$this->assertEquals($pdoBeerStyle->getBeerStyleStyleId(),$this->style->getStyleId());
	}

}



<?php
namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\{
	Beer, BeerStyle, Style
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


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		parent::setUp();
		$password = "zuck123";
		$VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert a Profile up here
		$this->profile = new \Profile(generateUuid4(), "I make grumpy beer from curmudgeonly back-enders",
			$VALID_ACTIVATION, "666 Diablo Rd",
			"", "Burque", "gKephart@beersnob.com", $VALID_HASH, "https://media.giphy.com/media/3o6Ztqojq5fHrODpjW/giphy.gif", "George K", "NM", "DeepDiveCodingBrewCrew","1", 87101);
		$this->profile->insert($this->getPDO());


		//Create and insert Beer from beer style composite
		$this->beer = new \Beer(generateUuid4(), $this->profile->getProfileId(), "45", 3.2, "Shit Kicker IPA", "Pretty much budlight");
		$this->beer->insert($this->getPDO());

		//Create and insert Style from beer style composite
		$this->style = new \Style(66, "piss lager");
		$this->style->insert($this->getPDO());

	}


	public function testInsertValidBeerStyle(): void {
		//count the number of rows
		$numrows = $this->getConnection()->getRowCount("beerStyle");

		// create new beer style and insert it into mySQL
		$beerStyle = new BeerStyle($this->beer->getBeerId(), $this->style->getStyleId());
		$beerStyle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoBeerStyle = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(),$this->beer->getBeerProfileId(), $this->style->getStyleId());
		$this->assertEquals($numrows + 1, $this->getConnection()->getRowCount($beerStyle));
		$this->assertEquals($pdoBeerStyle->getBeerStyleBeerId(), $this->beer->getBeerId());
		$this->assertEquals($pdoBeerStyle->getBeerStyleStyleId(), $this->style->getStyleId());
	}

	public function testDeleteValidBeerStyle(): void {
		//count the number of rows save for later
		$numrows = $this->getConnection()->getRowCount("beerStyle");

		//create a new beer style and insert it into mySQL
		$beerStyle = new BeerStyle($this->beer->getBeerId(), $this->style->getStyleId());
		$beerStyle->delete($this->getPDO());

		$pdoBeerStyle = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(), $this->beer->getBeerId(), $this->style->getStyleId());
		$this->assertNull($pdoBeerStyle);
		$this->assertEquals($numrows, $this->getConnection()->getRowCount("beerStyle"));
	}

	public function testGetBeerStyleByBeerStyleBeerId() : void{
		// count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beerStyle");

		//create a new Like and insert it into mySQL
		$beerStyle = new BeerStyle ($this->beer->getBeerId(),$this->style->getStyleId());
		$beerStyle->insert($this->getPDO());

		// grab data from mySQL, force fields to match our expectations
		$pdoBeerStyle = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(), $this->beer->getBeerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerStyle"));
		$this->assertEquals($pdoBeerStyle->getBeerStyleBeerId(),$this->beer->getBeerProfileId());
		$this->assertEquals($pdoBeerStyle->getBeerStyleStyleId(),$this->style->getBeerStyleStyleId());
	}

	public function testBeerStyleByBeerStyleStyleId() : void{
		//count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("beerStyle");

		//create a new Like and insert it into mySQL
		$beerStyle = new BeerStyle ($this->beer->getBeerId(), $this->style->getStyleId());
		$beerStyle = insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match our expectations
		$pdoBeerStyle = BeerStyle::getBeerStyleByBeerStyleStyleId($this->getPDO(),$this->getStyle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("beerStyle"));
		$this->assertEquals($pdoBeerStyle->getBeerStyleBeerId(),$this->beer->getBeerProfileId());
		$this->assertEquals($pdoBeerStyle->getBeerStyleStyleId(),$this->style->getStyleId());
	}


}


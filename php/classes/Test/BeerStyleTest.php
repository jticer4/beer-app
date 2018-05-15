<?php
namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\{
	Beer, beerStyle, Style
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
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_BEERID
	 */
	protected $VALID_BEERID;

	/**
	 * valid style of beer style
	 * @var $VALID_BEERID
	 */
	protected $VALID_STYLEID;



	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		parent::setUp();
		//Create and insert Beer from beer style composite
		$this->VALID_BEERID = new Beer(generateUuidV4());
		$this->beer->insert($this->getPDO());

		//Create and insert Style from beer style composite
		$this->VALID_STYLEID = new Style(1,"pilsner");
		$this->style->insert($this->getPDO());
		}


	public function testInsertValidBeerStyle() :void {
		//count the number of rows
		$numrows = $this->getConnection()->getRowCount("beerStyle");

		// create new beer style and insert it into mySQL
		$beerId = generateUuidV4();
		$beerStyle = new BeerStyle($beerId,$this->VALID_STYLEID);
		$beerStyle->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoBeerStyle = BeerStyle::getBeerStyleByBeerStyleBeerId($this->getPDO(),$beerId->getBeerId());
		$this->assertEquals($numrows + 1, $this->getConnection()->getRowCount($beerStyle));
		$this->assertEquals($pdoBeerStyle->getBeerId(), $beerStyle);
		$this->assertEquals($beerStyle->getBeerStyle(), $beerStyle);
		}
	}
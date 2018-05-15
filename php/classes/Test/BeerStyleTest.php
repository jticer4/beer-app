<?php
namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\{Beer, Style};

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
class BeerStyleTest extends BeerTest {
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
		$this->style = new Style(1,"pilsner");
		$this->style->insert($this->getPDO());
		}

	public final function tearDown() : void {
		unset($this->VALID_BEERID);
		unset($this->VALID_STYLEID);
	}

	public function testInsertValidBeer() :void {

	}
}
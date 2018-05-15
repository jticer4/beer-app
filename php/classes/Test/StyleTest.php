<?php
namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\StyleTest;

// grab the class under to test
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Style class
 *
 * This is a complete PHPUnit test of the Style Class
 */

class StyleTest extends BeerAppTest {
	/**
	 * valid style type to use
	 * @var string $VALID_STYLETYPE
	 */
	protected $VALID_STYLETYPE = "IPA";

	/**
	 * second valid style type to use
	 * @var string $VALID_STYLETYPE2
	 */
	protected $VALID_STYLETYPE2 = "Stout";

	/**
	 * test inserting a valid Style and verify the actual mySQL data matches
	 */
	public function testInsertValidStyle() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("style");

		$style = new Style($styleId, $this->VALID_STYLETYPE);
		$style->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoStyle = Style::getStyleByStyleId($this->getPDO(), $style-getStyleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$this->assertEquals($pdoStyle->getStyleId(), $this->VALID_STYLE_ID);
		$this->assertEquals($pdoStyle->getStyleType(), $this->VALID_STYLETYPE);
	}

	public function testUpdateValidStyle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("style");

		// create a new Style and insert it into mySQL
		$styleID = null;
		$style = new Style($styleID, $this->VALID_STYLETYPE);
		$style -> insert($this->PDO());

		// edit the Style and update it in mySQL
		$style->setStyleType($this->VALID_STYLETYPE2);
		$style->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoStyle = Style::getStyleByStyleId($this->PDO(), $style->getStyleId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$this->assertEquals($pdoStyle->getStyleId(), $styleId);
		$this->assertEquals($pdoStyle->getStyleType(), $this->VALID_STYLETYPE2);
	}

	/**
	 * test creating a Style and then deleting it
	 */
	public function testDeleteValidStyle() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("style");

		$styleId = null;
		$style = new Style($styleId, $this->VALID_STYLETYPE);
		$style->insert($this->getPDO());

		// delete the Style from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$style->delete($this->getPDO());

		// grab the data from mySQL and enforce the Style does not exist
		$pdoStyle = Style::getStyleByStyleId($this->getPDO(), $style->getStyleId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("style"));
	}

	/**
	 * test inserting a Style and regrabbing it from mySQL
	 */
	public function testGetValidStyleByStyleId() : void {
		$numRows = $this->getConnection()->getRowCount("style");
	}
}
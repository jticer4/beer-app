<?php
namespace Edu\Cnm\Beer\Test;

use Edu\Cnm\Beer\Style;

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

		// create a new style and insert it into mySQL
		$styleId = null;
		$style = new Style($styleId, $this->VALID_STYLETYPE);
		$style->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoStyle = Style::getStyleByStyleId($this->getPDO(), $style-getStyleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$this->assertEquals($pdoStyle->getStyleId(), $styleId);
		$this->assertEquals($pdoStyle->getStyleType(), $this->VALID_STYLETYPE);
	}

	public function testUpdateValidStyle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("style");

		// create a new Style and insert it into mySQL
		$style = new Style($styleId = null, $this->VALID_STYLETYPE);
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

		$style = new Style($styleId = null, $this->VALID_STYLETYPE);
		$style->insert($this->getPDO());

		// delete the Style from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$style->delete($this->getPDO());

		// grab the data from mySQL and enforce the Style does not exist
		$pdoStyle = Style::getStyleByStyleId($this->getPDO(), $style->getStyleId());
		$this->assertNull($pdoStyle);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("style"));
	}

	/**
	 * test inserting a Style and regrabbing it from mySQL
	 */
	public function testGetValidStyleByStyleId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("style");

		$style = new Style($styleId = null, $this->VALID_STYLETYPE);
		$style->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoStyle = Style:: getStyleByStyleId($this->getPDO(), $style->getStyleId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$this->assertEquals($pdoStyle->getStyleId(), $styleId);
		$this->assertEquals($pdoStyle->getStyleType(), $this->VALID_STYLETYPE);
	}

	/**
	 * test grabbing a Style that does not exist
	 */
	public function testGetInvalidStyleByStyleId() : void {
		// grab a style id that exceeds the maximum allowable allowable style id
		$fakeStyleId = null;
		$style = Style::getStyleByStyleId($this->getPDO(), $fakeStyleId);
		$this->assertNull($style);
	}

	/**
	 * test grabbing all Styles
	 */
	public function testGetAllValidStyles(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("style");

		//create new Style and insert into mySQL
		$style = new Style($styleId = null, $this->VALID_STYLETYPE);
		$style->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Style::getAllStyles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("style"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Beer\\Style", $results);

		// grab the result from the array and validate it
		$pdoStyle = $results[0];
		$this->assertEquals($pdoStyle->getStyleId(), $styleId);
		$this->assertEquals($pdoStyle->getStyleType(), $this->VALID_STYLETYPE);
	}

}
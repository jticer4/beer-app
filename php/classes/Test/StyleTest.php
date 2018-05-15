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
	 * Id of the Style selected;
	 * @var int $VALID_STYLE
	 */
	protected $VALID_STYLE_ID;

	/**
	 * valid style type to use
	 * @var
	 */
	protected $VALID_STYLETYPE;


}
<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/classes/autoload.php");

use Ramsey\Uuid\Uuid;

class beerstyle implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * Beer id for the BeerStyle
	 * @var Uuid|string $beerStyleBeerId
	 */
	private $beerStyleBeerId;
	/**
	 * Style id for the BeerStyle
	 * @var Uuid|tinyint $beerStyleStyleId
	 */
	private $beerStyleStyleId;

}

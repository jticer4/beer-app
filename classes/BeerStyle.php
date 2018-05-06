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


	/**
	 * constructor for this BeerStyle
	 *
	 * @param Uuid|string $newBeerStyleBeerId beer id of the BeerStyle
	 * @param Uuid|tinyint $newBeerStyleStyleId style id of the BeerStyle
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
*
	public function __construct(string $newBeerStyleBeerId, tinyint $newBeerStyleStyleId) {
		try {
			$this->setBeerStyleBeerId($newBeerStyleBeerId);
			$this->setBeerStyleStyleId($newBeerStyleStyleId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for BeerStyle beer id
	 *
	 * @return Uuid of BeerStyle beer id
	 */
	public function getBeerStyleBeerId(): Uuid {
		return ($this->beerStyleBeerId);
	}

	/**
	 * mutator method for BeerStyle beer id
	 *
	 * @param Uuid|string $newBeerStyleBeerId
	 */
	public function setBeerStyleBeerId($newBeerStyleBeerId) {
		try {
				$uuid = self::validateUuid($newBeerStyleBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->beerStyleBeerId = $uuid;
	}

}

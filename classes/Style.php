<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/classes/autoload.php");

use Ramsey\Uuid\Uuid;

class style implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for the style of beer
	 * @var Uuid|tinyint $styleId
	 */
	private $styleId;
	/**
	 * style type of beer
	 * @var string $styleType
	 */
	private $styleType;


	/**
	 * @param uuid|tinyint $newStyleId id of style
	 * @param string $newStyleType type of style
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (eg. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(tinyint $newStyleId, string $newStyleType) {
		try {
			$this->setStyleId($newStyleId);
			$this->setStyleType($newStyleType);
		} // determine what execption type was thrown
		catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for style id
	 *
	 * @return Uuid of style id
	 */
	public function getStyleId(): Uuid {
		return($this->styleId);
	}

	/**
	 * mutator method for style id
	 *
	 * @param Uuid|tinyint $newStyleId
	 */
	public function setStyleId($newStyleId) {
		try {
			$uuid = self::validateUuid($newStyleId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the style id
		$this->styleId = $uuid;
	}





}
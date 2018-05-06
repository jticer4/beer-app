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
	public function setStyleId(tinyint $newStyleId) {
		try {
			$uuid = self::validateUuid($newStyleId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the style id
		$this->styleId = $uuid;
	}

	/**
	 * accessor method for style type
	 *
	 * @return string value of style type
	 */
	public function getStyleType(): string {
		return ($this->styleType);
	}

	/**
	 * mutator method for style type
	 *
	 * @param string $newStyleType
	 * @throws \InvalidArgumentException if the type is not a string or insecure
	 * @throws \RangeException if the type is more than 48 characters
	 */
	public function setStyleType(string $newStyleType): void {
		$newStyleType = trim($newStyleType);
		$newStyleType = filter_var($newStyleType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verifies if the username is valid
		if(empty($newStyleType) === true) {
			throw(new \InvalidArgumentException("style type is insecure"));
		}

		//verifies if the style type is less than 48 characters
		if(strlen($newStyleType) > 48)
			throw(new \RangeException("style type is too long, try again"));

		//store the new style type
		$this->styleType = $newStyleType;
	}


	/**
	 * inserts this Style into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO style(styleId, styleType) VALUES(:styleId, :styleType)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["styleId" => $this->styleId->getBytes(), "styleType" => $this->styleType];
		$statement->execute($parameters);
	}




}
<?php
namespace Edu\Cnm\Beer;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/classes/autoload.php");

use Ramsey\Uuid\Uuid;

class style implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for the style of beer
	 * @var int $styleId
	 */
	private $styleId;
	/**
	 * style type of beer
	 * @var string $styleType
	 */
	private $styleType;


	/**
	 * @param int $newStyleId id of style
	 * @param string $newStyleType type of style
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (eg. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newStyleId, string $newStyleType) {
		try {
			$this->setStyleId($newStyleId);
			$this->setStyleType($newStyleType);
		} // determine what exception type was thrown
		catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * TODO CHANGE UUID TO INTEGER, GET RID OF TRY BLOCK. DO IF BLOCK VALUES BETWEEN
	 * accessor method for style id
	 *
	 * @return int of style id
	 */
	public function getStyleId(): int {
		return($this->styleId);
	}

	/**
	 * mutator method for style id
	 *
	 * @param int $newStyleId
	 */
	public function setStyleId(int $newStyleId) {
		$newStyleId = filter_var($newStyleId, FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
		if ($newStyleId < 0 || $newStyleId > 255) {
			throw(new \RangeException("There are no beers with this ID"));
		}

		//convert and store the style id
		$this->styleId = $newStyleId;
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
	 * inserts this Style profile into mySQL
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
		$parameters = ["styleId" => $this->styleId, "styleType" => $this->styleType];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Style profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM style WHERE styleId = :styleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["styleId" => $this->styleId];
		$statement->execute($parameters);
	}


	/**
	 * gets the Style by styleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $messageId message id to search for
	 * @return Message|null Message found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getStyleByStyleId(\PDO $pdo, int $styleId): ?Style {
		// create query template
		$query = "SELECT styleId, styleType FROM style WHERE styleId = :styleId";
		$statement = $pdo->prepare($query);

		// bind the message id to the place holder in the template
		$parameters = ["styleId" => $styleId];
		$statement->execute($parameters);

		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$style = new Style($row["styleId"], $row["styleType"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($style);
	}

	/**
	 * gets all Styles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Styles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllStyles (\PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT styleId, styleType FROM style";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of tweets
		$styles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
					$style = new Style($row["styleId"], $row["styleType"]);
					$styles[$styles->key()] = $style;
					$styles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($styles);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		return ($fields);
	}

}

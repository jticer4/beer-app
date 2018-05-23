<?php
namespace Edu\Cnm\Beer;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use PhpParser\Node\Scalar\String_;
use Ramsey\Uuid\Uuid;

/**
 * Cross section between Beer and Style which creates BeerStyle
 *
 * This is an intersection table (weak entity) from an m-to-n relationship between Beer and Style
 */

class BeerStyle implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * Beer id for the BeerStyle
	 * @var Uuid|string $beerStyleBeerId
	 */
	private $beerStyleBeerId;
	/**
	 * Style id for the BeerStyle
	 * @var int $beerStyleStyleId
	 */
	private $beerStyleStyleId;

	/**
	 * constructor for this BeerStyle
	 *
	 * @param string|Uuid $newBeerStyleBeerId beer id of the BeerStyle
	 * @param int $newBeerStyleStyleId style id of the BeerStyle
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct( string $newBeerStyleBeerId, int $newBeerStyleStyleId) {
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
	public function getBeerStyleBeerId(): string {
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


	/**
	 * accessor method for BeerStyle style id
	 *
	 * @return int of BeerStyle style id
	 */
	public function getBeerStyleStyleId(): int {
		return ($this->beerStyleStyleId);
	}

	/**
	 * mutator method for BeerStyle style id
	 *
	 * @param int $newBeerStyleStyleId
	 */
	public function setBeerStyleStyleId(int $newBeerStyleStyleId) {
		$newBeerStyleStyleId = filter_var($newBeerStyleStyleId, FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
		if($newBeerStyleStyleId < 0 || $newBeerStyleStyleId > 255) {
			throw(new \RangeException("There are no beers with this ID"));
		}

		$this->beerStyleStyleId = $newBeerStyleStyleId;
	}

	/**
	 *inserts BeerStyle style id into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		//create query template
		$query = "INSERT INTO beerStyle (beerStyleBeerId, beerStyleStyleId) VALUES (:beerStyleBeerId, :beerStyleStyleId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["beerStyleBeerId" => $this->beerStyleBeerId->getBytes(), "beerStyleStyleId" =>
			$this->beerStyleStyleId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this BeerStyle from mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM beerStyle WHERE beerStyleBeerId = :beerStyleBeerId AND beerStyleStyleId = :beerStyleStyleId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["beerStyleBeerId" => $this->beerStyleBeerId->getBytes(), "beerStyleStyleId" => $this->beerStyleStyleId];
		$statement->execute($parameters);
	}


	/**
	 * gets the BeerStyle by the BeerStyleBeerId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $beerStyleBeerId id to search by
	 * @return \SplFixedArray SplFixedArray of BeerStyles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getBeerStyleByBeerStyleBeerId (\PDO $pdo, Uuid $beerStyleBeerId) :  \SplFixedArray{
		try {
				$beerStyleBeerId = self::validateUuid($beerStyleBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT beerStyleBeerId, beerStyleStyleId FROM beerStyle WHERE beerStyleBeerId = :beerStyleBeerId";
		$statement = $pdo->prepare($query);

		//bind the beerStyleBeerId to the place holder in the template
		$parameters = ["beerStyleBeerId" => $beerStyleBeerId->getBytes()];
		$statement->execute($parameters);

		//build an array of beer styles
		$beerStyles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
				try {
						$beerStyle = new BeerStyle($row["beerStyleBeerId"], $row["beerStyleStyleId"]);
						$beerStyles[$beerStyles->key()] = $beerStyle;
						$beerStyles->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
		}

		return($beerStyles);
	}

	/**
	 * gets the BeerStyle by the BeerStyleStyleId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $beerStyleStyleId id to search by
	 * @return \SplFixedArray SplFixedArray of BeerStyles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getBeerStyleByBeerStyleStyleId (\PDO $pdo, $beerStyleStyleId) :  \SplFixedArray{
		$beerStyleStyleId = filter_var($beerStyleStyleId, FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
		if($beerStyleStyleId < 0 || $beerStyleStyleId > 255) {
			throw(new \RangeException("There are no beers with this ID"));
		}

		//create query template
		$query = "SELECT beerStyleBeerId, beerStyleStyleId FROM beerStyle WHERE beerStyleStyleId = :beerStyleStyleId";
		$statement = $pdo->prepare($query);

		//bind the beerStyleStyleId to the place holder in the template
		$parameters = ["beerStyleStyleId" => $beerStyleStyleId];
		$statement->execute($parameters);

		//build an array of beer styles
		$beerStyles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$beerStyle = new BeerStyle($row["beerStyleBeerId"], $row["beerStyleStyleId"]);
				$beerStyles[$beerStyles->key()] = $beerStyle;
				$beerStyles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($beerStyles);
	}

	/**
	 * formats the state variable for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["beerStyleBeerId"] = $this->beerStyleBeerId->toString();
		$fields["beerStyleStyleId"] = $this->beerStyleStyleId;
		return ($fields);
	}

}
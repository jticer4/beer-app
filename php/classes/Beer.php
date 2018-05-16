<?php

namespace Edu\Cnm\Beer;

require_once("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Beer implements \JsonSerializable {
	use ValidateUuid;

	/**
	* id for beer, this is the primary key
	* @var Uuid $beerId
	**/
	private $beerId;
	/**
	* profile for beer
	* @var Uuid $beerProfile
	**/
	private $beerProfileId;
	/**
	* ibu number for beer
	* @var int $beerIbu
	**/
	private $beerIbu;
	/**
	* description of the beer
	* @var string $beerDescription
	**/
	private $beerDescription;
	/**
	* abv number for beer
	* @var float $beerAbv
	**/
	private $beerAbv;

	/**
	* name of the beer
	* @var$beerName
	**/
	private $beerName;

	/**
	* constructor for beer
	*
	* @param string|Uuid $newBeerId id for beer or null if a new beer
	* @param string|Uuid $newBeerProfile id for beer profile
	* @param float $newBeerAbv decimal containing abv for beer
	* @param string $newBeerDescription string containing description of beer
	* @param int $newBeerIbu tinyint containing ibu for beer
	* @param string $newBeerName string containing name of beer
	* @throws \InvalidArgumentException if data types are not valid
	* @throws \RangeException if data values are out of bounds
	* @throws \Exception for when an exception is thrown
	* @throws \TypeError if data types violate type hints
	* @documentation https://php.net/manual/en/language.oop5.decon.php
	**/
	public function __construct($newBeerId, $newBeerProfileId, float $newBeerAbv, string $newBeerDescription, int $newBeerIbu, string $newBeerName ) {
		try {
			$this->setBeerId($newBeerId);
			$this->setBeerProfileId($newBeerProfileId);
			$this->setBeerAbv($newBeerAbv);
			$this->setBeerDescription($newBeerDescription);
			$this->setBeerIbu($newBeerIbu);
			$this->setBeerName($newBeerName);
	}
	//determine the exception that was thrown
	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	$exceptionType = get_class($exception);
	throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	* accessor method for beer id
	*
	* @return Uuid value of beer id
	**/
	public function getBeerId(): Uuid {
	return $this->beerId;
	}

	/**
	* mutator method for beer id
	*
	* @param Uuid|string $beerId new value of beer id
	* @throws \RangeException if $newBeerId is null
	* @throws \TypeError if $newBeerId is not a uuid
	**/
	public function setBeerId(Uuid $newBeerId): void {
		try {
			$uuid = self::validateUuid($newBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store beer id
		$this->beerId = $uuid;
		}

	/**
	* accessor method for beer profile id
	*
	* @return Uuid for beer profile id
	**/
	public function getBeerProfileId(): Uuid {
		return $this->beerProfileId;
	}

	/**
	* mutator method for beer profile id
	*
	* @param Uuid $beerProfileId
	* @throws \RangeException if beer profile id is null
	* @throws \TypeError if beer profile id is null
	**/
	public function setBeerProfileId(Uuid $newBeerProfileId): void {
		try {
			$uuid = self::validateUuid($newBeerProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store beer profile id
		$this->beerProfileId = $uuid;
		}

	/**
	 * accessor method for beer abv
	 *
	 * @return float for beer abv
	 **/
	public function getBeerAbv(): float {
		return $this->beerAbv;
	}

	/**
	 * mutator method for beer abv
	 *
	 * @param float $beerAbv
	 * @throws \RangeException when input is out of range
	 **/
	public function setBeerAbv(float $newBeerAbv): void {
		if($newBeerAbv > 0.0 || $newBeerAbv < 16.0) {
			throw(new \RangeException("beer abv is out of range"));
		}
		//convert and store the beer abv
		$this->beerAbv = $newBeerAbv;
	}

	/**
	 * accessor method for beer description
	 *
	 * @return string for beer description
	 **/
	public function getBeerDescription(): string {
		return $this->beerDescription;
	}

	/**
	 * mutator method for beer description
	 *
	 * @param string $newBeerDescription
	 * @throws \InvalidArgumentException when beer description is too big
	 **/
	public function setBeerDescription(string $newBeerDescription): void {
		$newBeerDescription = trim($newBeerDescription);
		$newBeerDescription = filter_var($newBeerDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newBeerDescription) > 1024) {
			throw(new \InvalidArgumentException("beer description is too large"));
		}
		//convert and store the beer description
		$this->beerDescription = $newBeerDescription;
	}

	/**
	* accessor method for beer ibu
	*
	* @return int for beer ibu
	**/
	public function getBeerIbu(): int {
		return $this->beerIbu;
	}

	/**
	* mutator method for beer ibu
	*
	* @param int $beerIbu beer ibu range is from 0-120
	* @throws \RangeException when input is out of range
	**/
	public function setBeerIbu(int $newBeerIbu): void {
		if($newBeerIbu < 0 || $newBeerIbu > 120) {
			throw(new \RangeException("ibu is out of range"));
		}
		//convert and store beer ibu
		$this->beerIbu = $newBeerIbu;
		}


	/**
	* accessor method for beer name
	*
	* @return $beerName string for beer name
	**/
	public function getBeerName(): string {
		return $this->beerName;
	}

	/**
	* mutator method for beer name
	*
	* @param string $beerName
	* @throws \InvalidArgumentException when there's no beer name or if its insecure
	* @throws \RangeException when beer name is too large
	**/
	public function setBeerName($newBeerName): void {
		$newBeerName = trim($newBeerName);
		$newBeerName = filter_var($newBeerName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newBeerName === true)) {
			throw(new \InvalidArgumentException("beer name is either empty or insecure"));
		}
		if(strlen($newBeerName) > 128) {
			throw(new \RangeException("beer name content is too large"));
		}
		//convert and store the beer name
		$this->beerName = $newBeerName;
	}


	/**
	* inserts this beer into mysql
	*
	* @param \PDO $pdo connection object
	* @throws \PDOException when mySQL related errors occur
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO beer(beerId, beerProfileId, beerAbv, beerIbu, beerDescription, beerName) VALUES(:beerId, :beerProfile, :beerAbv, :beerDescription, :beerIbu, :beerName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = [
			"beerId" => $this->beerId->getBytes(),
			"beerProfileId" => $this->beerProfileId->getBytes(),
			"beerIbu" => $this->beerAbv,
			"beerAbv" => $this->beerIbu,
			"beerName" => $this->beerDescription,
			"beerDescription" => $this->beerName,
		];
		$statement->execute($parameters);
		}

	/**
	* deletes this beer from mysql
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException when mySQL  related errors occur
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM beer WHERE beerId = :beerId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["beerId" => $this->beerId->getbytes()];
		$statement->execute($parameters);
	}

	/**
	* updates this beer in mysql
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException when mySQL related errors occur
	* @throws  \TypeError if $pdo is not a PDO object
	*
	**/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE beer SET beerProfileId = :beerProfileId, beerAbv = :beerAbv, beerDescription = :beerDescription, beerIbu = :beerIbu, beerName = :beerName WHERE beerId = beerId";
		$statement = $pdo->prepare($query);

		$parameters = [
			"beerId" => $this->beerId->getBytes(),
			"beerProfileId" => $this->beerProfileId->getBytes(),
			"beerAbv" => $this->beerAbv,
			"beerDescription" => $this->beerDescription,
			"beerIbu" => $this->beerIbu,
			"beerName" => $this->beerName
		];
		$statement->execute($parameters);
	}

	/**
	*gets beer by beer id
	*
	* @param \PDO $pdo PDO connection object
	* @param Uuid|string $beerId beer id to search for
	* @return Beer|null beer found or null if not found
	* @throws \PDOException when mySQL related errors occur
	* @throws \TypeError when a variable are not the correct data type
	**/
	public static function getBeerbyBeerId(\PDO $pdo, $beerId): ?Beer {
		//sanitize the beerId before searching
		try {
			$beerId = self::validateUuid($beerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException(($exception->getMessage()), 0, $exception));
		}

		//create query template
		$query = "SELECT beerId, beerProfileId, beerAbv, beerDescription, beerIbu, beerName from beer where beerId = :beerId";
		$statement = $pdo->prepare($query);

		//bind the beer id to the place
		$parameters = ["beerId" => $beerId->getBytes()];
		$statement->execute($parameters);

		//grab beer from mysql
		try {
			$beer = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$beer = new Beer($row["beerId"], $row["beerProfileId"], $row["beerAbv"], $row["beerDescription"], $row["beerIbu"], $row["beerDescription"]);
		}
		} catch(\Exception $exception) {
		//if the row couldn't be converted rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	return ($beer);
	}

	/**
	*gets the beer using the profile id
	*
	* @param \PDO $pdo PDO connection object
	* @param Uuid|string $beerProfileId profile id to search by
	* @return \SplFixedArray of beers found
	* @throws \PDOException when mySQL related errors occur
	* @throws \TypeError when variables are not the correct date type
	**/
	public static function getBeerByBeerProfileId(\PDO $pdo, $beerProfileId): \SplFixedArray {

		try {
			$beerProfileId = self::validateUuid($beerProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT beerId, beerProfileId, beerIbu, beerAbv, beerName, beerDescription FROM beer where beerProfileId = :beerProfileId";
		$statement = $pdo->prepare($query);
		//bind the beer profile id to the place holder
		$parameters = ["beerProfileId" => $beerProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of beers
		$beers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$beer = new Beer($row["beer"], $row ["beerProfileId"], $row ["beerIbu"], $row ["beerAbv"], $row ["beerName"], $row ["beerDescription"]);
				$beers[$beers->key()] = $beer;
				$beers->next();
			} catch(\Exception $exception) {
		//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($beers);
	}

	/**
	 * get beer by beer abv
	 *
	 * @param \PDO $pdo Pdo connection object
	 * @return \SplFixedArray of beers found or null if not found
	 * @throws
	 **/
	public static function getBeerByBeerAbv(\PDO $pdo, float $beerAbv) : \SplFixedArray {
		//sanitize the description before searching
		$beerAbv = filter_var($beerAbv, FILTER_VALIDATE_FLOAT, FILTER_SANITIZE_NUMBER_FLOAT);
		if(empty($beerAbv) === true){
			throw(new \PDOException("beer abv is invalid"));
		}
		//create query template
		$query ="SELECT beerId, beerProfileId, beerAbv, beerIbu, beerName, beerDescription FROM beer WHERE beerAbv LIKE :beerAbv";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of beers
		$beers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$beer = new Beer(
					$row["beerId"],
					$row["beerProfileId"],
					$row["beerAbv"],
					$row["beerIbu"],
					$row["beerName"],
					$row["beerDescription"]);
				$beers[$beers->key()] = $beer;
				$beers->next();
			}catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($beers);
	}

	/**
	 *gets beer by beer Ibu
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $beerIbu beer ibu for searching
	 * @return \SplFixedArray SplFixedArray of beers found or null if not found
	 * @throws \RangeException if ibu is out of range
	 * @throws \TypeError whe variables are not the correct data
	 **/
	public static function getBeerByBeerIbu(\PDO $pdo, int $beerIbu) : \SplFixedArray {
		//sanitize the description before searching
		$beerIbu =filter_var($beerIbu, FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
		if($beerIbu < 0 || $beerIbu > 120) {
			throw(new \RangeException("ibu is out of range"));
		}

		//create query template
		$query = "SELECT beerId, beerProfileId, beerAbv, beerDescription, beerIbu, beerName, FROM beer where beerIbu LIKE :beerIbu";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of beers
		$beers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$beer = new Beer(
					$row["beerId"],
					$row["beerProfileId"],
					$row["beerAbv"],
					$row["beerDescription"],
					$row["beerIbu"],
					$row["beerName"]);
				$beers[$beers->key()] = $beer;
				$beers->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(),0, $exception));
			}
		}
		return ($beers);
	}

	/**
	*gets the beer by the beer name
	*
	*@param \PDO $pdo PDO connection object
	*@param string $beerName beer name for searching
	*@return \SplFixedArray SplFixedArray of beers found
	*@throws \PDOException when mySQL related errors occur
	*
	**/
	public static function getBeerByBeerName(\PDO $pdo, string $beerName) : \SplFixedArray {
		// sanitize the description before searching
		$beerName = trim($beerName);
		$beerName = filter_var($beerName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($beerName) === true) {
			throw(new \PDOException("beer content is invalid"));
		}
		// escape any mySQL wild cards
		$beerName = str_replace("_", "\\_", str_replace("%", "\\%", $beerName));

		//create query template
		$query = "SELECT beerID, beerProfileId, beerIbu, beerAbv, beerName, beerDescription FROM beer WHERE beerName LIKE :beerName";
		$statement = $pdo->prepare($query);

		//bind the beer name
		$beerName = "%beerName%";
		$parameters = ["beerName" => $beerName];
		$statement->execute($parameters);

		//build an array of beers
		$beers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$beer = new Beer($row["beerId"], $row["beerProfileId"], $row["beerIbu"], $row["beerAbv"], $row["beerName"], $row["beerDescription"]);
				$beers[$beers->key()] = $beer;
				$beers->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return($beers);
	}

	/**
	* gets all styles
	*
	* @param \PDO $pdo PDO connection obeject
	* @return
	* @throws
	* @throws
	**/
	public static function getAllBeers (\PDO $pdo) : \SplFixedArray {
		//create query templates
		$query = "SELECT beerId, beerProfileId, beerDescription, beerIbu, beerName FROM beer";
		$statement = $pdo->prepare($query);
		$statement ->execute();

		//build an array of tweets
		$beers = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$beer = new Beer(
						$row["beerId"],
						$row["beerProfileId"],
						$row["beerAbv"],
						$row["beerDescription"],
						$row["beerIbu"],
						$row["beerName"]);
					$beers[$beers->key()] = $beer;
					$beers->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($beers);
	}

	/**
	* formats the state variables for JSON serialization
	*
	* @return array resulting state variables to serialize
	**/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["beerId"] = $this->beerId->toString();
		$fields["beerProfileId"] = $this->beerProfileId->toString();
		return($fields);
	}
	}











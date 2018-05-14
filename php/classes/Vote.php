<?php

namespace Edu\Cnm\Beer;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "vendor/autoload.php");

/**
 * Class of Vote takes the beer being voted, the profile doing the voting, and whether the vote is and up or down.
 *
 */


class Vote implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id of Beer being voted on;
	 * half of composite key
	 *
	 * @var Uuid $voteBeerId
	 */
	private $voteBeerId;

	/**
	 * id of Profile that is up or down voting;
	 *half of composite key
	 *
	 * @var Uuid $voteBeerId
	 */
	private $voteProfileId;

	/**
	 * value of vote; must be
	 *
	 * @var int $voteValue
	 */
	private $voteValue;

	/**
	 * constructor for vote
	 *
	 * @param string|Uuid $newVoteBeerId id of beer being voted on, NOT NULL
	 * @param string|Uuid $newVoteProfileId id of Profile casting a vote, NOT NULL
	 * @param int $newVoteValue value of vote, NOT NULL
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */

	public function __construct($newVoteBeerId, $newVoteProfileId, int $newVoteValue) {
		try {
			$this->setVoteBeerId($newVoteBeerId);
			$this->setVoteProfileId($newVoteProfileId);
			$this->setVoteValue($newVoteValue);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for this vote's beer id
	 *
	 * @return Uuid value of the beer being voted on
	 */
	public function getVoteBeerId() :string {

		return ($this->voteBeerId);
	}

	/**
	 * mutator method for this vote's beer id
	 *
	 * @param Uuid|string $newVoteBeerId new value of the BeerId being voted on
	 * @throws \InvalidArgumentException if $voteBeerId is not a valid argument
	 * @throws \RangeException if $voteBeerId is not positive
	 * @throws \TypeError if $voteBeerId is not a uuid or string
	 */
	public function setVoteBeerId($newVoteBeerId) : void {
		try{
			$uuid = self::validateUuid($newVoteBeerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception ) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->voteBeerId = $uuid;
	}

	/**
	 * accessor method for the Profile Id that is voting
	 *
	 * @return uuid value of $voteProfileId
	 */
	public function getVoteProfileId() :string {
		return ($this->voteProfileId);
	}

	/**
	 * mutator method for the ProfileId of this vote
	 *
	 * @param Uuid|string $newVoteProfileId new value of ProfileId of this vote
	 * @throws \InvalidArgumentException if $voteProfileId is not a valid argument
	 * @throws \RangeException if $voteProfileId is not positive
	 * @throws \TypeError is $voteProfileId is not of expected type
	 */
	public function setVoteProfileId($newVoteProfileId) : void {
		try {
			$uuid = self::validateUuid($newVoteProfileId);
		} catch (\InvalidArgumentException | \RangeException | TypeError |Exception $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->voteProfileId = $uuid;
	}

	/**
	 * accessor method for vote value
	 *
	 * @return int
	 */
	public function getVoteValue() :int {
		return $this->voteValue;
	}

	/**
	 * mutator method for $voteValue
	 *
	 * @param int $voteValue
	 * @throws \TypeError if $pdo is not correct data type
	 */
	public function setVoteValue(int $voteValue) :void {
		$newVoteValue = $voteValue;
		$newVoteValue = filter_var($newVoteValue, FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

	//checks to see if $newVoteValue is and integer less than or equal to 1
		if ($newVoteValue!=-1 || $newVoteValue!=1) {
			throw (new \TypeError("voteValue is invalid or insecure."));
		}

		$this->voteValue = $voteValue;
	}

	/**
	 * Inserts this vote into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO vote(voteValue, voteProfileId, voteBeerId) VALUES(:voteValue, :voteProfileId, :voteBeerId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(),"voteBeerId" => $this->voteBeerId->getBytes(),"voteValue" => $this->voteValue,];
		$statement->execute($parameters);
	}

	/**
	 * deletes this this Vote from from mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM vote WHERE voteProfileId = :voteProfileId AND voteBeerId = :voteBeerId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(), "voteBeerId" =>
			$this->voteBeerId->getBytes()];
		$statement->execute($parameters);
	}

	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["voteBeerId"] = $this->voteValue->toString();
		$fields["voteProfileId"] = $this->voteProfileId->toString();
		return ($fields);
	}

}
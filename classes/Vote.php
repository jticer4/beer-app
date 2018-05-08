<?php

class Vote implements \JsonSerializable {

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
	 * @param string|Uuid $voteBeerId id of beer being voted on, NOT NULL
	 * @param string|Uuid $voteProfileId id of Profile casting a vote, NOT NULL
	 * @param int $voteValue value of vote, NOT NULL
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */

	public function __construct($newVoteBeerId, $newVoteProfileId, $newVoteValue) {
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
	 * @param Uuid|string $voteBeerId new value of the BeerId being voted on
	 * @throws \InvalidArgumentException if $voteBeerId is not a valid argument
	 * @throws \RangeException if $voteBeerId is not positive
	 * @throws \TypeError if $voteBeerId is not a uuid or string
	 */
	public function setVoteBeerId($voteBeerId) : void {
		try{
			$uuid = self::validateUuid($voteBeerId);
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
	 * @param Uuid|string $voteProfileId new value of ProfileId of this vote
	 * @throws \InvalidArgumentException if $voteProfileId is not a valid argument
	 * @throws \RangeException if $voteProfileId is not positive
	 * @throws \TypeError is $voteProfileId is not of expected type
	 */
	public function setVoteProfileId($voteProfileId) : void {
		try {
			$uuid = self::validateUuid($voteProfileId);
		} catch (\InvalidArgumentException | \RangeException | TypeError |Exception $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->voteProfileId = $voteProfileId;
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
	 */
	public function setVoteValue(int $voteValue) :void {
		$newVoteValue = $voteValue;
		$newVoteValue = filter_var($newVoteValue, FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

	//checks to see if $newVoteValue is and integer less than or equal to 1
		if ((is_int($newVoteValue)) || $newVoteValue<=1) {
			throw (new \TypeError("voteValue is invalid or insecure."));
		}

		$this->voteValue = $voteValue;
	}

	/**
	 * inserts this vote into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO vote(voteValue) VALUES(:voteValue)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["voteProfileId" => $this->voteProfileId->getBytes(),"voteBeerId" => $this->voteBeerId->getBytes(),"voteValue" => $this->voteValue,];
		$statement->execute($parameters);
	}






}
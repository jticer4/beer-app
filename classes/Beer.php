<?php
namespace Edu\Cnm;

require_once("autoload.php");
require_once(dirname(__DIR__, 2)) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * @author Carlos Marquez <carl.marq95@gmail.com>
 * @version 0.0.1
**/
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
		private $beerProfile;
		/**
		 * ibu number for beer
		 * @var tinyint$beerIbu
		 **/
		private $beerIbu;
		/**
		 * abv number for beer
		 * @var decimal $beerAbv
		 **/
		private $beerAbv;
		/**
		 * name of the beer
		 * @var$beerName
		 **/
		private $beerName;
		/**
		 * description of the beer
		 * @var string $beerDescription
		 **/
		private $beerDescription;
		/**
		 * constructor for beer
		 *
		 * @param string|Uuid $newBeerId id for beer or null if a new beer
		 * @param string|Uuid $newBeerProfile id for beer profile
		 * @param tinyint $newBeerIbu tinyint containing ibu for beer
		 * @param decimal $newBeerAbv decimal containing abv for beer
		 * @param string $newBeerName string containing name of beer
		 * @param string $newBeerDescription string containing description of beer
		 * @throws \InvalidArgumentException if data types are not valid
		 * @throws \RangeException if data values are out of bounds
		 * @throws \Exception for when an exception is thrown
		 * @throws \TypeError if data types violate type hints
		 * @documentation https://php.net/manual/en/language.oop5.decon.php
		 **/
		public function __construct($newBeerId, $newBeerProfile, tinyint $newBeerIbu, decimal $newBeerAbv, string $newBeerName, string $newBeerDescription) {
			try {
				$this->setBeerId($newBeerId);
				$this->setBeerProfile($newBeerProfile);
				$this->setBeerIbu($newBeerIbu);
				$this->setBeerAbv($newBeerAbv);
				$this->setBeerName($newBeerName);
				$this->setBeerDescription($newBeerDescription);
				}
				//determine the exception that was thrown
			catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}
	}

		/**
		 * accessor method for beer id
		 * @return Uuid value of beer id
		 */
		public function getBeerId(): Uuid {
			return $this->beerId;
		}

		/**
		 * mutator method for beer id
		 * @param Uuid|string $beerId new value of beer id
		 * @throws \RangeException if $newBeerId is null
		 * @throws \TypeError if $newBeerId is not a uuid
		 */
		public function setBeerId(Uuid $beerId) : void {
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
		 * accessor method for beer profile
		 * @return Uuid for beer profile
		 */
		public function getBeerProfile(): Uuid {
			return $this->beerProfile;
		}

		/**
		 * mutator method for beer profile
		 * @param Uuid $beerProfile
		 */
		public function setBeerProfile(Uuid $beerProfile) : void {
				//verify the beer profile is secure
				$newBeerProfile = trim($newBeerProfile);
				$newBeerProfile = filter_var($newBeerProfile, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
				if(empty($newBeerProfile) === true) {
					throw(new \InvalidArgumentException("new beer profile is empty or insecure")):
				}
				//verify beer profile will fit into the database
				if(strlen($newBeerProfile) > 255) {
					throw(new \RangeException("beer profile is too large"));
			}
			//store the beer profile
			$this->beerProfile = $beerProfile;
		}

		/**
		 * accessor method for beer ibu
		 * @return tinyint for beer ibu
		 */
		public function getBeerIbu(): tinyint {
			return $this->beerIbu;
		}

		/**
		 * mutator method for beer ibu
		 * @param tinyint $beerIbu
		 */
		public function setBeerIbu(tinyint $beerIbu) : void {
			$this->beerIbu = $beerIbu;
		}

		/**
		 * accessor method for beer abv
		 * @return decimal
		 */
		public function getBeerAbv(): decimal {
			return $this->beerAbv;
		}

		/**
		 * mutator method for beer abv
		 * @param decimal $beerAbv
		 */
		public function setBeerAbv(decimal $beerAbv) : void {
			$this->beerAbv = $beerAbv;
		}

		/**
		 * accessor method for beer name
		 * @return mixed
		 */
		public function getBeerName() {
			return $this->beerName;
		}

		/**
		 * mutator method for beer name
		 * @param mixed $beerName
		 */
		public function setBeerName($beerName) :void {
			$this->beerName = $beerName;
		}

		/**
		 * accessor method for beer description
		 * @return string
		 */
		public function getBeerDescription(): string {
			return $this->beerDescription;
		}

		/**
		 * mutator method for beer description
		 * @param string $beerDescription
		 */
		public function setBeerDescription(string $beerDescription) :void {
			$this->beerDescription = $beerDescription;
		}








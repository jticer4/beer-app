<?php
namespace

require_once("autoload.php");
require_once(dirname(__DIR__, 2)) . "vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * @author Carlos Marquez carl.arq95@gmail.com
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
	 *constructor for beer
	 *
	**/
	public function __construct(){
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
			throw(new $exceptionType($exception->getMessage(), 0, $exception);
		}
}

}






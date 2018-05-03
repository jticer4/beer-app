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
		 * @var $beerIbu
		**/
		private string $beerIbu;
		/**
		 * abv number for beer
		 * @var $beerAbv
		**/
		private string $beerAbv;
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
	}
	/**
	 *constructor for beer
	**/
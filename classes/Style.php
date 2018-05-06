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
}
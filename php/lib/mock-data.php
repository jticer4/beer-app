/**<?php
use Edu\Cnm\Beer\{Profile, Beer, Style};

require_once (dirname(__dir__) . "/classes/autoload.php");

require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

require_once ("uuid.php");

$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/beer.ini");

$SALT = bin2hex(random_bytes(32));

//Profile 1 - Bosque Brewing Company
$password = "fucking work";
$HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile = new Profile(generateUuidV4(),null, null, "8900 San Mateo Blvd. NE", "Suite I", "Albuquerque", "ross@bosquebrewing.com", $HASH, null, "Ross", "NM", "Bosque Brewing Brewing & Taproom", "1", "87113");
$profile->insert($pdo);
echo "Bosque Brewing Co.";
var_dump($profile->getProfileId()->toString());

//Profile 2 - Bow & Arrow Brewing Co.
$password2 = "OhYEAH!";
$HASH2 = password_hash($password2, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile2 = new Profile(generateUuidV4(),null, null, "608 McKnight Ave. NW", null,"Albuquerque", "info@bowandarrowbrewing.com", $HASH2, null, "Ted O'Hanlan", "NM", "Bow & Arrow Brewing Co.", "1", "87102");
$profile2->insert($pdo);
echo "Bow & Arrow Brewing Co.";
var_dump($profile2->getProfileId()->toString());

//Profile 3 - Hops Brewery
$password3 = "HoppinOff123";
$HASH3 = password_hash($password3, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile3 = new Profile(generateUuidV4(),null, null, "3507 Central Avenue NE", null, "Albuquerque", "brewer@hopsbrewing.com", $HASH3, null, "Ken Wimmer", "NM", "Hops Brewery","1", "87106");
$profile3->insert($pdo);
echo "Hops Brewery";
var_dump($profile3->getProfileId()->toString());

//Profile 4 - La Cumbre
$password4 = "Elevated505";
$HASH4 = password_hash($password4, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile4 = new Profile(generateUuidV4(),null, null, "3313 Girard Blvd. NE", null, "ABQ", "alan@lacumbrebrewing.com", $HASH4, null, "Alan Skinner", "NM", "La Cumbre Brewing Company", "1", "87107");
$profile4->insert($pdo);
echo "La Cumbre Brewing Company";
var_dump($profile4->getProfileId()->toString());

//Profile 5 - Marbles
$password5 = "1st&Marble1802";
$HASH5 = password_hash($password5, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile5 = new Profile(generateUuidV4(),null, null, "111 Marble Ave NW", null, "Burque", "taprooms@marblebrewery.com", $HASH5, null, "Brew Er", "NM", "Marble Brewery", "1", "87102");
$profile5->insert($pdo);
echo "Marble Brewery";
var_dump($profile5->getProfileId()->toString());

//Profile 6  - Monk's
$password6 = "BowDown575";
$HASH6 = password_hash($password6, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile6 = new Profile(generateUuidV4(),null, null, "205 Silver Ave SW", "Suite G", "Albuquerque", "info@abbeybrewing.biz", $HASH6, null, "Brew Tus", "NM", "Monk's Corner Taproom", "1", "87102" );
$profile6->insert($pdo);
echo "Monk's Corner Taproom";
var_dump($profile6->getProfileId()->toString());

//Profile 7 - Nexus
$password7 = "DatFlightTho505";
$HASH7 = password_hash($password7, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile7 = new Profile(generateUuidV4(),null, null, "4730 Pan American Fwy East NE", "Suite D", "Albuquerque", "info@nexusbrewery.com", $HASH7, null, "Randy King", "NM", "Nexus Brewery", "1", "87109");
$profile7->insert($pdo);
echo "Nexus Brewery & Restaurant";
var_dump($profile7->getProfileId()->toString());

//Profile 8 - Red Door
$password8 = "BeersAndBrews505";
$HASH8 = password_hash($password8, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile8 = new Profile(generateUuidV4(),null,null, "1001 Candelaria Rd NE", null,"Albuquerque", "info@reddoorbrewing.com", $HASH8, null,"Betty Brews", "NM","Red Door Brewing Co.", "1", "87107");
$profile8->insert($pdo);
echo "Red Door Brewing Company";
var_dump($profile8->getProfileId()->toString());

//Profile 9 - Santa Fe
$password9 = "NorthSide575";
$HASH9 = password_hash($password9, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile9 = new Profile(generateUuidV4(), null,null,"3600 Cutler Ave NE", "#1", "Burque", "info@santafebrewing.com", $HASH9, null, "Brew Ski", "NM", "Santa Fe Brewing Co.", "1", "87110");
$profile9->insert($pdo);
echo "Santa Fe Brewing Company";
var_dump($profile9->getProfileId()->toString());

//Profile 10 - Tractor
$password10 = "GetPlowedABQ";
$HASH10 = password_hash($password10, PASSWORD_ARGON2I, ["time_cost" => 384]);

$profile10 = new Profile(generateUuidV4(), null, null, "1800 4th St NW", null, "Albuquerque", "info@getplowed.com", $HASH10, null, "Track Tour", "NM", "Tractor Brewing Co.","1", "87102");
$profile10->insert($pdo);
echo "Tractor Brewing Company";
var_dump($profile10->getProfileId()->toString());
ALTER	DATABASE bkie3 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS beer;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId Binary(16) NOT NULL,
	profileAbout VARCHAR(140),
	profileAddressLine1 VARCHAR(96) NOT NULL,
	profileAddressLine2 VARCHAR(96),
	profileCity VARCHAR(48) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileImage VARCHAR(255),
	profileName VARCHAR(64) NOT NULL,
	profileState CHAR(2) NOT NULL,
	profileUsername VARCHAR(48) NOT NULL,
	profileUserType CHAR(1) NOT NULL,
	profileZip VARCHAR(10) NOT NULL,
	PRIMARY KEY(profileId)
);

CREATE TABLE beer (
	beerId Binary(16), NOT NULL (PRIMARY KEY)</li>
beerProfileId Binary(16), NOT NULL (FOREIGN KEY)</li>
beerAbv Decimal(6,6), NOT NULL</li>
beerDescription VarChar(1024)</li>
beerIbu TinyInt (unsigned)</li>
beerName VarChar(128), NOT NULL</li>
)

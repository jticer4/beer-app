ALTER	DATABASE bkie3 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS beerstyle;
DROP TABLE IF EXISTS beer;
DROP TABLE IF EXISTS style;
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

CREATE TABLE style (
	styleId TINYINT UNSIGNED NOT NULL,
	styleType VARCHAR(48) NOT NULL,
	PRIMARY KEY(styleId)
);

CREATE TABLE beer (
	beerId BINARY(16) NOT NULL,
	beerProfileId BINARY(16) NOT NULL,
	beerAbv DECIMAL(6,6) NOT NULL,
	beerDescription VARCHAR(1024),
	beerIbu TINYINT UNSIGNED ,
	beerName VARCHAR(128) NOT NULL,
	UNIQUE(beerProfileId),
	INDEX(beerProfileId),
	FOREIGN KEY(beerProfileId) REFERENCES profile(profileId)
);

CREATE TABLE beerstyle(
	beerStyleBeerId BINARY(16) NOT NULL,
	beerStyleStyleId TINYINT UNSIGNED NOT NULL,
	UNIQUE(beerStyleBeerId),
	INDEX(beerStyleBeerId),
	INDEX(beerStyleStyleId),
	FOREIGN KEY(beerStyleBeerId) REFERENCES beer(beerId),
	FOREIGN KEY(beerStyleStyleId) REFERENCES style(styleId)
);

CREATE TABLE vote (
	voteBeerId BINARY(16) NOT NULL,
	voteProfileId BINARY(16) NOT NULL,
	voteValue TINYINT NOT NULL,
	UNIQUE(voteBeerId),
	INDEX(voteBeerId),
	INDEX(voteProfileId),
	FOREIGN KEY(voteBeerId) REFERENCES beer(beerId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId)
);

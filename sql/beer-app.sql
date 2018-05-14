ALTER	DATABASE beer CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS beerStyle;
DROP TABLE IF EXISTS beer;
DROP TABLE IF EXISTS style;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId Binary(16) NOT NULL,
	profileAbout VARCHAR(140),
	profileActivationToken CHAR(32),
	profileAddressLine1 VARCHAR(96),
	profileAddressLine2 VARCHAR(96),
	profileCity VARCHAR(48),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileImage VARCHAR(255),
	profileName VARCHAR(64),
	profileState CHAR(2),
	profileUsername VARCHAR(48) NOT NULL,
	profileUserType CHAR(1) NOT NULL,
	profileZip VARCHAR(10),
	UNIQUE (profileEmail),
	UNIQUE (profileUsername),
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
	INDEX(beerProfileId),
	FOREIGN KEY(beerProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(beerId)
);

CREATE TABLE beerStyle(
	beerStyleBeerId BINARY(16) NOT NULL,
	beerStyleStyleId TINYINT UNSIGNED NOT NULL,
	INDEX(beerStyleBeerId),
	INDEX(beerStyleStyleId),
	FOREIGN KEY(beerStyleBeerId) REFERENCES beer(beerId),
	FOREIGN KEY(beerStyleStyleId) REFERENCES style(styleId),
	PRIMARY KEY(beerStyleBeerId, beerStyleStyleId)
);

CREATE TABLE vote (
	voteBeerId BINARY(16) NOT NULL,
	voteProfileId BINARY(16) NOT NULL,
	voteValue TINYINT NOT NULL,
	INDEX(voteBeerId),
	INDEX(voteProfileId),
	FOREIGN KEY(voteBeerId) REFERENCES beer(beerId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(voteBeerId, voteProfileId)
);

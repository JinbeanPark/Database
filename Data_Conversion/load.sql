DROP TABLE IF EXISTS Organization;
DROP TABLE IF EXISTS People;
DROP TABLE IF EXISTS AwardedPrizes;


CREATE TABLE Organization (
    id INT NOT NULL,
    orgName VARCHAR(100),
    foundedDate DATE,
    foundedCity VARCHAR(50),
    foundedCountry VARCHAR(50),
    PRIMARY KEY(id)
);

CREATE TABLE People (
    id INT NOT NULL,
    givenName VARCHAR(100),
    familyName VARCHAR(100),
    gender VARCHAR(6),
    birthDate DATE,
    birthCity VARCHAR(50),
    birthCountry VARCHAR(50),
    PRIMARY KEY(id)
);

CREATE TABLE AwardedPrizes (
    id INT NOT NULL,
    awardYear INT NOT NULL,
    category VARCHAR(100),
    sortOrder INT,
    portion VARCHAR(10),
    prizeStatus VARCHAR(100),
    dateAwarded DATE,
    motivation VARCHAR(100),
    prizeAmount INT,
    affiliationName VARCHAR(100),
    affiliationCity VARCHAR(50),
    affiliationCountry VARCHAR(50),
    PRIMARY KEY(id, awardYear)
);

LOAD DATA LOCAL INFILE 'organization.del' INTO TABLE Organization
FIELDS TERMINATED BY '@';
LOAD DATA LOCAL INFILE 'people.del' INTO TABLE People
FIELDS TERMINATED BY '@';
LOAD DATA LOCAL INFILE 'AwardedPrizes.del' INTO TABLE AwardedPrizes
FIELDS TERMINATED BY '@';
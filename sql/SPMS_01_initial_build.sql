/**
*Author: Koro
*File: SPMS_01_initial_build.sql
*Date created: 04/July/2012
*Date last modified: 04/July/2012
*Changelog: 
*/



CREATE DATABASE IF NOT EXISTS SPMS CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS ScanGroup(

	groupID smallint unsigned not null AUTO_INCREMENT,
	groupName varchar(30) not null,
	URL varchar(50) null,
	PRIMARY KEY (groupID)

);

CREATE TABLE IF NOT EXISTS Series(

	seriesID smallint unsigned not null AUTO_INCREMENT,
	seriesTitle varchar(50) not null,
	status character null,
	genrePrimary varchar(20) null,
	genreSecondary varchar(20) null,
	description varchar(255) null,
	thumbnailURL varchar(50) null,
	projectManagerID smallint unsigned null,
	visibleToPublic boolean not null,
	isAdult boolean not null,
	PRIMARY KEY (seriesID)

);

CREATE TABLE IF NOT EXISTS Chapter(

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null, --eg. 5 if the chapter is 10.5
	chapterRevisionNumber tinyint unsigned not null, --0 by default; only changes when chapter has been revised after release
	chapterName varchar(50) null,
	groupOne smallint unsigned not null, --Home group, unless otherwise specified
	groupTwo smallint unsigned null,
	groupThree smallint unsigned null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID), 
	FOREIGN KEY (groupOne) REFERENCES ScanGroup(groupID), 
	FOREIGN KEY (groupTwo) REFERENCES ScanGroup(groupID), 
	FOREIGN KEY (groupThree) REFERENCES ScanGroup(groupID)

);

CREATE TABLE IF NOT EXISTS ScanUser(

	userID smallint unsigned not null AUTO_INCREMENT,
	userName varchar(30) not null,
	userPassword binary(20) not null,
	userRole character not null, --guest by default
	email varchar(50) null,
	title character null,
	PRIMARY KEY (userID)

);

CREATE TABLE IF NOT EXISTS Task(

	seriesID smallint unsigned not null,
	chapterNumber tinyint unsigned not null,
	userID smallint unsigned not null,
	description varchar(100) null,
	status character null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, userID),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID),
	FOREIGN KEY (chapterNumber) REFERENCES Chapter(chapterNumber),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID),
	

);

CREATE TABLE IF NOT EXISTS Config(

	founderID smallint unsigned not null,
	webmasterID smallint unsigned not null,
	homeGroupID smallint unsigned not null,
	PRIMARY KEY (founderID, webmasterID, homeGroupID),
	FOREIGN KEY (founderID) REFERENCES ScanUser(userID),
	FOREIGN KEY (webmasterID) REFERENCES ScanUser(userID),
	FOREIGN KEY (homeGroupID) REFERENCES ScanGroup(groupID)

);

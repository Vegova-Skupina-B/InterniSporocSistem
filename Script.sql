/*
Created		17.3.2015
Modified		17.3.2015
Project		
Model		
Company		
Author		
Version		
Database		mySQL 4.1 
*/








drop table IF EXISTS JeClan;
drop table IF EXISTS Skupina;
drop table IF EXISTS Sporocilo;
drop table IF EXISTS Uporabink;




Create table Uporabnik (
	UpID Int NOT NULL AUTO_INCREMENT,
	UpIme Varchar(20) NOT NULL,
	Geslo Varchar(20) NOT NULL,
	Email Varchar(30) NOT NULL,
	DatumReg Datetime NOT NULL,
	UNIQUE (UpID),
	UNIQUE (UpIme),
	UNIQUE (Geslo),
	UNIQUE (Email),
 Primary Key (UpID)) ENGINE = InnoDB;

Create table Sporocilo (
	SpID Int NOT NULL AUTO_INCREMENT,
	UpID Int NOT NULL,
	Naslovnik Varchar(20) NOT NULL,
	Zadeva Varchar(20) NOT NULL,
	Besedilo Varchar(300) NOT NULL,
	Posiljatelj Varchar(20),
	Up1Prebral Bool NOT NULL,
	Up2Prebral Bool NOT NULL,
	CasPoslano Datetime NOT NULL,
	UNIQUE (SpID),
 Primary Key (SpID,UpID)) ENGINE = InnoDB;

Create table Skupina (
	SkID Int NOT NULL AUTO_INCREMENT,
	ImeSk Varchar(20) NOT NULL,
	Vodja Varchar(20) NOT NULL,
	UNIQUE (SkID),
 Primary Key (SkID)) ENGINE = InnoDB;

Create table JeClan (
	UpID Int NOT NULL,
	SkID Int NOT NULL,
 Primary Key (UpID,SkID)) ENGINE = InnoDB;












Alter table Sporocilo add Foreign Key (UpID) references Uporabnik (UpID) on delete  cascade on update  cascade;
Alter table JeClan add Foreign Key (UpID) references Uporabnik (UpID) on delete  cascade on update  cascade;
Alter table JeClan add Foreign Key (SkID) references Skupina (SkID) on delete  cascade on update  cascade;



/* Users permissions */





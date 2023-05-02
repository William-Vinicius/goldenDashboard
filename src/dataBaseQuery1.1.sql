CREATE DATABASE dbDashBoar;
USE dbDashBoar;

CREATE TABLE tbUser(
    idUser INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nameUser VARCHAR(32) NOT NULL,
    loginUser VARCHAR(32) NOT NULL UNIQUE,
    passwordUser VARCHAR(60) NOT NULL,
    emailUser VARCHAR(32),
    phoneUser VARCHAR(15),
    idAccess INT, #tbAccess
    RecoveryCode VARCHAR(60)
);

CREATE TABLE tbAccess(
	idAccess INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nmAccess VARCHAR(32) NOT NULL
);

CREATE TABLE tbAcessConfig(
    idAcessConfig INT PRIMARY KEY,
    param TINYINT(1),
    idPage INT, #tbPage
    idAccesso INT #tbAccess

);

 CREATE TABLE tbPage(
	idPage INT PRIMARY KEY,
    nmPage INT NOT NULL,
    subPage TINYINT(1) NOT NULL
);
 
 CREATE TABLE tbGoal(
	idGoal INT NOT NULL AUTO_INCREMENT,
    nameGoal VARCHAR(32) NOT NULL,
    descGoal VARCHAR(100),
    target TINYINT(3) NOT NULL,
    valueGoal DECIMAL(9,2) NOT NULL,
    typeGoal BOOL NOT NULL,
    startDatetGoal DATE NOT NULL,
    endDateGoal DATE NOT NULL
);

CREATE TABLE Rewards(
    idReward INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nameReward VARCHAR(32) NOT NULL,
    descReward VARCHAR(100),
    dateCreationReward DATE,
    idGoal INT #tbGoal
);

CREATE TABLE tbComissions(
    idComission INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ValueComission DECIMAL(2,2),
    minNgr DECIMAL(9,2),
    minUser INT,
    idAfiliate INT #tbAfiliate
);

CREATE TABLE tbAfiliate (
	idAfiliate INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idSysAfiliate INT UNIQUE
);

CREATE TABLE tbSubAfiliate (
	idSubAfiliate INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idAfiliate INT, #tbAfiliate
    idAfManager INT, #tbAfManager
    valueComission DECIMAL(3,2)
);

CREATE TABLE tbAfManger (
	idAdManager INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idSysAfManager INT UNIQUE
);
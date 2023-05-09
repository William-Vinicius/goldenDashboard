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

CREATE TABLE tbAccessConfig(
    idAccessConfig INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    param TINYINT(1),
    idPage INT, #tbPage
    idAccess INT #tbAccess

);

 CREATE TABLE tbPage(
	idPage INT PRIMARY KEY,
    nmPage INT NOT NULL,
    subPage TINYINT(1) NOT NULL
);
 
 
 CREATE TABLE tbGoal(
	idGoal INT AUTO_INCREMENT NOT NULL PRIMARY KEY ,
    nameGoal VARCHAR(32) NOT NULL,
    descGoal VARCHAR(100),
    target TINYINT(3) NOT NULL,
    valueGoal DECIMAL(9,2) NOT NULL,
    typeGoal BOOL NOT NULL,
    startDatetGoal DATE NOT NULL,
    endDateGoal DATE NOT NULL
);

CREATE TABLE tbRewards(
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

CREATE TABLE tbAfManager (
	idAfManager INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idSysAfManager INT UNIQUE
);

/*Chaves Estrangeiras*/
/*Comissões para afiliados e gerentes*/

ALTER TABLE tbComissions
ADD FOREIGN KEY (idAfiliate) REFERENCES tbAfiliate(idAfiliate); 

ALTER TABLE tbSubAfiliate
ADD FOREIGN KEY (idAfiliate) REFERENCES tbAfiliate(idAfiliate);

ALTER TABLE tbSubAfiliate
ADD FOREIGN KEY (idAfManager) REFERENCES tbAfManager(idAfManager);

/* Premiações pra metas*/

ALTER TABLE tbRewards
ADD FOREIGN KEY(idGoal) REFERENCES tbGoal(idGoal);

/* Permissões para usuários */

ALTER TABLE tbUser
ADD FOREIGN KEY(idAccess) REFERENCES tbAccess(idAccess);

ALTER TABLE tbAccessConfig
ADD FOREIGN KEY(idAccess) REFERENCES tbAccess(idAccess);

ALTER TABLE tbAccessConfig
ADD FOREIGN KEY(idPage) REFERENCES tbPage(idPage);

/* Views */
/*Retorna ID do afiliado no sistema e sua comissão*/

SELECT (tbAfiliate.idAfiliate,tbAfiliate.idSysAfiliate, tbComissions.ValueComission)
FROM tbAfiliate
INNER JOIN tbComissions ON tbAfiliate.idAfiliate = tbComissions.idAfiliate;

/*Retorna ID do gerente no sistema, seu afiliado e sua comissão*/

SELECT (tbAfManger.idAfManger, tbAfManger.idSysAfManger, tbSubAfiliate.valueComission, tbAfiliate.idSysAfiliate)
FROM ((tbSubAfiliate
INNER JOIN tbAfManger ON tbSubAfiliate.idAfManger = tbAfManger.idAfManger)
INNER JOIN tbAfiliate ON tbSubAfiliate.idAfiliate = tbAfiliate.idAfiliate);


drop database dbdashboar;

/* Stored Procedures */
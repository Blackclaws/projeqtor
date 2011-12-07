
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.0.0                                      //
-- // Date : 2011-04-04                                     //
-- ///////////////////////////////////////////////////////////
--
--
CREATE TABLE `${prefix}activityprice` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idActivityType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `priceCost` decimal(10,2) DEFAULT '0',
  `subcontractor` int(1) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) DEFAULT '0',
  `subcontractorCost` decimal(10,2) DEFAULT NULL,
  `idTeam` int(12) unsigned DEFAULT NULL,
  `commissionCost` decimal(10,2) DEFAULT NULL,
  `isRef` int(1) NOT NULL DEFAULT '0',
  `pct` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}activityprice` ADD INDEX activitypriceProject (idProject),
 ADD INDEX activitypriceActivityType (idActivityType),
 ADD INDEX activitypriceTeam (idTeam);

CREATE TABLE `${prefix}bill` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idBillType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `idRecipient` int(12) unsigned DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `billId` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}bill` ADD INDEX billBillType (idBillType),
 ADD INDEX billProject (idProject),
 ADD INDEX billClient (idClient),
 ADD INDEX billRecipient (idRecipient),
 ADD INDEX billStatus (idStatus),
 ADD INDEX billResource (idResource);
 
ALTER TABLE `${prefix}client` ADD COLUMN `paymentDelay` int(3) NULL after `clientCode`, 
 ADD COLUMN `tax` decimal(5,2) DEFAULT NULL after `paymentDelay`;
	
CREATE TABLE `${prefix}line` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `line` int(3) unsigned DEFAULT NULL,
  `quantity` decimal(5,2) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sum` decimal(10,2) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `refType` varchar(100) NOT NULL,
  `idTerm` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
	`idActivity` int(12) unsigned DEFAULT NULL,
	`startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}line` ADD INDEX lineReference (refType, refId),
ADD INDEX lineResource (idResource),
ADD INDEX lineActivitye (idActivity);

ALTER TABLE `${prefix}project` ADD COLUMN `idRecipient` int(12) unsigned   NULL after `idClient`, 
	ADD COLUMN `paymentDelay` int(3) NULL after `doneDate`,
	ADD COLUMN `longitude` float(15,12) NULL after `paymentDelay`,
	ADD COLUMN `latitude` float(15,12) NULL after `longitude`;

ALTER TABLE `${prefix}project` ADD INDEX projectRecipient(idRecipient);

CREATE TABLE `${prefix}recipient` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `companyNumber` varchar(14) DEFAULT NULL,
  `numTax` varchar(100) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `numBank` varchar(5) DEFAULT NULL,
	`numOffice` varchar(5) DEFAULT NULL,
	`numAccount` varchar(11) DEFAULT NULL,
	`numKey` varchar(2) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `${prefix}term` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  `isBilled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}term` ADD INDEX termProject (idProject);

ALTER TABLE `${prefix}user` ADD COLUMN `designation` varchar(50) after `isContact`, 
	ADD COLUMN `street` varchar(50) after `designation`, 
	ADD COLUMN `complement` varchar(50) after `street`, 
	ADD COLUMN `zip` varchar(50) after `complement`, 
	ADD COLUMN `city` varchar(50) after `zip`, 
	ADD COLUMN `state` varchar(50) after `city`, 
	ADD COLUMN `country` varchar(50) after `state`, 
	ADD COLUMN `idRecipient` int(12)  unsigned NULL after `idRole`;

ALTER TABLE `${prefix}user` ADD INDEX userRecipient (idRecipient);

ALTER TABLE `${prefix}work` ADD COLUMN `isBilled` int(12) unsigned NOT NULL DEFAULT '0' after `cost`;

ALTER TABLE `${prefix}planningelement` ADD COLUMN `isBilled` int(12) unsigned NOT NULL DEFAULT '0' after `plannedCost`;

ALTER TABLE `${prefix}assignment` ADD COLUMN `billedWork` decimal(10,2) NOT NULL DEFAULT '0' after `plannedCost`;

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
	(94,'menuActivityPrice',74,'object',280,NULL,0),
	(95,'menuRecipient',14,'object',635,NULL,0),
	(96,'menuTerm',74,'object',262,NULL,0),
	(97,'menuBill',74,'object',267,NULL,0),
	(100,'menuBillType',79,'object',865,NULL,1);
	
UPDATE `${prefix}menu` SET `sortOrder`=10 WHERE `id`=1;

UPDATE `${prefix}menu` SET `idMenu`=0, `sortOrder`=90 WHERE `id`=16;
	
UPDATE `${prefix}menu` SET `idMenu`=2, `sortOrder`=160 WHERE `id`=4;
	
UPDATE `${prefix}menu` SET `idMenu`=0,  `sortOrder`=600 WHERE `id`=14;
	
UPDATE `${prefix}menu` SET `idMenu`=79, `sortOrder`=688 WHERE `id`=13;

UPDATE `${prefix}menu` SET `sortOrder`=610 WHERE `id`=50;

UPDATE `${prefix}menu` SET `sortOrder`=615 WHERE `id`=17;

UPDATE `${prefix}menu` SET `sortOrder`=620 WHERE `id`=44;

UPDATE `${prefix}menu` SET `sortOrder`=630 WHERE `id`=72;

UPDATE `${prefix}menu` SET `sortOrder`=635 WHERE `id`=15;

UPDATE `${prefix}menu` SET `sortOrder`=640 WHERE `id`=95;

UPDATE `${prefix}menu` SET `sortOrder`=645 WHERE `id`=57;

UPDATE `${prefix}menu` SET `sortOrder`=650 WHERE `id`=86;

UPDATE `${prefix}menu` SET `sortOrder`=655 WHERE `id`=87;

INSERT INTO `${prefix}accessright` (idProfile,idMenu,idAccessProfile) VALUES 
(1,94,8),
(1,95,8),
(1,96,8),
(1,97,8),
(1,98,8),
(1,99,8),
(1,100,8);	

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 94, 1),
(1, 95, 1),
(1, 96, 1),
(1, 97, 1),
(1, 98, 1),
(1, 99, 1),
(1, 100, 1);


INSERT INTO `${prefix}reportcategory` (`id`, `name`, `order`, `idle`) VALUES 
(7,'reportCategoryFacture',60,0);
	
INSERT INTO `${prefix}report`(`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) 
VALUES (37,'reportFactureProject',7,'facture.php',1,0);

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `idle`, `defaultValue`) VALUES
(86,37,'idBill','billList',10,0,NULL),
(87,37,'idProject','projectList',20,0,'currentProject'),
(88,37,'idClient','clientList',30,0,NULL);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES
(1,37,1),
(2,37,0),
(3,37,0),
(4,37,0),
(5,37,0),
(6,37,0),
(7,37,0);

-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.2.0                                       //
-- // Date : 2018-06-18                                     //
-- ///////////////////////////////////////////////////////////

-- ==================================================================
-- Financial evolutions
-- ==================================================================

CREATE TABLE `${prefix}providerOrder` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` VARCHAR(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `idProviderOrderType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `additionalInfo` mediumtext DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL,
  `evaluationValue` decimal(7,2) DEFAULT NULL,
  `evaluationRank` int(3) DEFAULT NULL,
  `totalUntaxedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `totalTaxAmount` decimal(11,2) UNSIGNED,
  `totalFullAmount` decimal(11,2) UNSIGNED,
  `untaxedAmount` decimal(11,2) UNSIGNED,
  `taxAmount` decimal(11,2) UNSIGNED,
  `fullAmount` decimal(11,2) UNSIGNED,
  `discountAmount` DECIMAL(11,2),
  `discountRate`   DECIMAL(5,2),
  `deliveryDelay` varchar(100) DEFAULT NULL,
  `deliveryExpectedDate` date DEFAULT NULL,
  `deliveryDoneDate` date DEFAULT NULL,
  `deliveryValitedDate` date DEFAULT NULL,
  `paymentCondition` varchar(100) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX providerOrderProject ON `${prefix}providerOrder` (idProject);
CREATE INDEX providerOrderUser ON `${prefix}providerOrder` (idUser);
CREATE INDEX providerOrderResource ON `${prefix}providerOrder` (idResource);
CREATE INDEX providerOrderStatus ON `${prefix}providerOrder` (idStatus);
CREATE INDEX providerOrderType ON `${prefix}providerOrder` (idProviderOrderType);

CREATE TABLE `${prefix}providerBill` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` VARCHAR(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `idProviderBillType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `additionalInfo` mediumtext DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL,
  `evaluationValue` decimal(7,2) DEFAULT NULL,
  `evaluationRank` int(3) DEFAULT NULL,
  `totalUntaxedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `totalTaxAmount` decimal(11,2) UNSIGNED,
  `totalFullAmount` decimal(11,2) UNSIGNED,
  `untaxedAmount` decimal(11,2) UNSIGNED,
  `taxAmount` decimal(11,2) UNSIGNED,
  `fullAmount` decimal(11,2) UNSIGNED,
  `discountAmount` DECIMAL(11,2),
  `discountRate`   DECIMAL(5,2),
  `lastPaymentDate` date DEFAULT NULL,
  `expectedPaymentDate` date DEFAULT NULL,
  `paymentAmount` DECIMAL(11,2),
  `paymentCondition` varchar(100) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}providerTerm` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  `idProviderOrder` int(12) unsigned DEFAULT NULL,
  `idProviderBill` int(12) unsigned DEFAULT NULL,
  `untaxedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `taxAmount` decimal(11,2) UNSIGNED,
  `fullAmount` decimal(11,2) UNSIGNED,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX providerTermProject ON `${prefix}providerTerm` (idProject);
CREATE INDEX providerTermOrder ON `${prefix}providerTerm` (idProviderOrder);
CREATE INDEX providerTermBill ON `${prefix}providerTerm` (idProviderBill);

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(190,'menuProviderOrderType', 79, 'object', 826, 'Project', 0, 'Type '),
(191,'menuProviderOrder', 151, 'object', 207, 'Project', 0, 'Financial '),
(193,'menuProviderBillType', 79, 'object', 826, 'Project', 0, 'Type '),
(194,'menuProviderBill', 151, 'object', 209, 'Project', 0, 'Financial '),
(195,'menuProviderTerm', 151, 'object', 208, 'Project', 0, 'Financial ');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 190, 1),
(1, 191, 1),
(1, 193, 1),
(1, 194, 1),
(1, 195, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,190,8),
(1,191,8),
(1,193,8),
(1,194,8),
(1,195,8);

ALTER TABLE `${prefix}tender`
CHANGE `initialAmount` `untaxedAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `initialTaxAmount` `taxAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `initialFullAmount` `fullAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `plannedAmount` `totalUntaxedAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `plannedTaxAmount` `totalTaxAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `plannedFullAmount` `totalFullAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
ADD `discountAmount` DECIMAL(11,2),
ADD `discountRate`   DECIMAL(5,2);

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `color`, idWorkflow) VALUES
('ProviderOrder', 'Product', 10, 0, NULL, 1),
('ProviderOrder', 'Service', 20, 0, NULL, 1);

INSERT INTO `${prefix}copyable` (`id`,`name`, `idle`, `sortOrder`,`idDefaultCopyable`) VALUES 
(23,'ProviderOrder', '0', '121','24'),
(24,'ProviderBill', '0', '122',NULL);
UPDATE `${prefix}copyable` SET idDefaultCopyable=23 WHERE id=16;

-- ==================================================================
-- Global views
-- ==================================================================

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(192,'menuGlobalView', 2, 'object', 95, 'Project', 0, 'Work');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,192,1),
(2,192,1),
(3,192,1),
(4,192,1);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES 
(1,192, 8),
(2,192, 2),
(3,192, 7),
(4,192, 7);

-- Table Global View : created only to get correct formatting for fields on list : this table will always be empty
CREATE TABLE `${prefix}globalview` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `objectClass` VARCHAR(100) DEFAULT NULL,
  `objectId` int(12) unsigned,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idType` int(12) unsigned DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  `validatedEndDate` date DEFAULT NULL,
  `plannedEndDate`  date DEFAULT NULL,
  `realEndDate`  date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

UPDATE `${prefix}menu`set menuClass=REPLACE(menuClass,'Meeting','Review') WHERE menuClass LIKE '%Meeting%';

ALTER TABLE `${prefix}activity`
ADD `idMilestone` int(12) UNSIGNED DEFAULT NULL;
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.1.0                                       //
-- // Date : 2018-04-23                                     //
-- ///////////////////////////////////////////////////////////

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
  `receptionDateTime` datetime DEFAULT NULL,
  `evaluationValue` decimal(7,2) DEFAULT NULL,
  `evaluationRank` int(3) DEFAULT NULL,
  `plannedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `plannedTaxAmount` decimal(11,2) UNSIGNED,
  `plannedFullAmount` decimal(11,2) UNSIGNED,
  `initialAmount` decimal(11,2) UNSIGNED,
  `initialTaxAmount` decimal(11,2) UNSIGNED,
  `initialFullAmount` decimal(11,2) UNSIGNED,
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

CREATE INDEX providerCommandProject ON `${prefix}providerCommand` (idProject);
CREATE INDEX providerCommandUser ON `${prefix}providerCommand` (idUser);
CREATE INDEX providerCommandResource ON `${prefix}providerCommand` (idResource);
CREATE INDEX providerCommandStatus ON `${prefix}providerCommand` (idStatus);
CREATE INDEX providerCommandType ON `${prefix}providerCommand` (idProviderOrderType);

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(190,'menuProviderOrderType', 79, 'object', 826, 'Project', 0, 'Type '),
(191,'menuProviderOrder', 151, 'object', 207, 'Project', 0, 'Financial ');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 190, 1),
(1, 191, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,190,8),
(1,191,8);
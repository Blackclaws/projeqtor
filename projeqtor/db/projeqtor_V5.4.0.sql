-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.4.0                                       //
-- // Date : 2016-05-12                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}assignment` CHANGE `dailyCost` `dailyCost` DECIMAL(9,2) UNSIGNED,
CHANGE `newDailyCost` `newDailyCost` DECIMAL(9,2) UNSIGNED;

ALTER TABLE `${prefix}billline` CHANGE `quantity` `quantity` DECIMAL(9,2) UNSIGNED;

ALTER TABLE `${prefix}expense` ADD `idDocument` int(12) unsigned;
ALTER TABLE `${prefix}filter` ADD `isShared` int(1) unsigned;

ALTER TABLE `${prefix}billline` CHANGE `quantity` `quantity` DECIMAL(9,2) UNSIGNED;

CREATE TABLE `${prefix}provider` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `idProviderType` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `providerCode` varchar(25) DEFAULT NULL,
  `idPaymentDelay` int(12) unsigned DEFAULT NULL,
  `numTax` varchar (100) DEFAULT NULL,
  `tax` decimal(5,2),
  `designation` varchar (100),
  `street`  varchar (100),
  `complement`  varchar (100),
  `zip`  varchar (100),
  `city`  varchar (100),
  `state`  varchar (100),
  `country`  varchar (100),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
CREATE INDEX providerProviderType ON `${prefix}provider` (idProviderType);

ALTER TABLE `${prefix}expense` ADD `idProvider` int(12) unsigned DEFAULT NULL,
ADD `sendDate` date DEFAULT NULL,
ADD `idDeliveryMode` int(12) unsigned DEFAULT NULL,
ADD `deliveryDelay` varchar(100) DEFAULT NULL,
ADD `deliveryDate` date DEFAULT NULL,
ADD `paymentCondition` varchar(100) DEFAULT NULL,
ADD `receptionDate` date DEFAULT NULL,
ADD `result` mediumtext DEFAULT NULL,
ADD `taxPct` decimal(5,2) DEFAULT NULL,
ADD `plannedFullAmount` decimal (11,2) DEFAULT 0,
ADD `realFullAmount` decimal (11,2) DEFAULT 0,
ADD `idleDate` date DEFAULT NULL,
ADD `handled` int(1) unsigned DEFAULT '0',
ADD `handledDate` date DEFAULT NULL,
ADD `done` int(1) unsigned DEFAULT '0',
ADD `doneDate` date DEFAULT NULL,
ADD `idResponsible` int(12) unsigned DEFAULT NULL;
CREATE INDEX expenseProvider ON `${prefix}expense` (idProvider);
CREATE INDEX expenseResponsible ON `${prefix}expense` (idResponsible);

UPDATE `${prefix}expense` SET `plannedFullAmount`=`plannedAmount`,
`realFullAmount`=`realAmount`
WHERE `scope`='ProjectExpense';

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(147, 'menuProviderType', 79, 'object', 927, 'ReadWriteType', 0, 'Type '),
(148, 'menuProvider', 14, 'object', 525, 'ReadWriteEnvironment', 0, 'Financial EnvironmentalParameter ');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 147, 1),
(2, 147, 0),
(3, 147, 0),
(4, 147, 0),
(5, 147, 0),
(6, 147, 0),
(7, 147, 0),
(1, 148, 1),
(2, 148, 0),
(3, 148, 0),
(4, 148, 0),
(5, 148, 0),
(6, 148, 0),
(7, 148, 0);
INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `idWorkflow`, `mandatoryDescription`, `mandatoryResultOnDone`, `mandatoryResourceOnHandled`, `lockHandled`, `lockDone`, `lockIdle`, `code`) VALUES 
('Provider', 'wholesaler', '10', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Provider', 'retailer', '20', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Provider', 'service provider', '30', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Provider', 'subcontractor', '40', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Provider', 'central purchasing', '50', '0', '1', '0', '0', '0', '0', '0', '0', '');
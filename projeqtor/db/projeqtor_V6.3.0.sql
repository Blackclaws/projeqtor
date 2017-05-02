-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.3.0                                       //
-- // Date : 2017-04-21                                     //
-- ///////////////////////////////////////////////////////////

INSERT INTO `${prefix}copyable` (`id`,`name`, `idle`, `sortOrder`) VALUES 
(17,'TestCase', '0', '900'),
(18,'TestSession', '0', '910');

ALTER TABLE `${prefix}testcaserun` ADD `result` varchar(4000) DEFAULT NULL;

CREATE TABLE `${prefix}delivery` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idDeliverableType` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `plannedDate` date DEFAULT NULL,
  `realDate` date DEFAULT NULL,
  `validationDate` date DEFAULT NULL,
  `impactWork` decimal(5) DEFAULT NULL,
  `impactDuration` int(5) DEFAULT NULL,
  `impactCost` decimal(9) DEFAULT null,
  `idDeliverableWeight` int(12) unsigned DEFAULT NULL,
  `idDeliverableStatus` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `deliverableType` ON `${prefix}delivery` (`idDeliverableType`);
CREATE INDEX `deliverableStatusIdx` ON `${prefix}delivery` (`idDeliverableStatus`);
CREATE INDEX `deliverableProject` ON `${prefix}delivery` (`idProject`);

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(176,'menuDelivery', 6, 'object', 375, 'Project', 0, 'Work Meeting');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1, 176, 1),
(2, 176, 1),
(3, 176, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES 
(1,176,8),
(2,176,2),
(3,176,7);
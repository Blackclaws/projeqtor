
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.5.0                                      //
-- // Date : 2013-09-02                                     //
-- ///////////////////////////////////////////////////////////
--
--

CREATE TABLE `${prefix}command` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idCommandType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `additionalInfo` varchar(4000) DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `idActivity` int(12) unsigned DEFAULT NULL,
  `initialStartDate` date DEFAULT NULL,
  `initialEndDate` date DEFAULT NULL,
  `validatedEndDate` date DEFAULT NULL,
  `initialWork` decimal(12,2) DEFAULT '0.00',
  `initialPricePerDayAmount` decimal(12,2) DEFAULT '0.00',
  `initialAmount` decimal(12,2) DEFAULT '0.00',
  `addWork` decimal(12,2) DEFAULT '0.00',
  `addPricePerDayAmount` decimal(12,2) DEFAULT '0.00',
  `addAmount` decimal(12,2) DEFAULT '0.00',
  `validatedWork` decimal(12,2) DEFAULT '0.00',
  `validatedPricePerDayAmount` decimal(12,2) DEFAULT '0.00',
  `validatedAmount` decimal(12,2) DEFAULT '0.00',
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX commandProject ON `${prefix}command` (idProject);
CREATE INDEX commandUser ON `${prefix}command` (idUser);
CREATE INDEX commandResource ON `${prefix}command` (idResource);
CREATE INDEX commandStatus ON `${prefix}command` (idStatus);
CREATE INDEX commandType ON `${prefix}command` (idCommandType);

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `idWorkflow`, `mandatoryDescription`, `mandatoryResultOnDone`, `mandatoryResourceOnHandled`, `lockHandled`, `lockDone`, `lockIdle`, `code`) VALUES 
('Command', 'Fixe Price', '10', '0', '1', '0', '0', '0', '0', '1', '1', '');
INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `idWorkflow`, `mandatoryDescription`, `mandatoryResultOnDone`, `mandatoryResourceOnHandled`, `lockHandled`, `lockDone`, `lockIdle`, `code`) VALUES 
('Command', 'Per day', '20', '0', '1', '0', '0', '0', '0', '1', '1', '');

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES 
(125,'menuCommand', '74', 'object', '352', 'Project', 0);
INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `idle`) VALUES 
(126, 'menuCommandType', '79', 'object', '835', 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 125, 1),
(2, 125, 1),
(3, 125, 1),
(4, 125, 0),
(5, 125, 0),
(6, 125, 0),
(7, 125, 0);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 126, 1),
(2, 126, 0),
(3, 126, 0),
(4, 126, 0),
(5, 126, 0),
(6, 126, 0),
(7, 126, 0);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 125, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=97;  

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 126, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=100;  

INSERT INTO `${prefix}originable` (`id`,`name`, `idle`) VALUES (17,'Command', 0);
INSERT INTO `${prefix}mailable` (`id`,`name`, `idle`) VALUES (21,'Command', '0');
INSERT INTO `${prefix}linkable` (`id`,`name`, `idle`, `idDefaultLinkable`) VALUES (18,'Command', 0, 14);
INSERT INTO `${prefix}referencable` (`id`,`name`, `idle`) VALUES (16,'Command', 0);
INSERT INTO `${prefix}indicatorable` (`id`,`name`, `idle`) VALUES (10,'Command', '0');
INSERT INTO `${prefix}importable` (`id`,`name`, `idle`) VALUES (27,'Command', '0');
INSERT INTO `${prefix}copyable` (`id`,`name`, `idle`, `sortOrder`) VALUES (13,'Command', '0', '36');

INSERT INTO `${prefix}indicatorableindicator` (`idIndicatorable`, `nameIndicatorable`, `idIndicator`, `idle`) VALUES 
('10', 'Command', '8', '0');
INSERT INTO `${prefix}indicatorableindicator` (`idIndicatorable`, `nameIndicatorable`, `idIndicator`, `idle`) VALUES 
('10', 'Command', '5', '0');
INSERT INTO `${prefix}indicatorableindicator` (`idIndicatorable`, `nameIndicatorable`, `idIndicator`, `idle`) VALUES 
('10', 'Command', '6', '0');

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) VALUES 
(50, 'reportProject', '9', 'projectDashboard.php', '920', '0');

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`) VALUES
(50, 'idProject', 'projectList', 10, 0, 'currentProject');

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,50,1),
(2,50,1),
(3,50,1);

ALTER TABLE `${prefix}project` ADD COLUMN `cancelled` int(1) unsigned DEFAULT '0';

ALTER TABLE `${prefix}status` ADD COLUMN `setCancelledStatus` int(1) unsigned DEFAULT '0';

UPDATE `${prefix}status` SET setCancelledStatus=1 WHERE id=9;
UPDATE `${prefix}project` SET cancelled=1 WHERE idStatus=9;

INSERT INTO `${prefix}planningmode` (`id`, `applyTo`, `name`, `code`, `sortOrder`, `idle`, `mandatoryStartDate`, `mandatoryEndDate`) VALUES
(17, 'Activity', 'PlanningModeGROUP', 'GROUP', 150, 0 , 0, 0);
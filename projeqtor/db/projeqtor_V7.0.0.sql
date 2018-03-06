-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.0.0                                       //
-- // Date : 2017-12-22                                     //
-- ///////////////////////////////////////////////////////////

-- ======================================================== --
-- Mail Grouping                                            --
-- ======================================================== --

INSERT INTO `${prefix}parameter` (`idUser`,`idProject`,`parameterCode`,`parameterValue`) VALUES 
(NULL,NULL,'mailGroupPeriod','60'),
(NULL,NULL,'mailGroupActive','NO'),
(NULL,NULL,'mailGroupDifferent','ALL');

CREATE TABLE `${prefix}mailtosend` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser`  int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `idEmailTemplate` int(12) unsigned DEFAULT NULL,
  `template` varchar(100) DEFAULT NULL,
  `title` varchar(4000) DEFAULT NULL,
  `dest` varchar(4000) DEFAULT NULL,
  `recordDateTime` datetime DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE INDEX `mailtosendReference` ON `${prefix}mailtosend` (`refType`,`refId`);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`, `sortOrder`,`level`,`idle`,`menuClass`) VALUES
(187, 'menuMailToSend',11,'object',402,'', 0,'Admin');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) VALUES
( 1, 187, 1);

-- ======================================================== --
-- Critical Path                                            --
-- ======================================================== --

ALTER TABLE `${prefix}planningelement`
ADD `latestStartDate` date DEFAULT NULL,
ADD `latestEndDate` date DEFAULT NULL,
ADD `isOnCriticalPath` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}planningelementbaseline`
ADD `latestStartDate` date DEFAULT NULL,
ADD `latestEndDate` date DEFAULT NULL,
ADD `isOnCriticalPath` int(1) UNSIGNED DEFAULT 0;

-- ======================================================== --
-- Automatic Planning                                       --
-- ======================================================== --
INSERT INTO `${prefix}cronexecution` (`cron`, `fileExecuted`, `idle`, `fonctionName`, `nextTime`) VALUES 
('0 * * * *', '../tool/cronExecutionStandard.php', '1', 'cronPlanningDifferential', NULL),
('0 2 * * *', '../tool/cronExecutionStandard.php', '1', 'cronPlanningComplete', NULL);
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.1.0                                       //
-- // Date : 2016-12-08                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}assignment` ADD `isNotImputable` int(1) unsigned default '0';

-- ===================================
-- PAPJUL ADDITION FOR REPORTS (START)

ALTER TABLE `${prefix}reportparameter` ADD COLUMN `multiple` int(1) unsigned DEFAULT '0';

ALTER TABLE `${prefix}report` ADD COLUMN `hasCsv` int(1) unsigned DEFAULT '0';

UPDATE `${prefix}report` SET hasCsv = 1 WHERE `id` = 49;

-- PAPJUL ADDITION FOR REPORTS (END)
-- =================================

-- ================================
-- PAPJUL ADDITION FOR JOBS (START)

CREATE TABLE `${prefix}job` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idJoblistDefinition` int(12) unsigned DEFAULT NULL,
  `idJobDefinition` int(12) unsigned DEFAULT NULL,
  `value` int(1) unsigned DEFAULT '0',
  `idUser` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `checkTime` datetime DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `jobJobDefinition` ON `${prefix}job` (`idJobDefinition`);
CREATE INDEX `jobJoblistDefinition` ON `${prefix}job` (`idJoblistDefinition`);
CREATE INDEX `jobReference` ON `${prefix}job` (`refType`,`refId`);

CREATE TABLE `${prefix}jobdefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idJoblistDefinition` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT '0',
  `daysBeforeWarning` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `jobdefinitionJoblistDefinition` ON `${prefix}jobdefinition` (`idJoblistDefinition`);

CREATE TABLE `${prefix}joblistdefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idChecklistable` int(12) unsigned DEFAULT NULL,
  `nameChecklistable` varchar(100) DEFAULT NULL,
  `idType` int(12) unsigned DEFAULT NULL,
  `lineCount` int(3) DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `joblistdefinitionChecklistable` ON `${prefix}joblistdefinition` (`idChecklistable`);
CREATE INDEX `joblistdefinitionNameChecklistable` ON `${prefix}joblistdefinition` (`nameChecklistable`);
CREATE INDEX `joblistdefinitionType` ON `${prefix}joblistdefinition` (`idType`);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES 
(162, 'menuJoblistDefinition', 88, 'object', 640, 'ReadWriteEnvironment', 0, 'Automation ');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,162,1);

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `hasCsv`, `sortOrder`, `idle`, `orientation`) VALUES 
(63, 'reportMacroJoblist', 1, 'joblist.php', 1, 99, 0, 'L');
INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`, `multiple`) VALUES 
(913, 63, 'idActivity', 'activityList', 20, 0, NULL, 0),
(912, 63, 'idProject', 'projectList', 10, 0, 'currentProject', 0);

-- PAPJUL ADDITION FOR JOBS (END)
-- ==============================

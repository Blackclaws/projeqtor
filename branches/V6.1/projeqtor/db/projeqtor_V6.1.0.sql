-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.1.0                                       //
-- // Date : 2016-12-08                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}assignment` ADD `isNotImputable` int(1) unsigned default '0';

UPDATE `${prefix}menu` SET name='menuIncomes' WHERE name='menuIncomings';

-- ===================================
-- PAPJUL ADDITION FOR REPORTS (START)

ALTER TABLE `${prefix}reportparameter` ADD COLUMN `multiple` int(1) unsigned DEFAULT '0';

ALTER TABLE `${prefix}report` ADD COLUMN `hasCsv` int(1) unsigned DEFAULT '0';

UPDATE `${prefix}report` SET hasCsv = 1 WHERE `id` = 49;
UPDATE `${prefix}report` SET hasCsv = 1 WHERE `id` = 7;

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
INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,63,1),
(2,63,1),
(3,63,1);

-- PAPJUL ADDITION FOR JOBS (END)
-- ==============================

CREATE TABLE `${prefix}kpidefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `kpidefinitionCode` ON `${prefix}kpidefinition` (`code`);
INSERT INTO `${prefix}kpidefinition` (`id`, `name`, `code`, `idle`) VALUES 
(1, 'project duration KPI', 'duration', 0),
(2, 'project workload KPI', 'workload', 0),
(3, 'project terms KPI', 'term', 0),
(4, 'project deliverables quality KPI', 'deliverable', 0),
(5, 'project incomings quality KPI', 'incoming', 0);  

CREATE TABLE `${prefix}kpithreshold` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idKpiDefinition` int(12) unsigned DEFAULT NULL,
  `thresholdValue` decimal(5,2) DEFAULT NULL,
  `thresholdColor` varchar(7) DEFAULT '#FFFFFF',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `kpithresholdKpiDefinition` ON `${prefix}kpithreshold` (`idKpiDefinition`);
INSERT INTO `${prefix}kpiThreshold` (`id`, `name`, `idKpiDefinition`, `thresholdValue`, `thresholdColor`) VALUES 
(1, 'good', 1, 0, '#98fb98'),
(2, 'acceptable', 1, 1.2, '#f4a460'),
(3, 'not acceptable', 1, 1.5, '#f08080'),
(4, 'good', 2, 0, '#98fb98'),
(5, 'acceptable', 2, 1.2, '#f4a460'),
(6, 'not acceptable', 2, 1.5, '#f08080'),
(7, 'sufficient', 3, 0.0, '#98fb98'),
(8, 'partially sufficient', 3, 0.4, '#f4a460'),
(9, 'not sufficient', 3, 0.7, '#f08080'),
(10, 'not good', 4, 0, '#f08080'),
(11, 'good', 4, 0.66, '#98fb98'),
(12, 'not good', 5, 0, '#f08080'),
(13, 'good', 5, 0.66, '#98fb98');  

CREATE TABLE `${prefix}kpivalue` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idKpiDefinition` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `kpiType` varchar(1) DEFAULT NULL,
  `kpiDate` date DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `kpiValue` decimal(5,2) DEFAULT NULL,
  `weight` decimal(14,5) DEFAULT NULL,
  `refDone` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `kpivalueKpiDefinition` ON `${prefix}kpivalue` (`idKpiDefinition`);
CREATE INDEX `kpivalueReference` ON `${prefix}kpivalue` (`refType`, `refId`);

CREATE TABLE `${prefix}kpihistory` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idKpiDefinition` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `kpiType` varchar(1) DEFAULT NULL,
  `kpiDate` date DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `kpiValue` decimal(5,2) DEFAULT NULL,
  `weight` decimal(14,5) DEFAULT NULL,
  `refDone` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `kpihistoryKpiDefinition` ON `${prefix}kpihistory` (`idKpiDefinition`);
CREATE INDEX `kpihistoryReference` ON `${prefix}kpihistory` (`refType`, `refId`);
CREATE INDEX `kpihistoryDate` ON `${prefix}kpihistory` (`kpiDate`);

CREATE TABLE `${prefix}deliverable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idDeliverableType` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `externalReference` varchar(100),
  `plannedDate` date DEFAULT NULL,
  `realDate` date DEFAULT NULL,
  `idDeliverableWeight` int(12) unsigned DEFAULT NULL,
  `idDeliverableStatus` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `deliverableType` ON `${prefix}deliverable` (`idDeliverableType`);
CREATE INDEX `deliverableStatus` ON `${prefix}deliverable` (`idDeliverableStatus`);
CREATE INDEX `deliverableProject` ON `${prefix}deliverable` (`idProject`);

CREATE TABLE `${prefix}deliverableWeight` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) unsigned NOT NULL,
  `color` varchar(7) DEFAULT '#FFFFFF',
  `sortOrder` int(3) DEFAULT 0, 
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `${prefix}deliverableWeight` (`id`, `scope`, `name`, `value`, `sortOrder`, `color`, `idle`) VALUES 
(1, 'Deliverable', 'low', 0, 10, '#d3d3d3', '0'),
(2, 'Deliverable', 'medium', 0, 20, '#d3d3d3', '0'),
(3, 'Deliverable', 'high', 1, 30, '#ffc0cb', '0'),
(4, 'Incoming', 'low', 0, 10, '#d3d3d3', '0'),
(5, 'Incoming', 'medium', 0, 20, '#d3d3d3', '0'),
(6, 'Incoming', 'high', 1, 30, '#ffc0cb', '0');

CREATE TABLE `${prefix}deliverableStatus` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` int(3) DEFAULT 0,
  `color` varchar(7) DEFAULT '#FFFFFF',
  `sortOrder` int(3) DEFAULT 0, 
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `${prefix}deliverableStatus` (`id`, `scope`, `name`, `value`, `sortOrder`, `color`, `idle`) VALUES 
(1, 'Deliverable', 'not done', 0, 10, '#ff0000', '0'),
(2, 'Deliverable', 'delivery refused (major reservations)', 1, 20, '#ff8c00', '0'),
(3, 'Deliverable', 'accepted with minor reservations', 2, 30, '#afeeee', '0'),
(4, 'Deliverable', 'accepted without reservations', 3, 40, '#7fff00', '0'),
(5, 'Incoming', 'not provided', 0, 10, '#ff0000', '0'),
(6, 'Incoming', 'not conform', 1, 20, '#ff8c00', '0'),
(7, 'Incoming', 'accepted with minor reservations', 2, 30, '#afeeee', '0'),
(8, 'Incoming', 'accepted without reservations', 3, 40, '#7fff00', '0');

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `code`) VALUES 
('Deliverable', 'document', '10',0,'DOC'),
('Deliverable', 'software', '20',0,'SOFT'),
('Deliverable', 'hardware', '30',0,'HARD'),
('Incoming', 'document', '10',0,'DOC'),
('Incoming', 'software', '20',0,'SOFT'),
('Incoming', 'hardware', '30',0,'HARD');

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(163,'menuDeliverableWeight', 36, 'object', 792, 'ReadWriteList', 0, 'ListOfValues'),
(164,'menuDeliverableStatus', 36, 'object', 794, 'ReadWriteList', 0, 'ListOfValues'),
(165,'menuDeliverableType', 79, 'object', 938, 'ReadWriteType', 0, 'ListOfValues'),
(166,'menuIncomingType', 79, 'object', 936, 'ReadWriteType', 0, 'Type'),
(167,'menuDeliverable', 6, 'object', 374, 'Project', 0, 'Work Meeting'),
(168,'menuIncoming', 6, 'object', 372, 'Project', 0, 'Work Meeting'),
(169,'menuKpiDefinition', 88, 'object', 615, 'ReadWriteEnvironment', 0, 'Automation'),
(171,'menuIncomingWeight', 36, 'object', 791, 'ReadWriteList', 0, 'ListOfValues'),
(172,'menuIncomingStatus', 36, 'object', 793, 'ReadWriteList', 0, 'ListOfValues');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1, 163, 1),
(1, 164, 1),
(1, 165, 1),
(1, 166, 1),
(1, 167, 1),
(2, 167, 1),
(3, 167, 1),
(1, 168, 1),
(2, 168, 2),
(3, 168, 3),
(1, 169, 1),
(1, 171, 1),
(1, 172, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 167, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=16;
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 168, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=16;   

CREATE TABLE `${prefix}category` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(170,'menuCategory', 36, 'object', 791, 'ReadWriteType', 0, ' ListOfValues');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,170,1);
INSERT INTO `${prefix}category` (`id`, `name`, `idle`) VALUES 
(1, 'Build', 0),
(2, 'Run', 0);

ALTER TABLE `${prefix}project` ADD COLUMN `idCategory` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}type` ADD COLUMN `idCategory` int(12) unsigned DEFAULT NULL;

INSERT INTO `${prefix}linkable` (`id`,`name`, `idle`, `idDefaultLinkable`) VALUES (21,'Deliverable', 0, 9);
INSERT INTO `${prefix}linkable` (`id`,`name`, `idle`, `idDefaultLinkable`) VALUES (22,'Incoming', 0, 9);
UPDATE `${prefix}linkable` set `idDefaultLinkable`=21 WHERE id=9;

DELETE FROM `${prefix}type` where scope='Invoice';

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `orientation`) VALUES 
(64, 'reportKpiDurationProject', 10, 'kpiDuration.php?scope=Project', 970, 'P'),
(65, 'reportKpiDurationOrganization', 10, 'kpiDuration.php?scope=Organization', 975, 'P'),
(66, 'reportKpiWorkloadProject', 10, 'kpiWorkload.php?scope=Project', 830, 'P'),
(67, 'reportKpiWorkloadOrganization', 10, 'kpiWorkload.php?scope=Organization', 840, 'P');

--INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
--(64, 'idProject', 'projectList', 10, 'currentProject'),
--(64, 'month', 'month', 20, null),
--(64, 'format', 'periodScaleYear', 30, 'month'),
--(64, 'showThreshold', 'boolean', 40, true),
--(65, 'idOrganization', 'organizationList', 10, 'currentOrganization'),
--(65, 'idProjectType', 'projectTypeList', 20, null),
--(65, 'month', 'month', 30, 'currentYear'),
--(65, 'format', 'periodScaleYear', 40, 'month'),
--(65, 'showThreshold', 'boolean', 50, true),
--(65, 'onlyFinished', 'boolean', 60, true);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(64, 'idProject', 'projectList', 10, 'currentProject'),
(64, 'showThreshold', 'boolean', 20, true),
(65, 'idOrganization', 'organizationList', 10, 'currentOrganization'),
(65, 'idProjectType', 'projectTypeList', 20, null),
(65, 'month', 'month', 30, 'currentYear'),
(65, 'showThreshold', 'boolean', 40, true),
(65, 'onlyFinished', 'boolean', 50, true);
(66, 'idProject', 'projectList', 10, 'currentProject'),
(66, 'showThreshold', 'boolean', 20, true),
(67, 'idOrganization', 'organizationList', 10, 'currentOrganization'),
(67, 'idProjectType', 'projectTypeList', 20, null),
(67, 'idCategory', 'categoryList', 30, null),
(67, 'month', 'month', 40, 'currentYear'),
(67, 'showThreshold', 'boolean', 50, true),
(67, 'onlyFinished', 'boolean', 60, true);


INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,64,1),
(2,64,1),
(3,64,1),
(1,65,1),
(2,65,1),
(1,66,1),
(2,66,1),
(3,66,1),
(1,67,1),
(2,67,1);

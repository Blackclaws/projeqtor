-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.6.0                        //
-- // Date : 2016-07-28                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}product` ADD `idUser` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}version` ADD `idUser` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}action` ADD `idContact` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}dependency` ADD `comment` varchar(4000)DEFAULT NULL;
ALTER TABLE `${prefix}testcaserun` ADD `sortOrder` int(3) DEFAULT 0;

UPDATE `${prefix}parameter` set parameterValue='ProjeQtOrFlatBlue' where parameterValue='ProjeQtOr' and (parameterCode='theme' or parameterCode='defaultTheme');
UPDATE `${prefix}parameter` set parameterValue='ProjeQtOrFlatRed' where parameterValue='ProjeQtOrFire' and (parameterCode='theme' or parameterCode='defaultTheme');
UPDATE `${prefix}parameter` set parameterValue='ProjeQtOrFlatGreen' where parameterValue='ProjeQtOrForest' and (parameterCode='theme' or parameterCode='defaultTheme');

UPDATE `${prefix}product` set idUser=
(select min(idUser) from `${prefix}history` where (refType='Product' or refType='Component') and refId=`${prefix}product`.id and operationDate=
(select min(operationDate) from `${prefix}history` where (refType='Product' or refType='Component') and refId=`${prefix}product`.id));

UPDATE `${prefix}version` set idUser=
(select min(idUser) from `${prefix}history` where (refType='Version' or refType='ProductVersion' or refType='ComponentVersion') and refId=`${prefix}version`.id and operationDate=
(select min(operationDate) from `${prefix}history` where (refType='Version' or refType='ProductVersion' or refType='ComponentVersion') and refId=`${prefix}version`.id));

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `orientation`) VALUES
(59, 'reportBurndownChart', 2, 'burndownChart.php', 284, 'L');
INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(59, 'idProject', 'projectList', 10, 'currentProject'),
(59, 'format', 'periodScale', 20, 'day'),
(59, 'showBurndownActivities', 'boolean', 30, '1'),
(59, 'showBurndownToday', 'boolean', 40, '1'),
(59, 'showBurndownLegendOnTop', 'boolean', 50, '0');
INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,59,1),
(2,59,1),
(3,59,1);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'OpenDaySunday','offDays'),
(null, null, 'OpenDaySaturday','offDays'),
(null, null, 'OpenDayFriday','openDays'),
(null, null, 'OpenDayThursday','openDays'),
(null, null, 'OpenDayWednesday','openDays'),
(null, null, 'OpenDayTuesday','openDays'),
(null, null, 'OpenDayMonday','openDays');

CREATE TABLE `${prefix}baseline` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `baselineNumber` int(3) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `baselineDate` date DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idTeam` int(12) unsigned DEFAULT NULL,
  `idPrivacy` int(12) unsigned DEFAULT 1,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `baselineProject` ON `${prefix}baseline` (`idProject`);
CREATE INDEX `baselineUser` ON `${prefix}baseline` (`idUser`);
  
CREATE TABLE `${prefix}plannedworkbaseline` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idBaseline` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idAssignment` int(12) unsigned DEFAULT NULL,
  `work` decimal(8,5) unsigned DEFAULT NULL,
  `workDate` date DEFAULT NULL,
  `day` varchar(8) DEFAULT NULL,
  `week` varchar(6) DEFAULT NULL,
  `month` varchar(6) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `dailyCost` decimal(7,2) DEFAULT NULL,
  `cost` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX plannedworkbaselineWorkDate ON `${prefix}plannedworkbaseline` (`workDate`);
CREATE INDEX plannedworkbaselineRef ON `${prefix}plannedworkbaseline` (`refType`,`refId`);
CREATE INDEX plannedworkbaselineBaseline ON `${prefix}plannedworkbaseline` (`idBaseline`);

CREATE TABLE `${prefix}planningelementbaseline` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idBaseline` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `refName` varchar(100) DEFAULT NULL,
  `initialStartDate` date DEFAULT NULL,
  `validatedStartDate` date DEFAULT NULL,
  `plannedStartDate` date DEFAULT NULL,
  `realStartDate` date DEFAULT NULL,
  `initialEndDate` date DEFAULT NULL,
  `validatedEndDate` date DEFAULT NULL,
  `plannedEndDate` date DEFAULT NULL,
  `realEndDate` date DEFAULT NULL,
  `initialDuration` int(5) DEFAULT NULL,
  `validatedDuration` int(5) unsigned DEFAULT NULL,
  `plannedDuration` int(5) DEFAULT NULL,
  `realDuration` int(5) DEFAULT NULL,
  `initialWork` decimal(14,5) unsigned DEFAULT '0.00000',
  `validatedWork` decimal(14,5) unsigned DEFAULT '0.00000',
  `plannedWork` decimal(14,5) unsigned DEFAULT '0.00000',
  `realWork` decimal(14,5) unsigned DEFAULT '0.00000',
  `wbs` varchar(100) DEFAULT NULL,
  `wbsSortable` varchar(400) DEFAULT NULL,
  `topId` int(12) unsigned DEFAULT NULL,
  `topRefType` varchar(100) DEFAULT NULL,
  `topRefId` int(12) unsigned DEFAULT NULL,
  `priority` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  `elementary` int(1) unsigned DEFAULT NULL,
  `leftWork` decimal(14,5) unsigned DEFAULT '0.00000',
  `assignedWork` decimal(14,5) unsigned DEFAULT '0.00000',
  `dependencyLevel` decimal(3,0) unsigned DEFAULT NULL,
  `idPlanningMode` int(12) DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `initialCost` decimal(11,2) DEFAULT NULL,
  `validatedCost` decimal(11,2) DEFAULT NULL,
  `assignedCost` decimal(11,2) DEFAULT NULL,
  `realCost` decimal(11,2) DEFAULT NULL,
  `leftCost` decimal(11,2) DEFAULT NULL,
  `plannedCost` decimal(11,2) DEFAULT NULL,
  `idBill` int(12) unsigned DEFAULT NULL,
  `progress` int(3) unsigned DEFAULT '0',
  `expectedProgress` int(6) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `validatedCalculated` int(1) unsigned DEFAULT '0',
  `workElementEstimatedWork` decimal(9,5) unsigned DEFAULT NULL,
  `workElementRealWork` decimal(9,5) unsigned DEFAULT NULL,
  `workElementLeftWork` decimal(9,5) unsigned DEFAULT NULL,
  `workElementCount` decimal(5,0) unsigned DEFAULT NULL,
  `expenseAssignedAmount` decimal(11,2) unsigned DEFAULT NULL,
  `expensePlannedAmount` decimal(11,2) unsigned DEFAULT NULL,
  `expenseRealAmount` decimal(11,2) unsigned DEFAULT NULL,
  `expenseLeftAmount` decimal(11,2) unsigned DEFAULT NULL,
  `expenseValidatedAmount` decimal(11,2) unsigned DEFAULT NULL,
  `totalAssignedCost` decimal(11,2) unsigned DEFAULT NULL,
  `totalPlannedCost` decimal(11,2) unsigned DEFAULT NULL,
  `totalRealCost` decimal(11,2) unsigned DEFAULT NULL,
  `totalLeftCost` decimal(11,2) unsigned DEFAULT NULL,
  `totalValidatedCost` decimal(11,2) unsigned DEFAULT NULL,
  `notPlannedWork` decimal(12,5) unsigned DEFAULT '0.00000',
  `marginWork` decimal(14,5) DEFAULT NULL,
  `marginCost` decimal(14,5) DEFAULT NULL,
  `marginWorkPct` int(6) DEFAULT NULL,
  `marginCostPct` int(6) DEFAULT NULL,
  `plannedStartFraction` decimal(6,5) DEFAULT '0.00000',
  `plannedEndFraction` decimal(6,5) DEFAULT '1.00000',
  `validatedStartFraction` decimal(6,5) DEFAULT '0.00000',
  `validatedEndFraction` decimal(6,5) DEFAULT '1.00000',
  `reserveAmount` decimal(11,2) unsigned DEFAULT '0.00',
  `validatedExpenseCalculated` int(1) unsigned DEFAULT '0',
  `needReplan` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX planningelementbaselineBaseline ON `${prefix}planningelementbaseline` (`idBaseline`);
CREATE INDEX planningelementbaselineRef ON `${prefix}planningelementbaseline` (`refType`,`refId`);
CREATE INDEX planningelementbaselineProject ON `${prefix}planningelementbaseline` (`idProject`);
CREATE INDEX planningelementbaselineWbsSortable ON `${prefix}planningelementbaseline` (`wbsSortable`(255));

-- gautier ticket 2354
INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES
(8, 'showIdle', 'boolean', 20, 'currentProject');

INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnValidatedCost', '1' FROM `${prefix}resource` WHERE isUser=1; 
INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnAssignedCost', '1' FROM `${prefix}resource` WHERE isUser=1; 
INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnRealCost', '1' FROM `${prefix}resource` WHERE isUser=1; 
INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnLeftCost', '1' FROM `${prefix}resource` WHERE isUser=1; 
INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnPlannedCost', '1' FROM `${prefix}resource` WHERE isUser=1; 
INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnIdStatus', '1' FROM `${prefix}resource` WHERE isUser=1; 
INSERT INTO `${prefix}parameter` (idUser,idProject, parameterCode, parameterValue) 
SELECT id, null, 'planningHideColumnType', '1' FROM `${prefix}resource` WHERE isUser=1; 

CREATE TABLE `${prefix}organization` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` mediumtext,
  `idle` int(1) unsigned DEFAULT '0',
  `idUser` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `sortOrder` varchar(400) DEFAULT NULL,
  `idOrganizationType` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `lastUpdateDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX resourceOrganization ON `${prefix}organization` (`idResource`);

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(158,'menuOrganization', 0, 'object', 18, 'ReadWriteEnvironment', 0, 'EnvironmentalParameter');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,158,1);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES 
(1,158, 1000001);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `id`, 158, 1000002 FROM `${prefix}profile` WHERE `id`!=1;

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(159,'menuOrganizationType', 79, 'object', 803, 'ReadWriteType', 0, 'Type');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) 
SELECT `idProfile`, 159, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=93;
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 159, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=93;  

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `mandatoryDescription`, `code`) VALUES 
('Organization', 'Department', '10',0,false,'DEPT'),
('Organization', 'Unit', '20',0,false,'UNIT'),
('Organization', 'Location', '30',0,false,'LOC');


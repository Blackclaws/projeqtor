-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.5.0 specific for postgresql               //
-- // Date : 2017-09-21                                     //
-- ///////////////////////////////////////////////////////////

-- ticket #2975
INSERT INTO `${prefix}checklistable` (`id`,`name`,`idle`) VALUES 
(23,'Delivery',0);

ALTER TABLE `${prefix}ticket` ADD `delayReadOnly` int(1) DEFAULT '0';

ALTER TABLE `${prefix}delay` ADD `idProject` int(12);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`) VALUES
(23,'showClosedItems','boolean',850,0,null);


INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES 
(75, 'performanceIndicator', 10, 'performanceIndicator.php', 1040);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 75, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(75, 'idProject', 'projectList', 10, 'currentProject'),
(75, 'format', 'periodScale', 30, 'week'),
(75, 'startDate', 'date', 40, null),
(75, 'endDate', 'date', 50, null),
(75, 'activityOrTicket', 'element', 60, null),
(75, 'idTeam', 'teamList', 70, null),
(75, 'idResource', 'resourceList', 80, 'null');

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`) VALUES 
(76, 'reportGlobalWorkPlanningPerResourceWeekly', 2, 'globalWorkPlanningPerResource.php?scale=week', 276, 0, 'L', 0),
(77, 'reportGlobalWorkPlanningPerResourceMonthly', 2, 'globalWorkPlanningPerResource.php?scale=month', 277, 0, 'L', 0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,76,1),
(2,76,1),
(3,76,1),
(4,76,1);

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,77,1),
(2,77,1),
(3,77,1),
(4,77,1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(76, 'idResource', 'resourceList', 10, 'currentResource'),
(76, 'idTeam', 'teamList', 20, NULL),
(76, 'week', 'week', 30, NULL);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(77, 'idResource', 'resourceList', 10, 'currentResource'),
(77, 'idTeam', 'teamList', 20, NULL),
(77, 'month', 'month', 30, NULL);

ALTER TABLE `${prefix}billline` ADD COLUMN `numberDays` DECIMAL(9,2) UNSIGNED;

ALTER TABLE `${prefix}ticket` ADD COLUMN `isRegression` int(1) unsigned DEFAULT '0';

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`) VALUES 
(78, 'reportWorkPlanPerTicket', 2, 'workPlanPerTicket.php',225,0,'L',0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,78,1),
(2,78,1),
(3,78,1),
(4,78,1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(78, 'showIdle', 'boolean', 20, 0),
(78, 'idProject', 'projectList', 10, 'currentProject');

ALTER TABLE `${prefix}statusmail` ADD `mailToProjectIncludingParentProject` int(1) unsigned DEFAULT 0;

INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','Documents',null,6,0 FROM `${prefix}resource` where isUser=1 and idle=0;

ALTER TABLE `${prefix}indicatordefinition` ADD `idProject` int(12);

ALTER TABLE `${prefix}statusmail` ADD `idProject` int(12);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`,`menuClass`) VALUES
(180, 'menuStatusMailPerProject', 88, 'object', 591, 'Project',0, 'Admin'),
(181, 'menuIndicatorDefinitionPerProject', 88, 'object', 611, 'ReadWriteEnvironment', 0, 'Automation'),
(182, 'menuTicketDelayPerProject', 88, 'object', 601, 'ReadWriteEnvironment', 0,'Automation');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 180, 1),
(2, 180, 0),
(3, 180, 0),
(4, 180, 0),
(5, 180, 0),
(6, 180, 0),
(7, 180, 0),
(8, 180, 0),
(1, 181, 1),
(2, 181, 1),
(3, 181, 1),
(4, 181, 0),
(5, 181, 0),
(6, 181, 0),
(7, 181, 0),
(8, 181, 0),
(1, 182, 1),
(2, 182, 1),
(3, 182, 1),
(4, 182, 0),
(5, 182, 0),
(6, 182, 0),
(7, 182, 0),
(8, 182, 0);

ALTER TABLE `${prefix}statusmail` ADD isProject int(1) unsigned DEFAULT '0';

ALTER TABLE `${prefix}delay` ADD isProject int(1) unsigned DEFAULT '0';

ALTER TABLE `${prefix}indicatordefinition` ADD isProject int(1) unsigned DEFAULT '0';

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES ('autoSetAssignmentByResponsible', 'YES');

ALTER TABLE `${prefix}subscription` ADD `idProject` int(12) unsigned;

ALTER TABLE `${prefix}projecthistory` ADD COLUMN `validatedWork` DECIMAL(9,5) UNSIGNED;
ALTER TABLE `${prefix}projecthistory` ADD COLUMN `validatedCost` DECIMAL(11,2) UNSIGNED;

UPDATE `${prefix}report` SET `sortOrder`=483 WHERE `id`=4;
UPDATE `${prefix}report` SET `sortOrder`=484 WHERE `id`=60;

UPDATE `${prefix}reportparameter` SET `defaultValue`=null WHERE idReport=60 and name='month';

ALTER TABLE `${prefix}indicatordefinition` ADD `mailToProjectIncludingParentProject` int(1) unsigned DEFAULT 0;

ALTER TABLE `${prefix}indicatordefinition` ADD `alertToProjectIncludingParentProject` int(1) unsigned DEFAULT 0;

--ADD qCazelles
ALTER TABLE `${prefix}delivery` ADD COLUMN `idProductVersion` INT(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}delivery` ADD COLUMN `idStatus` INT(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}delivery` ADD COLUMN `handled` INT(1) UNSIGNED DEFAULT '0';
ALTER TABLE `${prefix}delivery` ADD COLUMN `handledDateTime` DATETIME DEFAULT NULL;
ALTER TABLE `${prefix}delivery` ADD COLUMN `done` INT(1) UNSIGNED DEFAULT '0';
ALTER TABLE `${prefix}delivery` ADD COLUMN `doneDateTime` DATETIME DEFAULT NULL;
ALTER TABLE `${prefix}delivery` ADD COLUMN `idleDateTime` DATETIME DEFAULT NULL;
ALTER TABLE `${prefix}delivery` ADD COLUMN `cancelled` INT(1) UNSIGNED DEFAULT '0';

ALTER TABLE `${prefix}delivery` CHANGE `idDeliverableType` `idDeliveryType` INT(12) UNSIGNED DEFAULT NULL;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(183, 'menuDeliveryType', 79, 'object', 940, 'ReadWriteType', 0, 'Type');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1, 183, 1);

-- ============= IGE START ===================

--atrancoso -- ticket #84 curve of requirement open vs closed

ALTER TABLE `${prefix}requirement` ADD idPriority int(12) UNSIGNED NULL;

--ALTER TABLE `${prefix}requirement` ADD INDEX( `idPriority`);
CREATE INDEX `requirementPriority` ON `${prefix}requirement` (`idPriority`);

-- ticket #84 Curve of requirement BurnDown
INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`, `hasView`, `hasPrint`, `hasPdf`, `hasToday`, `hasFavorite`, `hasWord`, `hasExcel`) VALUES 
(79, 'burnDownCurve', 8, 'burnDownCurve.php', 860, 0, 'L', 0, 1, 1, 1, 1, 1, 0, 0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 79, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultvalue`, `multiple`) VALUES 
(79, 'idProject', 'projectList', 10, 0, NULL, 0), 
(79, 'idProduct', 'productList', 20, 0, NULL, 0), 
(79, 'idVersion', 'versionList', 30, 0, NULL, 0), 
(79, 'IdUrgency', 'urgencyList', 40, 0, NULL, 0), 
(79, 'idCriticality', 'criticalityList', 50, 0, NULL, 0);

-- ticket #84 Curve of tickets burnDown
INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`, `hasView`, `hasPrint`, `hasPdf`, `hasToday`, `hasFavorite`, `hasWord`, `hasExcel`) VALUES 
(80, 'curveOfTicketsBurndown', 3, 'curveOfTickets.php', 398, 0, 'L', 0, 1, 1, 1, 1, 1, 0, 0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 80, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultvalue`, `multiple`) VALUES 
(80, 'idProject', 'projectList', 10, 0, NULL, 0), 
(80, 'idProduct', 'productList', 20, 0, NULL, 0), 
(80, 'idVersion', 'versionList', 30, 0, NULL, 0), 
(80, 'idPriority', 'priorityList', 50, 0, NULL, 0);
  
INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`, `hasView`, `hasPrint`, `hasPdf`, `hasToday`, `hasFavorite`, `hasWord`, `hasExcel`) 
VALUES (81, 'reportRequirementCumulatedAnnual', 8, 'requirementCumulatedAnualReport.php', 840, 0, 'L', 0, 1, 1, 1, 1, 1, 0, 0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES (1, 81, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultvalue`, `multiple`) VALUES 
(81, 'idProject', 'projectList', 10, 0, NULL, 0), 
(81, 'idProduct', 'productList', 20, 0, NULL, 0), 
(81, 'idVersion', 'versionList', 30, 0, NULL, 0), 
(81, 'month', 'month', 40, 0, 'currentMonth', 0), 
(81, 'idPriority', 'priorityList', 50, 0, NULL, 0);

-- ticket #84  Report requirement nb of days
INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`, `hasView`, `hasPrint`, `hasPdf`, `hasToday`, `hasFavorite`, `hasWord`, `hasExcel`) VALUES 
(82, 'reportRequirementCumulatedNbOfDays', 8, 'requirementNbOfDays.php', 850, 0, 'L', 0, 1, 1, 1, 1, 1, 0, 0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 82, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultvalue`, `multiple`) VALUES 
(82, 'idProject', 'projectList', 10, 0, NULL, 0), 
(82, 'idProduct', 'productList', 20, 0, NULL, 0), 
(82, 'idVersion', 'versionList', 30, 0, NULL, 0), 
(82, 'nbOfDays', 'intInput', 40, 0, 30, 0), 
(82, 'idPriority', 'priorityList', 50, 0, NULL, 0);
-- ============= IGE END ===================
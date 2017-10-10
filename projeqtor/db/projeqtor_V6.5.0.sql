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

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`, `orientation`, `hasCsv`) VALUES 
(75, 'reportGlobalWorkPlanningPerResourceWeekly', 2, 'globalWorkPlanningPerResource.php?scale=week', 276, 0, 'L', 0),
(76, 'reportGlobalWorkPlanningPerResourceMonthly', 2, 'globalWorkPlanningPerResource.php?scale=month', 277, 0, 'L', 0);

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,75,1),
(2,75,1),
(3,75,1),
(4,75,1);

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,76,1),
(2,76,1),
(3,76,1),
(4,76,1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(75, 'idResource', 'resourceList', 10, 'currentResource'),
(75, 'idTeam', 'teamList', 20, NULL),
(75, 'week', 'week', 30, 'currentYear');

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(76, 'idResource', 'resourceList', 10, 'currentResource'),
(76, 'idTeam', 'teamList', 20, NULL),
(76, 'month', 'month', 30, 'currentYear');
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.3.0                                       //
-- // Date : 2016-02-01                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}restricttype` ADD `idProfile` int(12) unsigned DEFAULT NULL;

CREATE INDEX restricttypeProfile ON `${prefix}restricttype` (idProfile,className,idType);

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES
(57, 'reportPlanDetailPerResource', 2, 'detailPlan.php', 456);
INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(169, 57, 'month', 'month', 10, 'currentMonth'),
(170, 57, 'idProject', 'projectList', 1, 'currentProject'),
(171, 57, 'idResource', 'resourceList', 20, 'currentResource');
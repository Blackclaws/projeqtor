-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.3.0                                       //
-- // Date : 2016-02-01                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}restricttype` ADD `idProfile` int(12) unsigned DEFAULT NULL;

CREATE INDEX restricttypeProfile ON `${prefix}restricttype` (idProfile,className,idType);

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES
(57, 'reportPlanDetailPerResource', 2, 'detailPlan.php', 256);
INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(169, 57, 'month', 'month', 20, 'currentMonth'),
(171, 57, 'idResource', 'resourceList', 10, 'currentResource');
INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,57,1),
(2,57,1),
(3,57,1),
(4,57,1);
INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(172, 31, 'idResource', 'resourceList', 17, null);

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(173, 42, 'idResource', 'resourceList', 17, null);
INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES
(58, 'reportPlanProjectDetailPerResource', 2, 'activityPlan.php', 257);
INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(174, 58, 'month', 'month', 20, 'currentMonth'),
(175, 58, 'idResource', 'resourceList', 10, 'currentResource');
INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,58,1),
(2,58,1),
(3,58,1),
(4,58,1);


CREATE TABLE `${prefix}menucustom` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idMenu` int(12) unsigned DEFAULT NULL,
  `name` varchar(100),
  `idUser` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
CREATE INDEX menucustomUser ON `${prefix}menucustom` (idUser);

ALTER TABLE `${prefix}billline` CHANGE `quantity` `quantity` decimal(9,2) DEFAULT NULL;

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(176, 31, 'includeNextMonth', 'boolean', 50, null),
(177, 57, 'includeNextMonth', 'boolean', 50, null),
(178, 4, 'includeNextMonth', 'boolean', 50, null),
(179, 5, 'includeNextMonth', 'boolean', 50, null),
(180, 6, 'includeNextMonth', 'boolean', 50, null),
(181, 42, 'includeNextMonth', 'boolean', 50, null),
(182, 58, 'includeNextMonth', 'boolean', 50, null);
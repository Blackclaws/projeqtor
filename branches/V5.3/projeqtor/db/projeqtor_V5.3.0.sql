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
(169, 57, 'month', 'month', 10, 'currentMonth'),
(171, 57, 'idResource', 'resourceList', 20, 'currentResource');
INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,57,1),
(2,57,1),
(3,57,1),
(4,57,1);

CREATE TABLE `${prefix}menucustom` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idMenu` int(12) unsigned DEFAULT NULL,
  `name` varchar(100),
  `idUser` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
CREATE INDEX menucustomUser ON `${prefix}menucustom` (idUser);
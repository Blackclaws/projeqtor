
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.1.0                               //
-- // Date : 2012-12-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}requirement` ADD COLUMN `locked` int(1) unsigned default '0',
ADD COLUMN `idLocker` int(12) unsigned,
ADD COLUMN `lockedDate` datetime;

ALTER TABLE  `${prefix}habilitationother` 
CHANGE scope scope varchar(20) DEFAULT NULL;

INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'requirement', 1),
(2, 'requirement', 2),
(3, 'requirement', 1),
(4, 'requirement', 2),
(6, 'requirement', 2),
(7, 'requirement', 2),
(5, 'requirement', 2);  

INSERT INTO `${prefix}habilitationother` (idProfile,scope,rightAccess) VALUES 
(1,'workValid','4'),
(2,'workValid','2'),
(3,'workValid','3'),
(4,'workValid','2'),
(6,'workValid','1'),
(7,'workValid','1'),
(5,'workValid','1');

CREATE TABLE `${prefix}workPeriod` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned,
  `periodRange` varchar(10),
  `periodValue` varchar(10),
  `submitted` int(1) unsigned default '0',
  `submittedDate` datetime,
  `validated` int(1) unsigned default '0',
  `validatedDate` datetime,
  `idLocker` int(12) unsigned,
  `comment` varchar(4000),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX workPeriodResource ON `${prefix}workPeriod` (idResource);
CREATE INDEX workPeriodWeek ON `${prefix}week` (workPeriod);

CREATE TABLE `${prefix}efficiency` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}efficiency` (`id`, `name`, `color`, `sortOrder`, `idle`) VALUES
(1,'fully efficient','#99FF99',100,0),
(2,'partially efficient','#87ceeb',200,0),
(3,'not efficient','#FF0000',300,0);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(117,'menuEfficiency',36,'object',745,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 117, 1),
(2, 117, 0),
(3, 117, 0),
(4, 117, 0),
(5, 117, 0),
(6, 117, 0),
(7, 117, 0);

ALTER TABLE `${prefix}action` ADD COLUMN `idEfficiency` int(12) unsigned default null;

UPDATE `${prefix}menu` SET sortOrder=705 WHERE name='menuStatus';
UPDATE `${prefix}menu` SET sortOrder=710 WHERE name='menuLikelihood';
UPDATE `${prefix}menu` SET sortOrder=715 WHERE name='menuCriticality';
UPDATE `${prefix}menu` SET sortOrder=720 WHERE name='menuSeverity';
UPDATE `${prefix}menu` SET sortOrder=725 WHERE name='menuUrgency';
UPDATE `${prefix}menu` SET sortOrder=730 WHERE name='menuPriority';
UPDATE `${prefix}menu` SET sortOrder=735 WHERE name='menuRiskLevel';
UPDATE `${prefix}menu` SET sortOrder=740 WHERE name='menuFeasibility';
UPDATE `${prefix}menu` SET sortOrder=760 WHERE name='menuPredefinedNote'; 

insert into `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) VALUES 
(45, 'reportTermMonthly', 7, 'term.php', 720, 0);
(46, 'reportTermWeekly', '7', 'term.php', '730', '0');

INSERT INTO `${prefix}reportparameter` (`idReport`,`name`,`paramType`,`order`,`idle`,`defaultValue`) VALUES
(45,'idProject','projectList',10,0,'currentProject'),
(45,'month','month',20,0,'currentMonth'),
(46,'idProject','projectList',10,0,'currentProject'),
(46,'week','week',20,0,'currentWeek');

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,45,1),
(2,45,1),
(3,45,0),
(4,45,0),
(1,46,1),
(2,46,1),
(3,46,0),
(4,46,0);

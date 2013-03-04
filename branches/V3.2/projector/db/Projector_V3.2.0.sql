
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.2.0                                      //
-- // Date : 2012-12-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}opportunity` ADD COLUMN `idPriority` int(12) unsigned;
ALTER TABLE `${prefix}risk` ADD COLUMN `idPriority` int(12) unsigned;

INSERT INTO `${prefix}importable` (`id`, `name`, `idle`) VALUES
(26, 'Opportunity', 0);

INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`, idDefaultLinkable) VALUES
(15,'IndividualExpense',0,4);

CREATE TABLE `${prefix}health` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}health` (`id`, `name`, `color`, `sortOrder`, `idle`) VALUES
(1,'secured','#32CD32',100,0),
(2,'surveyed','#ffd700',200,0),
(3,'in danger','#FF0000',300,0),
(4,'crashed','#000000',400,0),
(5,'paused','#E0E0E0',500,0);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(121,'menuHealth',36,'object',707,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 121, 1),
(2, 121, 0),
(3, 121, 0),
(4, 121, 0),
(5, 121, 0),
(6, 121, 0),
(7, 121, 0);

ALTER TABLE `${prefix}project` ADD COLUMN `idHealth` int(12) unsigned;

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES
(47, 'reportOpportunityPlan', 4, 'opportunityPlan.php', 440);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES
(47, 'idProject', 'projectList', 10, 'currentProject');

CREATE TABLE `${prefix}audit` (
  `id` varchar(100),
  `firstAccess` datetime,
  `lastAccess` datetime,
  `idUser` int(12) unsigned,
  `userName` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX auditUser ON `${prefix}audit` (idUser);

CREATE TABLE `${prefix}auditsummary` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `auditDay` date,
  `firstAccess` datetime,
  `lastAccess` datetime,
  `numberSessions` int(10),
  `minDuration` int(10),
  `maxDuration` int(10),
  `meanDuration` int(10),
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 
CREATE INDEX auditsummaryAuditDay ON `${prefix}auditsummary` (auditDay);
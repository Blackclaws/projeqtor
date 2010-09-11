
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.2.0                           //
-- // Date : 2010-09-01                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `order`) VALUES
(7, 'reportPlanGantt', 2, '../tool/jsonPlanning.php', 5);

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`) VALUES 
(7, 7, 'startDate', 'date', 20),
(8, 7, 'endDate', 'date', 40),
(9, 7, 'scale', 'periodScale', 40),
(10, 7, 'project', 'projectList', 10);

CREATE TABLE `${prefix}decision` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idDecisionType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `decisionDate` date DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `decisionAccountable` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


CREATE TABLE `${prefix}question` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `sendTo` varchar(100) DEFAULT NULL,
  `sendMail` varchar(100) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `replier` varchar(100) DEFAULT NULL,
  `initialDueDate` date DEFAULT NULL,
  `actualDueDate` date DEFAULT NULL,
  `closureDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `response` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(62, 'menuDecisions', 7, 'item', 230, NULL, 0);
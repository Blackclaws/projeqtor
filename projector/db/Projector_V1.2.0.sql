
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
  `idQuestionType` int(12) unsigned DEFAULT NULL,
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

CREATE TABLE `${prefix}meetings` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idMetingType` int(12) unsigned DEFAULT NULL,
  `meetingDate` date DEFAULT NULL,
  `attendees` varchar(4000) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `sendTo` varchar(4000) DEFAULT NULL,
  `minutes` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

UPDATE `${prefix}menu` SET type='menu',
  name='menuReview',
  idle=0,
  sortOrder=250,
  level=null
WHERE ID=6;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(62, 'menuMeeting', 6, 'object', 260, 'Project', 0),
(63, 'menuDecision', 6, 'object', 270, 'Project', 0),
(64, 'menuQuestion', 6, 'object', 280, 'Project', 0);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1, 62, 8),
(2, 62, 2),
(3, 62, 7),
(4, 62, 1),
(6, 62, 1),
(7, 62, 1),
(5, 62, 1),
(1, 63, 8),
(2, 63, 2),
(3, 63, 7),
(4, 63, 1),
(6, 63, 1),
(7, 63, 1),
(5, 63, 1),
(1, 64, 8),
(2, 64, 2),
(3, 64, 7),
(4, 64, 1),
(6, 64, 1),
(7, 64, 1),
(5, 64, 1);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 62, 1),
(2, 62, 1),
(3, 62, 1),
(4, 62, 1),
(6, 62, 1),
(7, 62, 1),
(5, 62, 1),
(1, 63, 1),
(2, 63, 1),
(3, 63, 1),
(4, 63, 1),
(6, 63, 1),
(7, 63, 1),
(5, 63, 1),
(1, 64, 1),
(2, 64, 1),
(3, 64, 1),
(4, 64, 1),
(6, 64, 1),
(7, 64, 1),
(5, 64, 1);

UPDATE `${prefix}habilitation` SET allowAccess=1
WHERE idMenu=6;


-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.8.0                                      //
-- // Date : 2010-09-07                                     //
-- ///////////////////////////////////////////////////////////
--
--

CREATE TABLE `${prefix}indicatordefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `code` varchar(10),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}indicatordefinition` (`id`, `code`, `name`, `idle`) VALUES
(1, 'IDDT', 'InitialDueDateTime', 0),
(2, 'ADDT', 'ActualDueDateTime', 0),
(3, 'IDD', 'InitialDueDate', 0),
(4, 'ADD', 'ActualDueDate', 0),
(5, 'RED', 'RequestedEndDate', 1),
(6, 'VED', 'ValidatedEndDate', 0),
(7, 'PED', 'PlannedEndDate', 0),
(8, 'RED', 'RequestedStartDate', 1),
(9, 'VED', 'ValidatedStartDate', 1),
(10, 'PED', 'PlannedStartDate', 1),
(11, 'PCOEC', 'PlannedCostOverValidatedCost', 0),
(12, 'PCOAC', 'PlannedCostOverAssignedCost', 0),
(13, 'PWOEW', 'PlannedWorkOverValidatedWork', 0),
(14, 'PWOAW', 'PlannedWorkOverAssignedWork', 0);

CREATE TABLE `${prefix}indicatorable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100),
  `idIndicatorDefinition` varchar(100),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}indicatorable` (`idIndicatorDefinition`, `refType`, `idle`) VALUES
(1, 'Ticket', 0),
(2, 'Ticket', 0),
(3, 'Risk', 0),
(3, 'Action', 0),
(3, 'Issue', 0),
(3, 'Question', 0),
(4, 'Risk', 0),
(4, 'Action', 0),
(4, 'Issue', 0),
(4, 'Question', 0),
(5, 'Activity',0),
(5, 'Milestone',0),
(5, 'Project',0),
(6, 'Activity',0),
(6, 'Milestone',0),
(6, 'Project',0),
(7, 'Activity',0),
(7, 'Milestone',0),
(7, 'Project',0),
(8, 'Activity',0),
(8, 'Project',0),
(9, 'Activity',0),
(9, 'Project',0),
(10, 'Activity',0),
(10, 'Project',0),
(11, 'Activity',0),
(11, 'Project',0),
(12, 'Activity',0),
(12, 'Project',0),
(13, 'Activity',0),
(13, 'Project',0),
(14, 'Activity',0),
(14, 'Project',0);

CREATE TABLE `${prefix}indicator` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100),
  `idIndicator` varchar(100),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}indicatorvalue` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100),
  `refId` int(10) unsigned,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'startAM','08:00'),
(null, null, 'endAM','12:00'),
(null, null, 'startPM','14:00'),
(null, null, 'endPM','18:00'),
(null, null, 'dayTime','8.00');

CREATE TABLE `${prefix}delayunit` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10),
  `name` varchar(100),
  `sortOrder` int(3),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
  
INSERT INTO `${prefix}delayunit` (id, code, name, sortOrder, idle) VALUES 
(1,'HH','hours',100, 0),
(2,'OH','openHours',200, 0),
(3,'DD','days',300, 0),
(4,'OD','openDays',400, 0);

CREATE TABLE `${prefix}delay` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100),
  `idType` int(12) unsigned,
  `idUrgency` int(12) unsigned,
  `value` decimal(6,3),
  `idDelayUnit` int(12) unsigned,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}delay` (`id`, `scope`, `idType`, `idUrgency`, `value`, `idDelayUnit`, `idle`) VALUES
(1,'Ticket',16,1,2,2,0),
(2,'Ticket',16,2,1,4,0),
(3,'Ticket',17,1,1,4,0),
(4,'Ticket',17,1,4,4,0),
(5,'Ticket',18,1,4,2,0),
(6,'Ticket',18,2,2,4,0);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(88, 'menuAutomation', 13, 'menu', 765, Null, 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 88, 1),
(2, 88, 1),
(3, 88, 1);

UPDATE `${prefix}menu` SET idMenu=88 where id=59;
UPDATE `${prefix}menu` SET idMenu=88 where id=68;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(89, 'menuTicketDelay', 88, 'object', 785, Null, 0);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 89, 1),
(2, 89, 1),
(3, 89, 1);


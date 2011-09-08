
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

INSERT INTO `${prefix}indicatorable` (`id`, `idIndicatorDefinition`, `refType`, `idle`) VALUES
(1, 1, 'Ticket', 0),
(2, 2, 'Ticket', 0),
(3, 3, 'Risk', 0),
(4, 3, 'Action', 0),
(5, 3, 'Issue', 0),
(6, 3, 'Question', 0),
(7, 4, 'Risk', 0),
(8, 4, 'Action', 0),
(9, 4, 'Issue', 0),
(10, 4, 'Question', 0),
(, 5, 'Activity',0),
(,5 
;

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
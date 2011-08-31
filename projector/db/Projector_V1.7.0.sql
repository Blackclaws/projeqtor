
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.7.0                                      //
-- // Date : 2010-07-25                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}expense` ADD INDEX expenseProject (idProject),
ADD INDEX expenseType (idExpenseType),
ADD INDEX expenseUser (idUser),
ADD INDEX expenseResource (idResource),
ADD INDEX expenseStatus (idStatus),
ADD INDEX expenseDay (day),
ADD INDEX expenseWeek (week),
ADD INDEX expenseMonth (month),
ADD INDEX expenseYear (year);

ALTER TABLE `${prefix}expensedetail` ADD INDEX expensedetailProject (idProject),
ADD INDEX expensedetailType (idExpenseDetailType),
ADD INDEX expensedetailExpense (idExpense);

ALTER TABLE `${prefix}habilitationother` ADD INDEX habilitationotherProfile (idProfile);

ALTER TABLE `${prefix}list` ADD INDEX listList (list);

ALTER TABLE `${prefix}planningmode` ADD INDEX planningmodeApplyTo (applyTo);

ALTER TABLE `${prefix}resourcecost` ADD INDEX resourcecostResource (idResource);

ALTER TABLE `${prefix}user` ADD INDEX userIsResource (isResource),
ADD INDEX userIsUser (isUser),
ADD INDEX userIsContact (isContact);

CREATE TABLE `${prefix}calendar` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `isOffDay` int(1) unsigned DEFAULT '0',
  `calendarDate` date DEFAULT NULL,
  `day`  varchar(8),
  `week` varchar(6),
  `month` varchar(6),
  `year` varchar(4),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}calendar` ADD INDEX calendarDay (day),
ADD INDEX calendarWeek (week),
ADD INDEX calendarMonth (month),
ADD INDEX calendarYear (year);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(85, 'menuCalendar', 14, 'object', 685, Null, 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 85, 1),
(2, 85, 1),
(3, 85, 1);

CREATE TABLE `${prefix}origin` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `originType` varchar(100) default NULL,
  `originId` int(12) unsigned default NULL,
  `refType` varchar(100),
  `refId` int(12) unsigned,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}origin` ADD INDEX originOrigin (originType, originId),
ADD INDEX originRef (refType, refId);

CREATE TABLE `${prefix}originable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}originable` (`id`, `name`, `idle`) VALUES
(1, 'Ticket', 0),
(2, 'Activity', 0),
(3, 'Milestone', 0),
(4, 'IndividualExpense', 0),
(5, 'ProjectExpense', 0),
(6, 'Risk', 0),
(7, 'Action', 0),
(8, 'Issue', 0),
(9, 'Meeting', 0),
(10, 'Decision', 0),
(11, 'Question', 0);

CREATE TABLE `${prefix}copyable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `sortOrder` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}copyable` (`id`, `name`, `idle`, `sortOrder`) VALUES
(1, 'Ticket', 0, 10),
(2, 'Activity', 0, 20),
(3, 'Milestone', 0, 30),
(4, 'IndividualExpense', 0, 40),
(5, 'ProjectExpense', 0, 50),
(6, 'Risk', 0, 60),
(7, 'Action', 0, 70),
(8, 'Issue', 0, 80),
(9, 'Meeting', 0, 90),
(10, 'Decision', 0, 100),
(11, 'Question', 0, 110);

CREATE TABLE `${prefix}product` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}product` ADD INDEX productClient (idClient),
ADD INDEX pruductContact (idContact);

CREATE TABLE `${prefix}version` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}version` ADD INDEX versionProduct (idProduct),
ADD INDEX versionContact (idContact),
ADD INDEX versionResource (idResource);

CREATE TABLE `${prefix}versionproject` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}versionproject` ADD INDEX versionprojectProject (idProject),
  ADD INDEX versionprojectVersion (idVersion);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`) VALUES
(86, 'menuProduct', 14, 'object', 642, Null, 0),
(87, 'menuVersion', 14, 'object', 644, Null, 0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 86, 1),
(2, 86, 1),
(3, 86, 1),
(1, 87, 1),
(2, 87, 1),
(3, 87, 1);

ALTER TABLE `${prefix}project` ADD `idContact` int(12) unsigned DEFAULT NULL;
ALTER TABLE `${prefix}project` ADD INDEX projectContact (idContact);

ALTER TABLE `${prefix}plannedwork` CHANGE `work` `work` DECIMAL(5,2) UNSIGNED;

ALTER TABLE `${prefix}ticket` ADD `idVersion` int(12) unsigned DEFAULT NULL,
ADD `idOriginalVersion` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}activity` ADD `idVersion` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}milestone` ADD `idVersion` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}affectation` ADD `idContact` int(12) unsigned DEFAULT NULL,
ADD `idUser` int(12) unsigned DEFAULT NULL;

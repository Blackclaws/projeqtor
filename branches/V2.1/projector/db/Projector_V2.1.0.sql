
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.1.0                                      //
-- // Date : 2012-02-26                                     //
-- ///////////////////////////////////////////////////////////
--
--

ALTER TABLE `${prefix}planningelement` CHANGE initialWork initialWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE validatedWork validatedWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE plannedWork plannedWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE realWork realWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE assignedWork assignedWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE leftWork leftWork DECIMAL(14,5) UNSIGNED DEFAULT '0';
 
ALTER TABLE `${prefix}product` ADD COLUMN `idProduct`  int(12) unsigned DEFAULT NULL;

--ALTER TABLE `${prefix}ticket` ADD COLUMN `plannedWork`  DECIMAL(6,2) unsigned default 0,
--ADD COLUMN `realWork`  DECIMAL(6,2) unsigned DEFAULT 0;

ALTER TABLE `${prefix}ticket` ADD COLUMN `idTicket` int(12) unsigned DEFAULT NULL;

CREATE TABLE `${prefix}workelement` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `refName` varchar(100) DEFAULT NULL,
  `plannedWork`  DECIMAL(6,2) unsigned default 0,
  `realWork`  DECIMAL(6,2) unsigned DEFAULT 0,
  `leftWork`  DECIMAL(6,2) unsigned DEFAULT 0,
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}workelement` ADD INDEX workelementReference (refType, refId);

UPDATE `${prefix}report` set sortOrder=150 where name='reportWorkDetailMonthly';
UPDATE `${prefix}report` set sortOrder=160 where name='reportWorkDetailYearly';
UPDATE `${prefix}report` set sortOrder=250 where name='reportPlanProjectMonthly';
UPDATE `${prefix}report` set sortOrder=250 where name='reportPlanProjectMonthly';
UPDATE `${prefix}report` set sortOrder=255 where name='reportPlanDetail';
UPDATE `${prefix}report` set sortOrder=260 where name='reportGlobalWorkPlanningWeekly';
UPDATE `${prefix}report` set sortOrder=270 where name='reportGlobalWorkPlanningMonthly';
UPDATE `${prefix}report` set sortOrder=280 where name='reportAvailabilityPlan';

UPDATE `${prefix}report` set sortOrder=350 where name='reportTicketYearlyCrossReport';
UPDATE `${prefix}report` set sortOrder=355 where name='reportTicketGlobalCrossReport';
UPDATE `${prefix}report` set sortOrder=360 where name='reportTicketWeeklySynthesis';
UPDATE `${prefix}report` set sortOrder=370 where name='reportTicketMonthlySynthesis';
UPDATE `${prefix}report` set sortOrder=380 where name='reportTicketYearlySynthesis';
UPDATE `${prefix}report` set sortOrder=390 where name='reportTicketGlobalSynthesis';
UPDATE `${prefix}report` set sortOrder=510 where name='reportHistoryDetail';
UPDATE `${prefix}report` set sortOrder=660 where name='reportExpenseProject';
UPDATE `${prefix}report` set sortOrder=670 where name='reportExpenseResource';
UPDATE `${prefix}report` set sortOrder=680 where name='reportExpenseTotal';
UPDATE `${prefix}report` set sortOrder=690 where name='reportExpenseCostTotal';
UPDATE `${prefix}report` set sortOrder=710 where name='reportBill';

INSERT INTO `${prefix}reportparameter` (idReport, name, paramType, `order`, defaultValue) VALUES 
(1,'idProject', 'projectList', 1, 'currentProject'),
(2,'idProject', 'projectList', 1, 'currentProject'),
(3,'idProject', 'projectList', 1, 'currentProject'),
(28,'idProject', 'projectList', 1, 'currentProject'),
(29,'idProject', 'projectList', 1, 'currentProject'),
(30,'idProject', 'projectList', 1, 'currentProject'),
(4,'idProject', 'projectList', 1, 'currentProject'),
(5,'idProject', 'projectList', 1, 'currentProject'),
(6,'idProject', 'projectList', 1, 'currentProject');

CREATE TABLE `${prefix}contexttype` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `${prefix}contexttype` (id, name) VALUES
(1,'colIdContext1'),
(2,'colIdContext2'),
(3,'colIdContext3');

CREATE TABLE `${prefix}context` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idContextType`  int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}context` ADD INDEX contextContextType (idContextType);

INSERT INTO  `${prefix}context` (idContextType, name, sortOrder) VALUES 
(1,'Production', 100),
(1,'Validation', 200),
(2,'Windows 7', 100),
(2,'Windows Vista', 110),
(2,'Windows XP', 120),
(2,'Mac OS X', 200),
(2,'Mac OS <=9', 210),
(2,'Linux', 210),
(3,'IE 9', 100),
(3,'IE 8', 110),
(3,'IE 7', 120),
(3,'IE <= 6', 130),
(3,'FireFox >= 5', 200),
(3,'FireFox <= 4', 210),
(3,'Chrome', 300),
(3,'Safari', 400);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(104,'menuContext',14,'object',660,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 104, 1);

ALTER TABLE `${prefix}ticket` ADD COLUMN `idContext1` int(12) unsigned DEFAULT NULL,
ADD COLUMN `idContext2` int(12) unsigned DEFAULT NULL,
ADD COLUMN `idContext3` int(12) unsigned DEFAULT NULL;

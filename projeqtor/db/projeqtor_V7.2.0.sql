-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.2.0                                       //
-- // Date : 2018-06-18                                     //
-- ///////////////////////////////////////////////////////////

-- ==================================================================
-- Financial evolutions
-- ==================================================================

CREATE TABLE `${prefix}providerOrder` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` VARCHAR(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `idProviderOrderType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `additionalInfo` mediumtext DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL,
  `evaluationValue` decimal(7,2) DEFAULT NULL,
  `evaluationRank` int(3) DEFAULT NULL,
  `totalUntaxedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `totalTaxAmount` decimal(11,2) UNSIGNED,
  `totalFullAmount` decimal(11,2) UNSIGNED,
  `untaxedAmount` decimal(11,2) UNSIGNED,
  `taxAmount` decimal(11,2) UNSIGNED,
  `fullAmount` decimal(11,2) UNSIGNED,
  `discountAmount` DECIMAL(11,2),
  `discountRate`   DECIMAL(5,2),
  `deliveryDelay` varchar(100) DEFAULT NULL,
  `deliveryExpectedDate` date DEFAULT NULL,
  `deliveryDoneDate` date DEFAULT NULL,
  `deliveryValidationDate` date DEFAULT NULL,
  `paymentCondition` varchar(100) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX providerOrderProject ON `${prefix}providerOrder` (idProject);
CREATE INDEX providerOrderUser ON `${prefix}providerOrder` (idUser);
CREATE INDEX providerOrderResource ON `${prefix}providerOrder` (idResource);
CREATE INDEX providerOrderStatus ON `${prefix}providerOrder` (idStatus);
CREATE INDEX providerOrderType ON `${prefix}providerOrder` (idProviderOrderType);

CREATE TABLE `${prefix}providerBill` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` VARCHAR(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `idProviderBillType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `additionalInfo` mediumtext DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL,
  `evaluationValue` decimal(7,2) DEFAULT NULL,
  `evaluationRank` int(3) DEFAULT NULL,
  `totalUntaxedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `totalTaxAmount` decimal(11,2) UNSIGNED,
  `totalFullAmount` decimal(11,2) UNSIGNED,
  `untaxedAmount` decimal(11,2) UNSIGNED,
  `taxAmount` decimal(11,2) UNSIGNED,
  `fullAmount` decimal(11,2) UNSIGNED,
  `discountAmount` DECIMAL(11,2),
  `discountRate`   DECIMAL(5,2),
  `lastPaymentDate` date DEFAULT NULL,
  `expectedPaymentDate` date DEFAULT NULL,
  `paymentAmount` DECIMAL(11,2),
  `paymentCondition` varchar(100) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  `paymentDone` int(1) unsigned DEFAULT 0,
  `paymentDate` date DEFAULT NULL,
  `paymentAmount` DECIMAL(11,2) UNSIGNED,
  `idPaymentDelay` int(12) unsigned DEFAULT NULL,
  `paymentDueDate` date DEFAULT NULL,
  `paymentsCount` int(3) default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}providerTerm` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  `idProviderOrder` int(12) unsigned DEFAULT NULL,
  `idProviderBill` int(12) unsigned DEFAULT NULL,
  `untaxedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `taxAmount` decimal(11,2) UNSIGNED,
  `fullAmount` decimal(11,2) UNSIGNED,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX providerTermProject ON `${prefix}providerTerm` (idProject);
CREATE INDEX providerTermOrder ON `${prefix}providerTerm` (idProviderOrder);
CREATE INDEX providerTermBill ON `${prefix}providerTerm` (idProviderBill);


CREATE TABLE `${prefix}providerPayment` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `idProviderBill` int(12) unsigned DEFAULT NULL,
  `paymentDate` date,
  `idPaymentMode` int(12) unsigned DEFAULT NULL,
  `idle` int(1) DEFAULT 0,
  `idPaymentType` int(12) unsigned DEFAULT NULL,
  `paymentAmount`  DECIMAL(11,2) UNSIGNED,
  `paymentFeeAmount`  DECIMAL(11,2) UNSIGNED,
  `paymentCreditAmount` DECIMAL(11,2) UNSIGNED,
  `description` mediumtext,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDate` date,
  `referenceProviderBill` varchar(100) DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `providerBillAmount` DECIMAL(11,2) UNSIGNED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(190,'menuProviderOrderType', 79, 'object', 826, 'Project', 0, 'Type '),
(191,'menuProviderOrder', 151, 'object', 207, 'Project', 0, 'Financial '),
(193,'menuProviderBillType', 79, 'object', 826, 'Project', 0, 'Type '),
(194,'menuProviderBill', 151, 'object', 209, 'Project', 0, 'Financial '),
(195,'menuProviderTerm', 151, 'object', 208, 'Project', 0, 'Financial '),
(201,'menuProviderPayment', 151, 'object', 210, 'Project', 0, 'Financial ');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 190, 1),
(1, 191, 1),
(1, 193, 1),
(1, 194, 1),
(1, 195, 1),
(1, 201, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,190,8),
(1,191,8),
(1,193,8),
(1,194,8),
(1,195,8),
(1,201,8);

ALTER TABLE `${prefix}tender`
CHANGE `initialAmount` `untaxedAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `initialTaxAmount` `taxAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `initialFullAmount` `fullAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `plannedAmount` `totalUntaxedAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `plannedTaxAmount` `totalTaxAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
CHANGE `plannedFullAmount` `totalFullAmount` DECIMAL(11,2) UNSIGNED NULL DEFAULT NULL,
ADD `discountAmount` DECIMAL(11,2),
ADD `discountRate`   DECIMAL(5,2);

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `color`, idWorkflow, isHandledStatus, isDoneStatus, isIdleStatus, isCancelledStatus) VALUES
('ProviderOrder', 'Product', 10, 0, NULL, 1, 1, 1, 1, 1),
('ProviderOrder', 'Service', 20, 0, NULL, 1, 1, 1, 1, 1);

INSERT INTO `${prefix}copyable` (`id`,`name`, `idle`, `sortOrder`,`idDefaultCopyable`) VALUES 
(23,'ProviderOrder', '0', '121','24'),
(24,'ProviderBill', '0', '122',NULL),
(25,'ProviderTerm', '0', '123',NULL);

UPDATE `${prefix}copyable` SET idDefaultCopyable=23 WHERE id=16;

ALTER TABLE `${prefix}billLine`
ADD `idBillLine` int(12)  DEFAULT NULL,
ADD `rate` DECIMAL(5,2)  DEFAULT NULL;

-- ==================================================================
-- Budget
-- ==================================================================
CREATE TABLE `${prefix}budget` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `idBudgetType` int(12) unsigned DEFAULT NULL,
  `idBudgetOrientation` int(12) unsigned DEFAULT NULL,
  `idBudgetCategory` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `lastUpdateDateTime` datetime DEFAULT NULL,
  `articleNumber` VARCHAR(100) DEFAULT NULL,
  `idOrganization` int(12) unsigned DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `clientCode` VARCHAR(100) DEFAULT NULL,
  `idBudget` int(12) unsigned DEFAULT NULL,
  `idSponsor` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `color` VARCHAR(7) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `isUnderConstruction` int(1) unsigned DEFAULT '1',
  `handled` int(1) unsigned DEFAULT '1',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `cancelled` int(1) unsigned DEFAULT '0',
  `bbs` varchar(1000) DEFAULT NULL,
  `bbsSortable` varchar(4000) DEFAULT NULL,
  `budgetStartDate` date DEFAULT NULL,
  `budgetEndDate` date DEFAULT NULL,
  `plannedAmount` decimal(14,2) UNSIGNED,
  `initialAmount` decimal(14,2) UNSIGNED,
  `update1Amount` decimal(14,2) UNSIGNED,
  `update2Amount` decimal(14,2) UNSIGNED,
  `update3Amount` decimal(14,2),
  `update4Amount` decimal(14,2),
  `actualAmount` decimal(14,2),
  `actualSubAmount` decimal(14,2),
  `usedAmount` decimal(14,2) UNSIGNED,
  `availableAmount` decimal(14,2),
  `billedAmount` decimal(14,2) UNSIGNED,
  `leftAmount` decimal(14,2),
  `plannedFullAmount` decimal(14,2) UNSIGNED,
  `initialFullAmount` decimal(14,2) UNSIGNED,
  `update1FullAmount` decimal(14,2) UNSIGNED,
  `update2FullAmount` decimal(14,2) UNSIGNED,
  `update3FullAmount` decimal(14,2),
  `update4FullAmount` decimal(14,2),
  `actualFullAmount` decimal(14,2),
  `actualSubFullAmount` decimal(14,2),
  `usedFullAmount` decimal(14,2) UNSIGNED,
  `availableFullAmount` decimal(14,2) ,
  `billedFullAmount` decimal(14,2) UNSIGNED,
  `leftFullAmount` decimal(14,2),
  `elementary` int(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `budgetBudgetType` ON `${prefix}budget` (idBudgetType);
CREATE INDEX `budgetBudget` ON `${prefix}budget` (idBudget);

ALTER TABLE `${prefix}expense`
ADD `idBudgetItem` int(12) unsigned DEFAULT NULL;
CREATE INDEX expenseBudget ON `${prefix}expense` (idBudgetItem);

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idWorkflow`, `idle`) VALUES 
('Budget', 'Initial',10,1, 0),
('Budget', 'Additional',20,1 ,0);

CREATE TABLE `${prefix}budgetcategory` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `${prefix}budgetcategory` (`name`, `sortOrder`, `idle`) VALUES 
('Information Technology',10,0),
('Human Resources',20,0),
('Financials',30,0),
('Management',40,0);

CREATE TABLE `${prefix}budgetorientation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `${prefix}budgetorientation` (`name`, `sortOrder`, `idle`) VALUES 
('Operation',10,0),
('Transformation',20,0);


INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(197,'menuBudget', 151, 'object', 203, 'ReadWriteEnvironment', 0, 'Financial'),
(198,'menuBudgetType', 79, 'object', 824, 'ReadWriteType', 0, 'Type'),
(199,'menuBudgetOrientation', 36, 'object', 789, 'ReadWriteList', 0, 'ListOfValues'),
(200,'menuBudgetCategory', 36, 'object', 789, 'ReadWriteList', 0, 'ListOfValues');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 197, 1),
(1, 198, 1),
(1, 199, 1),
(1, 200, 1);

-- ==================================================================
-- Global views
-- ==================================================================

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(192,'menuGlobalView', 2, 'object', 95, 'Project', 0, 'Work');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,192,1),
(2,192,1),
(3,192,1),
(4,192,1);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES 
(1,192, 8),
(2,192, 2),
(3,192, 7),
(4,192, 7);

-- Table Global View : created only to get correct formatting for fields on list : this table will always be empty
CREATE TABLE `${prefix}globalview` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `objectClass` VARCHAR(100) DEFAULT NULL,
  `objectId` int(12) unsigned,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idType` int(12) unsigned DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  `validatedEndDate` date DEFAULT NULL,
  `plannedEndDate`  date DEFAULT NULL,
  `realEndDate`  date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ==================================================================
-- Global Planning
-- ==================================================================

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(196,'menuGlobalPlanning', 7, 'item', 125, null, 0, 'Work');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,196,1),
(2,196,1),
(3,196,1),
(4,196,1);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES 
(1,196, 8),
(2,196, 2),
(3,196, 7),
(4,196, 7);

CREATE TABLE `${prefix}planningelementextension` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `topId` int(12) unsigned DEFAULT NULL,
  `topRefType` varchar(100) DEFAULT NULL,
  `topRefId` int(12) unsigned DEFAULT NULL,
  `wbs` varchar(100) DEFAULT NULL,
  `wbsSortable` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX planningelementextensionReference ON `${prefix}planningelementextension` (refType,refId);
CREATE INDEX planningelementextensionTopReference ON `${prefix}planningelementextension` (topRefType,topRefId);
CREATE INDEX planningelementextensionWbsSortable ON `${prefix}planningelementextension` (wbsSortable);

ALTER TABLE `${prefix}project`
ADD `excludeFromGlobalPlanning` int(1) UNSIGNED DEFAULT 0;

ALTER TABLE `${prefix}planningelementbaseline`
ADD `isGlobal` int(1) UNSIGNED DEFAULT 0,
ADD `idType` int(12) unsigned DEFAULT NULL,
ADD `idStatus` int(12) unsigned DEFAULT NULL,
ADD `idResource` int(12) unsigned DEFAULT NULL;

-- ==================================================================
-- Validation of timesheet for team
-- ==================================================================

CREATE TABLE `${prefix}accessscopespecific` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `accessCode` varchar(5) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}accessscopespecific` (`id`, `name`, `accessCode`, `sortOrder`, `idle`) VALUES
(1, 'accessScopeSpecificNo', 'NO', 100, 0),
(2, 'accessScopeSpecificOwn', 'OWN', 200, 0),
(3, 'accessScopeSpecificProject', 'PRO', 300, 0),
(4, 'accessScopeSpecificAll', 'ALL', 400, 0),
(6, 'accessScopeSpecificTeam', 'TEAM', 350, 0);

-- ==================================================================
-- Misc
-- ==================================================================

-- change caption for Meeting menu context
UPDATE `${prefix}menu`set menuClass=REPLACE(menuClass,'Meeting','Review') WHERE menuClass LIKE '%Meeting%';

-- manage milestones on activities
ALTER TABLE `${prefix}activity`
ADD `idMilestone` int(12) UNSIGNED DEFAULT NULL;

-- manage new configuration menu context
UPDATE `${prefix}menu` SET menuClass='Work Configuration EnvironmentalParameter' WHERE id in (86,87,141,142,179);

-- remove dojo editor
UPDATE `${prefix}parameter` set parameterValue='CK' where parameterValue='Dojo';
UPDATE `${prefix}parameter` set parameterValue='CKInline' where parameterValue='DojoInline';

-- Event for any status change 
INSERT INTO `${prefix}event`(`id`, `name`, `idle`, `sortOrder`) VALUES (14,'statusChange',0,100);

--- ==================================================================
--- Fix
--- ==================================================================

update `${prefix}planningelement` set plannedStartDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId) where refType = "Meeting";
update `${prefix}planningelement` set plannedEndDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId) where refType = "Meeting";
update `${prefix}planningelement` set validatedStartDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId) where refType = "Meeting";
update `${prefix}planningelement` set validatedEndDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId) where refType = "Meeting";

update `${prefix}planningelement` set realStartDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId and meet.handled=1) where refType = "Meeting";
update `${prefix}planningelement` set realEndDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId and meet.done=1) where refType = "Meeting";

update `${prefix}assignment` set plannedStartDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId) where refType = "Meeting";
update `${prefix}assignment` set plannedEndDate=(select meetingDate from `${prefix}meeting` as meet where meet.id=refId) where refType = "Meeting";
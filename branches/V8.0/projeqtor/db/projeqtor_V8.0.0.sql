-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.5.0                                       //
-- // Date : 2019-01-25                                     //
-- ///////////////////////////////////////////////////////////

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(204, 'menuImputationValidation', 7, 'item', 112, Null, 0, 'Work'),
(205, 'menuAutoSendReport', 7, 'item', 155, Null, 0, 'Work');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 204, 1),
(2, 204, 1),
(3, 204, 1),
(1, 205, 1),
(2, 205, 1),
(3, 205, 1),
(4, 205, 1),
(5, 205, 1),
(6, 205, 1),
(7, 205, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,204,8),
(1,205,8);

-- ///////////////////////////////////////////////////////////

-- LEAVE SYSTEM

-- to create the table leavessystemhabilitation
CREATE TABLE `${prefix}leavessystemhabilitation` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menuName` VARCHAR(100) NOT NULL,
  `viewAccess` VARCHAR(10) DEFAULT NULL,
  `readAccess` VARCHAR(10) DEFAULT NULL,
  `createAccess` VARCHAR(10) DEFAULT NULL,
  `updateAccess` VARCHAR(10) DEFAULT NULL,
  `deleteAccess` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = InnoDB, DEFAULT CHARSET=utf8;

-- to create the table leavetype
CREATE TABLE `${prefix}leavetype` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `idActivity` INT(12) UNSIGNED DEFAULT NULL,
  `idWorkflow` INT(12) UNSIGNED DEFAULT NULL,
  `color` VARCHAR(7) DEFAULT NULL,
  `notificationOnCreate` VARCHAR(255) DEFAULT NULL,
  `notificationOnUpdate` VARCHAR(255) DEFAULT NULL,
  `notificationOnDelete` VARCHAR(255) DEFAULT NULL,
  `notificationOnTreatment` VARCHAR(255) DEFAULT NULL,
  `alertOnCreate` VARCHAR(255) DEFAULT NULL,
  `alertOnUpdate` VARCHAR(255) DEFAULT NULL,
  `alertOnDelete` VARCHAR(255) DEFAULT NULL,
  `alertOnTreatment` VARCHAR(255) DEFAULT NULL,
  `emailOnCreate` VARCHAR(255) DEFAULT NULL,
  `emailOnUpdate` VARCHAR(255) DEFAULT NULL,
  `emailOnDelete` VARCHAR(255) DEFAULT NULL,
  `emailOnTreatment` VARCHAR(255) DEFAULT NULL,
  `idle` INT(1) UNSIGNED DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- to create the table employeeleaveearned
CREATE TABLE `${prefix}employeeleaveearned` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUser` INT(12) UNSIGNED DEFAULT NULL,
  `idEmployee` INT(12) UNSIGNED DEFAULT NULL,
  `idLeaveType` INT(12) UNSIGNED DEFAULT NULL,
  `startDate` DATE DEFAULT NULL,
  `endDate` DATE DEFAULT NULL,
  `lastUpdateDate` DATE DEFAULT NULL,
  `quantity` DECIMAL(4, 1) UNSIGNED DEFAULT NULL,
  `leftQuantity` DECIMAL(4, 1) DEFAULT NULL,
  `leftQuantityBeforeClose` DECIMAL(4, 1) DEFAULT NULL,
  `idle` INT(1) UNSIGNED DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- to create the table employeeleaveperiod
CREATE TABLE `${prefix}employeeleaveperiod` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `comment` VARCHAR(255) DEFAULT NULL,
  `startDate` DATE DEFAULT NULL,
  `startAMPM` VARCHAR(2) DEFAULT 'AM',
  `endDate` DATE DEFAULT NULL,
  `endAMPM` VARCHAR(2) DEFAULT 'PM',
  `idLeaveType` INT(12) UNSIGNED DEFAULT NULL,
  `idStatus` INT(12) UNSIGNED DEFAULT NULL,
  `idUser` INT(12) UNSIGNED DEFAULT NULL,
  `idEmployee` INT(12) UNSIGNED DEFAULT NULL,
  `requestDateTime` DATETIME DEFAULT NULL,
  `idResource` INT(12) UNSIGNED DEFAULT NULL,
  `processingDateTime` DATETIME DEFAULT NULL,
  `nbDays` DECIMAL(4, 1) UNSIGNED DEFAULT NULL,
  `submitted` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `rejected` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `accepted` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `statusOutOfWorkflow` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `statusSetLeaveChange` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- to create the table employmentContractType
CREATE TABLE `${prefix}employmentcontracttype` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `name` VARCHAR(100) NOT NULL,
  `idRecipient` INT(12) UNSIGNED DEFAULT NULL,
  `idWorkflow` INT(12) UNSIGNED DEFAULT NULL,
  `idManagementType` INT(12) UNSIGNED DEFAULT NULL,
  `isDefault` INT(1) UNSIGNED NOT NULL DEFAULT 0,  
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- to create the table leaveTypeOfEmploymentContractType
CREATE TABLE `${prefix}leaveTypeOfEmploymentContractType` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `idEmploymentContractType` INT(12) UNSIGNED DEFAULT NULL,
  `idLeaveType` INT(12) UNSIGNED DEFAULT NULL,
  `startMonthPeriod` VARCHAR(2) DEFAULT NULL,
  `startDayPeriod` VARCHAR(2) DEFAULT NULL,
  `periodDuration` INT(5) UNSIGNED DEFAULT NULL,
  `quantity` DECIMAL(4, 1) UNSIGNED DEFAULT NULL,
  `isIntegerQuotity` INT(1) UNSIGNED DEFAULT 0,
  `earnedPeriod` INT(5) UNSIGNED DEFAULT NULL,
  `isUnpayedAllowed` INT(1) UNSIGNED DEFAULT 0,
  `isJustifiable` INT(1) UNSIGNED DEFAULT 0,
  `isAnticipated` INT(1) UNSIGNED DEFAULT 0,
  `validityDuration` INT(5) UNSIGNED DEFAULT 12,
  `nbDaysAfterNowLeaveDemandIsAllowed` INT(5) UNSIGNED DEFAULT NULL,
  `nbDaysBeforeNowLeaveDemandIsAllowed` INT(5) UNSIGNED DEFAULT NULL,  
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- to create the table customEarnedRulesOfEmploymentContractType
CREATE TABLE `${prefix}customearnedrulesofemploymentcontracttype` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `name` VARCHAR(100) DEFAULT NULL,
  `rule` VARCHAR(4000) DEFAULT NULL,
  `whereClause` VARCHAR(4000) DEFAULT NULL,
  `idEmploymentContractType` INT(12) UNSIGNED DEFAULT NULL,
  `idLeaveType` INT(12) UNSIGNED DEFAULT NULL,
  `quantity` DECIMAL(4,1) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--to create the table employmentContractEndReason
CREATE TABLE `${prefix}employmentcontractendreason` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `final` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--to create the table employmentContract
CREATE TABLE `${prefix}employmentcontract` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUser` INT(12) UNSIGNED DEFAULT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `startDate` DATE DEFAULT NULL,
  `endDate` DATE DEFAULT NULL,
  `mission` LONGTEXT DEFAULT NULL,
  `idEmployee` INT(12) UNSIGNED DEFAULT NULL,
  `idEmploymentContractType` INT(12) UNSIGNED DEFAULT NULL,
  `idStatus` INT(12) UNSIGNED DEFAULT NULL,
  `idEmploymentContractEndReason` INT(12) UNSIGNED DEFAULT NULL,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--to create the table employeesManaged
CREATE TABLE `${prefix}employeesmanaged` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEmployeeManager` INT(12) UNSIGNED DEFAULT NULL,
  `idEmployee` INT(12) UNSIGNED DEFAULT NULL,
  `startDate` DATE DEFAULT NULL,
  `endDate` DATE DEFAULT NULL,
  `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


--to create the table RulableForEmpContractType
CREATE TABLE `${prefix}rulableforempcontracttype` (
    `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
    `rulableItem` VARCHAR(100) DEFAULT NULL,
    `name` VARCHAR(100) DEFAULT NULL,
    `idle` INT(1) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- to create the table
CREATE TABLE `${prefix}calendarbankoffdays` (
    `id` INT(12) NOT NULL AUTO_INCREMENT,
    `idCalendarDefinition` INT(12) UNSIGNED DEFAULT NULL,
    `name` VARCHAR(100) DEFAULT NULL,
    `month` INT(2) DEFAULT NULL,
    `day` INT(2) DEFAULT NULL,
    `easterDay` INT(2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}cronautosendreport` (
    `id` INT(12) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) DEFAULT NULL,
    `idReport` INT(12) DEFAULT NULL,
    `idResource` INT(12) DEFAULT NULL,
    `idReceiver` INT(12) DEFAULT NULL,
		`idle` INT(1) DEFAULT NULL,
		`sendFrequency` varchar(100) DEFAULT NULL,
		`otherReceiver` varchar(500) DEFAULT NULL,
		`cron` varchar(100) DEFAULT NULL,
		`nextTime` varchar(100) DEFAULT NULL,
		`reportParameter` varchar(500) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- to add the dayOfWeek columns to the table calendardefinition
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek0` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek1` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek2` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek3` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek4` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek5` int(1) UNSIGNED DEFAULT 0;
ALTER TABLE `${prefix}calendardefinition` ADD `dayOfWeek6` int(1) UNSIGNED DEFAULT 0;

-- to add the column isEmployee to the table resource
ALTER TABLE `${prefix}resource` ADD `isEmployee` int(1) UNSIGNED DEFAULT 0;
-- to add the column isEmployee to the table resource
ALTER TABLE `${prefix}resource` ADD `isLeaveManager` int(1) UNSIGNED DEFAULT 0;

-- to add the column isLeaveMngProject dans la table project
ALTER TABLE `${prefix}project` ADD `isLeaveMngProject` int(1) UNSIGNED DEFAULT 0;

--add a column idLeave in the table work
ALTER TABLE `${prefix}work` ADD `idLeave` int(12) UNSIGNED DEFAULT NULL;

--add a column idLeave in the table plannedwork
ALTER TABLE `${prefix}plannedwork` ADD `idLeave` int(12) UNSIGNED DEFAULT NULL;

--add a column isLeavesSystemMenu in the table menu
ALTER TABLE `${prefix}menu` ADD `isLeavesSystemMenu` INT(1) DEFAULT 0;

--add columns setSubmittedLeave, setValidatedLeave, setRejectedLeave in the table status
ALTER TABLE `${prefix}status` ADD `setSubmittedLeave` INT(1) DEFAULT 0;
ALTER TABLE `${prefix}status` ADD `setAcceptedLeave` INT(1) DEFAULT 0;
ALTER TABLE `${prefix}status` ADD `setRejectedLeave` INT(1) DEFAULT 0;

-- to update sortOrder of existing menus that are'nt Leave System menu
UPDATE `${prefix}menu` set `sortOrder` = (`sortOrder`+20) where `isLeavesSystemMenu`=0;

--to insert HumanResource in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(208,'menuHumanResource', 0, 'menu', 0, null, 1, 'Human', 1);

--to insert LeaveCalendar in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(209,'menuLeaveCalendar', 208, 'item', 1, null, 0, 'Leave', 1);

-- to insert the Leave in Menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(210, 'menuLeave', 208, 'object', 2, null, 0, 'Leave', 1);

--to insert employeeLeaveEarned in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(211, 'menuEmployeeLeaveEarned', 208, 'object', 3, null, 0, 'EmployeeLeaveEarned', 1);

-- to insert the Employee in Menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(212, 'menuEmployee', 208, 'object', 4, null, 0, 'Leave', 1);

--to insert employmentContract in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(213, 'menuEmploymentContract', 208, 'object', 5, null, 0, 'EmploymentContract', 1);

--to insert employeeManager in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(214, 'menuEmployeeManager', 208, 'object', 6, null, 0, 'EmployeeManagement', 1);

--to insert dashboardEmployeeManager in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(215, 'menuDashboardEmployeeManager', 208, 'item', 7, null, 0, 'EmployeeManagement', 1);

--to insert HumanResourceParameters in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(216,'menuHumanResourceParameters', 208, 'menu', 8, null, 1, 'HumanParam', 1);

--to insert LeaveType in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(217, 'menuLeaveType', 216, 'object', 9, null, 0, 'LeaveType', 1);

--to insert contractType in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(218, 'menuEmploymentContractType', 216, 'object', 10, null, 0, 'EmploymentContractType', 1);

--to insert employmentContractEndReason in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(219, 'menuEmploymentContractEndReason', 216, 'object', 11, null, 0, 'EmploymentContract', 1);

--to insert leavesSystemHabilitation in menu
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`, `isLeavesSystemMenu`) VALUES
(220, 'menuLeavesSystemHabilitation', 216, 'item', 12, null, 0, 'HumanParam', 1);

-- to insert default LeavesSystemHabilitation
INSERT INTO `${prefix}leavessystemhabilitation`(`id`, `menuName`, `viewAccess`, `readAccess`, `createAccess`, `updateAccess`, `deleteAccess`) VALUES
(1, 'menuHumanResource', 'AME', NULL, NULL, NULL, NULL),
(2, 'menuHumanResourceParameters', 'AME', NULL, NULL, NULL, NULL),
(3, 'menuLeavesSystemHabilitation', 'A', 'A', 'A', 'A', 'A'),
(4, 'menuEmploymentContractType', 'AM', 'AM', 'AM', 'AM', 'AM'),
(5, 'menuLeaveCalendar', 'E', NULL, NULL, NULL, NULL),
(6, 'menuLeaveType', 'A', 'A', 'A', 'A', 'A'),
(7, 'menuLeave', 'E', 'AmO', 'E', 'AmO', 'AmO'),
(8, 'menuEmployee', 'AME', 'AmO', '', 'AmO', ''),
(9, 'menuEmploymentContract', 'AME', 'AmO', 'AM', 'AmO', 'A'),
(10, 'menuEmployeeLeaveEarned', 'E', 'AMO', 'AM', 'AM', 'AM'),
(11, 'menuEmploymentContractEndReason', 'A', 'A', 'A', 'A', 'A'),
(12, 'menuLeaveTypeOfEmploymentContractType', 'A', 'A', 'A', 'A', 'A'),
(13, 'menuEmployeeManager', 'AM', 'AMO', 'AM', 'AM', 'AO'),
(14, 'menuDelegationManager', 'AM', 'AME', 'AO', 'AO', 'AO'),
(15, 'menuDashboardEmployeeManager', 'Am', NULL, NULL, NULL, NULL);

-- to insert the parameter leavesSystemActiv in the table parameter
INSERT INTO `${prefix}parameter` (`parameterCode`,`parameterValue`) VALUES ('leavesSystemActiv', 'NO');

-- to insert the parameter leavesSystemAdmin in the table parameter
INSERT INTO `${prefix}parameter` (`parameterCode`,`parameterValue`) VALUES ('leavesSystemAdmin', 1);

-- to insert the parameter typeExportXLSorODS in the table parameter
INSERT INTO `${prefix}parameter` (`parameterCode`,`parameterValue`) VALUES ('typeExportXLSorODS', 'Excel');

--to insert the rulable classes in rulableforempcontracttype
INSERT INTO `${prefix}rulableforempcontracttype` (`rulableItem`,`name`,`idle`) VALUES
    ('Employee','Employee',0),
    ('EmploymentContract','EmploymentContract',0),
    ('EmployeeLeaveEarned','EmployeeLeaveEarned',0),
    ('Leave','Leave',0);

--to insert the notifiable
INSERT INTO `${prefix}notifiable` (`notifiableItem`,`name`,`idle`) VALUES
    ('Leave','Leave',0),
    ('EmployeeLeaveEarned','Leave Earned',0),
    ('Workflow','Workflow',0),
    ('Status', 'Status',0),
    ('LeaveType', 'Leave Type',0);
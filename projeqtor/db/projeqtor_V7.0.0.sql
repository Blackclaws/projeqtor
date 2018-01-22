-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.0.0                                       //
-- // Date : 2017-12-22                                     //
-- ///////////////////////////////////////////////////////////

-- begin add gmartin /handle email Template
 
CREATE TABLE `${prefix}emailtemplate` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `template` mediumtext DEFAULT NULL,
  `idMailable` int(12) DEFAULT NULL,
  `idType` int(12) UNSIGNED DEFAULT NULL,
  `idle` int(1) UNSIGNED DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
CREATE INDEX `emailtemplateMailable` ON `${prefix}emailtemplate` (`idMailable`);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(305,'menuEmailTemplate', 88, 'object', 585, 'ReadWriteEnvironment', 0, 'Automation');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 305, 1);

ALTER TABLE `${prefix}statusmail`
ADD `idEmailTemplate` int(12) UNSIGNED DEFAULT NULL;

-- end add gmartin 


-- ======================================================== --
--                      PARAMETERS                          --
-- ======================================================== --
-- -------------------------------------------------------- --
--                   notificationSystemActiv                --
-- Indicates if the notification system is activ or not     --
-- -------------------------------------------------------- --
INSERT INTO `${prefix}parameter` (`idUser`,`idProject`,`parameterCode`,`parameterValue`) 
VALUES (NULL,NULL,'notificationSystemActiv','NO');
-- -------------------------------------------------------- --
--                   cronCheckNotification                  --
-- Interval in hours of notifications generation            --
-- -------------------------------------------------------- --
INSERT INTO `${prefix}parameter` (`idUser`,`idProject`,`parameterCode`,`parameterValue`)
VALUES (NULL,NULL,'cronCheckNotifications',3600);
-- ======================================================== --


-- ======================================================== --
--                      NEW TABLES                          --
-- -------------------------------------------------------- --
--                   NOTIFICATIONSTATUS                     --
-- This table contents the status for the notifications     --
-- -------------------------------------------------------- --
CREATE TABLE `${prefix}statusnotification` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) DEFAULT NULL,
  `color` VARCHAR(7) DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = INNODB DEFAULT CHARSET=utf8;
INSERT INTO `${prefix}statusnotification` (`id`, `name`, `color`) VALUES(1, 'unread', '#ff7f50');
INSERT INTO `${prefix}statusnotification` (`id`, `name`, `color`) VALUES(2, 'read',   '#32CD32');
-- -------------------------------------------------------- --
--                   NOTIFICATION                           --
-- This table contents the notifications generated          --
-- by the CRON or created by the user                       --
-- -------------------------------------------------------- --
CREATE TABLE `${prefix}notification` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) DEFAULT NULL,
  `idNotificationDefinition` INT(12) UNSIGNED DEFAULT NULL,
  `idNotifiable` INT(12) UNSIGNED DEFAULT NULL,
  `idMenu` INT(12) UNSIGNED DEFAULT NULL,
  `idNotificationType` INT(12) UNSIGNED DEFAULT NULL,
  `idUser` INT(12) UNSIGNED DEFAULT NULL COMMENT 'notification''s sender',
  `idResource` INT(12) UNSIGNED DEFAULT NULL COMMENT 'Resource to whom the notification is intended',
  `idStatusNotification` INT(12) UNSIGNED DEFAULT NULL,  
  `title` VARCHAR(4000) DEFAULT NULL,
  `content` MEDIUMTEXT DEFAULT NULL,
  `creationDateTime` DATETIME DEFAULT NULL,
  `notificationDate` DATE DEFAULT NULL,
  `notifiedObjectId` INT(12) UNSIGNED DEFAULT NULL,
  `sendEmail` INT(1) NOT NULL DEFAULT 0,
  `emailSent` INT(1) NOT NULL DEFAULT 0,
  `idle` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `hasNotificationDefinition_idx` (`idNotificationDefinition`),
  INDEX `hasNotifiable_idx` (`idNotifiable`),
  INDEX `hasStatus_idx` (`idStatusNotification`),
  INDEX `hasType_idx` (`idNotificationType`),
  INDEX `isBubbledInMenu_idx` (`idMenu`),
  INDEX `isForResource_idx` (`idResource`)
)
ENGINE = INNODB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------- --
--                   NOTIFICATIONDEFINITION                 --
-- This table contents the rules for the generation of      --
-- notifications by the Cron or when something change on    --
-- NotificationDefinition                                   --
-- -------------------------------------------------------- --
CREATE TABLE `${prefix}notificationdefinition` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) DEFAULT NULL,
  `idNotifiable` INT(12) UNSIGNED DEFAULT NULL,
  `idMenu` INT(12) UNSIGNED DEFAULT NULL,
  `idNotificationType` INT(12) UNSIGNED DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `content` MEDIUMTEXT DEFAULT NULL,
  `notificationRule` VARCHAR(400) DEFAULT NULL,
  `notificationReceivers` VARCHAR(400) DEFAULT NULL,
  `sendEmail` INT(1) NOT NULL DEFAULT 0,
  `targetDateNotifiableField` VARCHAR(100) DEFAULT NULL,
  `everyMonth` INT(1) NOT NULL DEFAULT 0,
  `everyYear` INT(1) NOT NULL DEFAULT 0,
  `fixedDay` INT(5) DEFAULT NULL,
  `fixedMonth` INT(5) DEFAULT NULL,
  `notificationDaysBefore` INT(5) DEFAULT NULL,
  `idle` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `hasNotifiable_idx` (`idNotifiable`),
  INDEX `hasType_idx` (`idNotificationType`),
  INDEX `isBubbledInMenu_idx` (`idMenu`)
)
ENGINE = INNODB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------- --
--                          NOTIFIABLE                      --
-- This table contents the classes of Projeqtor those can   --
-- be selected for define generation notification rules     --
-- -------------------------------------------------------- --
CREATE TABLE `${prefix}notifiable` (
  `id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `notifiableItem` VARCHAR(100) DEFAULT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `idle` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
ENGINE = INNODB DEFAULT CHARSET=utf8;

INSERT INTO `${prefix}notifiable` (`notifiableItem`,`name`) VALUES
 ('Action','Action'),
 ('Activity','Activity'),
 ('Bill','Bill'),
 ('Command','Command'),
 ('Deliverable','Deliverable'),
 ('Incoming','Incoming'),
 ('Issue','Issue'),
 ('Meeting','Meeting'),
 ('Milestone','Milestone'),
 ('Opportunity','Opportunity'),
 ('ProjectExpense','ProjectExpense'),
 ('Quotation','Quotation'),
 ('Requirement','Requirement'),
 ('Risk','Risk'),
 ('Ticket','Ticket'),
 ('Term','Term'),
 ('Delivery','Delivery');

-- ======================================================== --
--                         MENU                             --
-- ======================================================== --
-- -------------------------------------------------------- --
--                       For notification                   --
-- -------------------------------------------------------- --
INSERT INTO `${prefix}menu` (`id`, `name`,           `idMenu`,`type`,  `sortOrder`,`level`,  `idle`,`menuClass`) 
                      VALUES(301, 'menuNotification', 11,     'object', 431,       'Project', 0,    'Admin Notification');
-- -------------------------------------------------------- --
--                    For notificationDefinition            --
-- -------------------------------------------------------- --
INSERT INTO `${prefix}menu` (`id`,`name`,                     `idMenu`,`type`,  `sortOrder`,`level`,               `idle`,`menuClass`) 
                      VALUES(302, 'menuNotificationDefinition',88,    'object', 672,       'ReadWriteEnvironment', 0,     'Automation Notification');

-- ======================================================== --
--                     HABILITATION                         --
-- ======================================================== --
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 1,           301,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 1,           302,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 2,           301,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 3,           301,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 4,           301,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 5,           301,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 6,           301,    1);
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`,`allowAccess`) 
                             VALUES( 7,           301,    1);

-- ======================================================== --
--                     ACCESS RIGHT                         --
-- ======================================================== --
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 1,           301,    8);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 2,           301,    3);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 3,           301,    3);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 4,           301,    3);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 5,           301,    3);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 6,           301,    3);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 7,           301,    3);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 1,           302,    1000001);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 2,           302,    1000002);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 3,           302,    1000002);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 4,           302,    1000002);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 5,           302,    1000002);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 6,           302,    1000002);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`,`idAccessProfile`) 
                             VALUES( 7,           302,    1000002);

INSERT INTO `${prefix}type` (`name`, `scope`, `color`, `sortOrder`) VALUES 
 ('ALERT', 'Notification', '#ff0000', '10'),
 ('WARNING', 'Notification', '#ffa500', '20'),
 ('INFO', 'Notification', '#0000ff', '30');
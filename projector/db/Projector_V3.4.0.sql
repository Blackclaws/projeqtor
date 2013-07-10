
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.4.0                                      //
-- // Date : 2013-05-06                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'realWorkOnlyForResponsible', 'NO');

ALTER TABLE `${prefix}type` ADD COLUMN `description` varchar(4000);

ALTER TABLE `${prefix}expensedetailtype` ADD COLUMN `description` varchar(4000);

ALTER TABLE `${prefix}contexttype` ADD COLUMN `description` varchar(4000);

ALTER TABLE `${prefix}mail` CHANGE mailBody mailBody text;

ALTER TABLE `${prefix}note` ADD COLUMN `fromEmail` int(1) unsigned DEFAULT '0';

ALTER TABLE `${prefix}meeting` ADD COLUMN `idPeriodicMeeting` int(12) unsigned DEFAULT NULL,
ADD COLUMN `isPeriodic` int(1) unsigned DEFAULT '0',
ADD COLUMN `periodicOccurence` int(3) unsigned DEFAULT NULL;
CREATE INDEX meetingPeriodicMeeting ON `${prefix}meeting` (idPeriodicMeeting);

CREATE TABLE `${prefix}periodicmeeting` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idMeetingType` int(12) unsigned DEFAULT NULL,
  `idActivity` int(12) unsigned DEFAULT NULL,
  `periodicityStartDate` date DEFAULT NULL,
  `periodicityEndDate` date DEFAULT NULL,
  `meetingStartTime` time DEFAULT NULL,
  `meetingEndTime` time DEFAULT NULL,
  `periodicityTimes` int(3) DEFAULT NULL,
  `idPeriodicity` int(12) unsigned DEFAULT NULL,
  `periodicityFrequency` int(2) default NULL,
  `periodicityOpenDays` int(1) unsigned default NULL,
  `periodicityMonthlyWeeklyNumber` int(1) unsigned default NULL,
  `weeklyPeriodicityMonday` int(1) unsigned default NULL,
  `weeklyPeriodicityTuesday` int(1) unsigned default NULL,
  `weeklyPeriodicityWednesday` int(1) unsigned default NULL,
  `weeklyPeriodicityThursday` int(1) unsigned default NULL,
  `weeklyPeriodicityFriday` int(1) unsigned default NULL,
  `weeklyPeriodicitySaturday` int(1) unsigned default NULL,
  `weeklyPeriodicitySunday` int(1) unsigned default NULL,  
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` VARCHAR(4000),
  `attendees` varchar(4000) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
CREATE INDEX periodicmeetingProject ON `${prefix}periodicmeeting` (idProject);
CREATE INDEX periodicmeetingType ON `${prefix}periodicmeeting` (idMeetingType);
CREATE INDEX periodicmeetingUser ON `${prefix}periodicmeeting` (idUser);
CREATE INDEX periodicmeetingResource ON `${prefix}periodicmeeting` (idResource);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'maxDaysToBookWork', '7');

ALTER TABLE `${prefix}indicatordefinition` ADD COLUMN `mailToAssigned` int(1) unsigned default 0,
ADD COLUMN `mailToManager` int(1) unsigned default 0,
ADD COLUMN `otherMail` varchar(4000) DEFAULT NULL,
ADD COLUMN `alertToAssigned` int(1) unsigned default 0,
ADD COLUMN `alertToManager` int(1) unsigned default 0;
  
INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'cronCheckEmails', '-1');

INSERT INTO `${prefix}linkable` (`id`, `name`, `idDefaultLinkable`, `idle`) VALUES
(16, 'ProjectExpense', 8, 0); 

ALTER TABLE `${prefix}planningelement` CHANGE  `expectedProgress` `expectedProgress` int(6) unsigned default '0';

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(124,'menuPeriodicMeeting',6,'object',465,'Project',0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) 
SELECT `idProfile`, 124, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=62;  

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 124, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=62;  

INSERT INTO `${prefix}linkable` (`id`, `name`, `idDefaultLinkable`, `idle`) VALUES
(17, 'Opportunity', 1, 0); 
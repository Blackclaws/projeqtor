
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
ADD COMUMN `isPeriodic` int(1) unsigned DEFAULT '0',
ADD COMUMN `periodicOccurence` int(3) unsigned DEFAULT NULL;
CREATE INDEX meetingPeriodicMeeting ON `${prefix}meeting` (idPeriodicMeeting);

CREATE TABLE `${prefix}periodicmeeting` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idMeetingType` int(12) unsigned DEFAULT NULL,
  `periodicityStartDate` date DEFAULT NULL,
  `periodicityEndDate` date DEFAULT NULL,
  `periodicityTimes` date DEFAULT NULL,
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
  `description` VARCHAR(4000);
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
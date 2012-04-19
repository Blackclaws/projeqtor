
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.2.0                                      //
-- // Date : 2012-04-12                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`) VALUES
(7,'Ticket',0),
(8,'Activity',0);
INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`) VALUES
(9,'Milestone',0);
INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`) VALUES
(10,'Document',0);

ALTER TABLE `${prefix}link` ADD COLUMN `comment` varchar(4000), 
ADD COLUMN `creationDate` datetime, 
ADD COLUMN `idUser` int(12) unsigned default null;

ALTER TABLE `${prefix}attachement` ADD COLUMN `link` varchar(400),
ADD COLUMN `type` varchar(10) default 'file';


INSERT INTO `${prefix}indicator` (`id`, `code`, `type`, `name`, `sortOrder`, `idle`) VALUES
(15, 'RWOVW', 'percent', 'RealWorkOverValidatedWork', 250, 0),
(16, 'RWOAW', 'percent', 'RealWorkOverAssignedWork', 260, 0);
  
INSERT INTO `${prefix}indicatorableindicator` (`idIndicator`, `idIndicatorable`, `nameIndicatorable`, `idle`) VALUES
(15, 2, 'Activity',0),
(15, 8, 'Project',0),
(16, 2, 'Activity',0),
(16, 8, 'Project',0);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'maxProjectsToDisplay','25');

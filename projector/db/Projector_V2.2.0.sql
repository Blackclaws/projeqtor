
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

ALTER TABLE `${prefix}attachment` ADD COLUMN `link` varchar(400);
 
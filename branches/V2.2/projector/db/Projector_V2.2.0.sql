
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
--INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`) VALUES
--(11,'DocumentVersion',0);

ALTER TABLE `${prefix}link` ADD COLUMN `comment`  varchar(4000);



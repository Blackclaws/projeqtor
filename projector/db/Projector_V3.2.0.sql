
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.2.0                                      //
-- // Date : 2012-12-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}opportunity` ADD COLUMN `idPriority` int(12) unsigned;
ALTER TABLE `${prefix}risk` ADD COLUMN `idPriority` int(12) unsigned;

INSERT INTO `${prefix}importable` (`id`, `name`, `idle`) VALUES
(26, 'Opportunity', 0);

INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`, idDefaultLinkable) VALUES
(15,'IndividualExpense',0,4);
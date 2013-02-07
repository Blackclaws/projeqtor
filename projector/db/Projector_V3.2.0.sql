
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
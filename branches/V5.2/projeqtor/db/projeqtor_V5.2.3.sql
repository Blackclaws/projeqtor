-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.2.3                                       //
-- // Date : 2016-01-28                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}activity` CHANGE `idContact` `idContact` int(12) unsigned;

ALTER TABLE `${prefix}menu` CHANGE `sortOrder` `sortOrder` int(5) unsigned;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(143, 'menuPlugin', null, 'menu', 9000, null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) select `idProfile`, 143, `allowAccess` from `${prefix}habilitation` sourceHab where sourceHab.idMenu=136;

UPDATE `${prefix}menu` set sortOrder=9010, idMenu=143, name='menuPluginManagement' where id=136;
UPDATE `${prefix}menu` set sortOrder=sortOrder+9000, idMenu=143 where id > 100000000;

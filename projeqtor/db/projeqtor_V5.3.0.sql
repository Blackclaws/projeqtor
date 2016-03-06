-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.3.0                                       //
-- // Date : 2016-02-01                                     //
-- ///////////////////////////////////////////////////////////

-- Product type and component type
INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(144, 'menuProductType', 79, 'object', 930, 'ReadWriteType', 0, 'Type '),
(145, 'menuComponentType', 79, 'object', 932, 'ReadWriteType', 0, 'Type ');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 144, 1),
(2, 144, 0),
(3, 144, 0),
(4, 144, 0),
(5, 144, 0),
(6, 144, 0),
(7, 144, 0),
(1, 145, 1),
(2, 145, 0),
(3, 145, 0),
(4, 145, 0),
(5, 145, 0),
(6, 145, 0),
(7, 145, 0);
INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `idWorkflow`, `mandatoryDescription`, `mandatoryResultOnDone`, `mandatoryResourceOnHandled`, `lockHandled`, `lockDone`, `lockIdle`, `code`) VALUES 
('Product', 'software', '10', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Product', 'service', '20', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Component', 'specific', '10', '0', '1', '0', '0', '0', '0', '0', '0', ''),
('Component', 'on the shelf', '20', '0', '1', '0', '0', '0', '0', '0', '0', '');
ALTER TABLE `${prefix}product` ADD `idProductType` int(12) unsigned DEFAULT NULL;
ALTER TABLE `${prefix}product` ADD `idComponentType` int(12) unsigned DEFAULT NULL;

-- Version name formatting
ALTER TABLE `${prefix}version` ADD `versionNumber` varchar(100) DEFAULT NULL;

-- Financial Gallery
INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `menuClass`) VALUES (146,'menuGallery', 74, 'item', 285, 'Financial');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 146, 1),
(2, 146, 1),
(3, 146, 1),
(4, 146, 0),
(5, 146, 0),
(6, 146, 0),
(7, 146, 0);

ALTER TABLE `${prefix}ticket` ADD `idComponent` int(12) unsigned DEFAULT NULL;
ALTER TABLE `${prefix}activity` ADD `idComponent` int(12) unsigned DEFAULT NULL;
ALTER TABLE `${prefix}activity` ADD `idProduct` int(12) unsigned DEFAULT NULL;

UPDATE `${prefix}ticket` SET `idComponent`=`idProduct`, `idProduct`=null
WHERE `idProduct` in (SELECT id from `${prefix}product` WHERE `scope`='Component');
UPDATE `${prefix}activity` SET `idComponent`=`idProduct`, `idProduct`=null
WHERE `idProduct` in (SELECT id from `${prefix}product` WHERE `scope`='Component');


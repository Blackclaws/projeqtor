-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.2.0                                       //
-- // Date : 2017-03-10                                    //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}type` ADD `priority` int(3) unsigned DEFAULT NULL;

CREATE TABLE `${prefix}subscription` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idAffectable` int(12) unsigned DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `subscriptionAffectable` ON `${prefix}subscription` (`idAffectable`);
CREATE INDEX `subscriptionReference` ON `${prefix}subscription` (`refType`,`refId`);

INSERT INTO `${prefix}checklistable` (`id`, `name`, `idle`) VALUES 
(17, 'ProductVersion', '0'),
(18, 'ComponentVersion', '0'),
(19, 'Meeting', '0');

INSERT INTO `${prefix}linkable` (`id`, `name`, `idle`, `idDefaultLinkable`) VALUES 
(23, 'Bill', '0', '18');

INSERT INTO `${prefix}linkable` (`id`, `name`, `idle`, `idDefaultLinkable`) VALUES 
(24, 'Term', '0', '23');

INSERT INTO `${prefix}habilitationother` (idProfile,scope,rightAccess) VALUES 
(1,'subscription','4'),
(3,'subscription','3');

ALTER TABLE `${prefix}accessscope` ADD `specific` int(1) unsigned DEFAULT 1;
ALTER TABLE `${prefix}accessscope` ADD `nameSpecific` varchar(100) DEFAULT null;
UPDATE `${prefix}accessscope` set `specific`=0 WHERE accessCode='RES';
UPDATE `${prefix}accessscope` set `nameSpecific`=replace(`name`,'accessScope','accessScopeSpecific') WHERE `specific`=1;
UPDATE `${prefix}habilitationother` set `rightAccess`=2 WHERE `rightAccess`=5 and `scope` in ('imputation','workValid','diary');

ALTER TABLE `${prefix}statusmail` ADD `mailToSubscribers` int(1) unsigned DEFAULT 0;

ALTER TABLE `${prefix}indicatordefinition` ADD `mailToSubscribers` int(1) unsigned DEFAULT 0,
ADD `alertToSubscribers` int(1) unsigned DEFAULT 0;
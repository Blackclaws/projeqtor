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
  `creationDate` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `subscriptionAffectable` ON `${prefix}subscription` (`idAffectable`);
CREATE INDEX `subscriptionReference` ON `${prefix}subscription` (`refType`,`refId`);
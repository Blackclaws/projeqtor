-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.2.0                                       //
-- // Date : 2014-01-11                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}resource` ADD COLUMN `cookieHash` varchar(400) null,
ADD COLUMN `passwordChangeDate` date DEFAULT NULL;

CREATE TABLE `${prefix}checklistdefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `idReferencable` int(12) unsigned DEFAULT NULL,
  `idType` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE INDEX checklistdefinitionReferencable ON `${prefix}checklistdefinition` (idReferencable);

CREATE TABLE `${prefix}checklistdefinitionline` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idChecklistDefinition` int(12) unsigned DEFAULT NULL,
  `name` varchar(100),
  `check01` varchar(100) DEFAULT NULL,
  `check02` varchar(100) DEFAULT NULL,
  `check03` varchar(100) DEFAULT NULL,
  `check04` varchar(100) DEFAULT NULL,
  `check05` varchar(100) DEFAULT NULL,
  `exclusive` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
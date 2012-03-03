
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.1.0                                      //
-- // Date : 2012-02-26                                     //
-- ///////////////////////////////////////////////////////////
--
--

ALTER TABLE `${prefix}planningelement` CHANGE initialWork initialWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE validatedWork validatedWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE plannedWork plannedWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE realWork realWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE assignedWork assignedWork DECIMAL(14,5) UNSIGNED DEFAULT '0',
 CHANGE leftWork leftWork DECIMAL(14,5) UNSIGNED DEFAULT '0';
 
ALTER TABLE `${prefix}product` ADD COLUMN `idProduct`  int(12) unsigned DEFAULT NULL;

--ALTER TABLE `${prefix}ticket` ADD COLUMN `plannedWork`  DECIMAL(6,2) unsigned default 0,
--ADD COLUMN `realWork`  DECIMAL(6,2) unsigned DEFAULT 0;

ALTER TABLE `${prefix}ticket` ADD COLUMN `idTicket` int(12) unsigned DEFAULT NULL;

CREATE TABLE `${prefix}workelement` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL,
  `refName` varchar(100) DEFAULT NULL,
  `plannedWork`  DECIMAL(6,2) unsigned default 0,
  `realWork`  DECIMAL(6,2) unsigned DEFAULT 0,
  `leftWork`  DECIMAL(6,2) unsigned DEFAULT 0,
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}workelement` ADD INDEX workelementReference (refType, refId);

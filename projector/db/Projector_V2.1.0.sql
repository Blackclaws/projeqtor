
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

ALTER TABLE `${prefix}ticket` ADD COLUMN `plannedWork`  DECIMAL(6,2) unsigned default 0,
ADD COLUMN `realWork`  DECIMAL(6,2) unsigned DEFAULT 0;

ALTER TABLE `${prefix}ticket` ADD COLUMN `idTicket` int(12) unsigned DEFAULT NULL;

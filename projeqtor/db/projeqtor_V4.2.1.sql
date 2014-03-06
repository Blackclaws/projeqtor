-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.2.1                                       //
-- // Date : 2014-03-06                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}quotation` ADD `idContact` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}quotation` CHANGE `creationDate` `creationDate` date DEFAULT NULL;

ALTER TABLE `${prefix}command` ADD `idContact` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}command` CHANGE `creationDate` `creationDate` date DEFAULT NULL;
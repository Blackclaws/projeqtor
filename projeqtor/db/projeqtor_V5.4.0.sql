-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.4.0                                       //
-- // Date : 2016-05-12                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}assignment` CHANGE `dailyCost` `dailyCost` NUMERIC(9,2) DEFAULT null,
CHANGE `newDailyCost` `newDailyCost` NUMERIC(9,2) DEFAULT null;
ALTER TABLE `${prefix}expense` ADD `idDocument` int(12) unsigned;
ALTER TABLE `${prefix}filter` ADD `isShared` int(1) unsigned;
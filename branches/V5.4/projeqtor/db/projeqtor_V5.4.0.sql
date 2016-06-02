-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.4.0                                       //
-- // Date : 2016-05-12                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}assignment` CHANGE `dailyCost` `dailyCost` DECIMAL(9,2) UNSIGNED,
CHANGE `newDailyCost` `newDailyCost` DECIMAL(9,2) UNSIGNED;
ALTER TABLE `${prefix}billline` CHANGE `quantity` `quantity` DECIMAL(9,2) UNSIGNED;
ALTER TABLE `${prefix}expense` ADD `idDocument` int(12) unsigned;
ALTER TABLE `${prefix}filter` ADD `isShared` int(1) unsigned;
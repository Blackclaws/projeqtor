-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.2.0                                       //
-- // Date : 2015-12-04                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}projecthistory` CHANGE `realWork` `realWork` decimal(14,5) unsigned,
 CHANGE `leftWork` `leftWork` decimal(14,5) unsigned;

DELETE FROM `${prefix}indicatorableindicator` WHERE `idIndicatorable`=11;
DELETE FROM `${prefix}indicatorable` WHERE id=11;
DELETE FROM `${prefix}indicatorableindicator` WHERE `idIndicatorable`=10;
DELETE FROM `${prefix}indicatorable` WHERE id=10;
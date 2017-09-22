-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.4.1 specific for postgresql               //
-- // Date : 2017-09-23                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}dependency` CHANGE `successorId` `successorId` INT(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}dependency` CHANGE `predecessorId` `predecessorId` INT(12) UNSIGNED  DEFAULT NULL;
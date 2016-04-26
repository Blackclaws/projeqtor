-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.3.3                                       //
-- // Date : 2016-04-26                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}attachment` CHANGE `fileName` `fileName` VARCHAR(1024) DEFAULT NULL, 
CHANGE `link` `link` VARCHAR(1024) DEFAULT NULL;
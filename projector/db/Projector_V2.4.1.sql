
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.4.1                                      //
-- // Date : 2012-07-17                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}requirement` 
ADD COLUMN `countTotal` int(5) default 0;

ALTER TABLE `${prefix}testsession` 
ADD COLUMN `countPlanned` int(5) default 0;

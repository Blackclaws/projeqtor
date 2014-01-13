-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.2.0                                       //
-- // Date : 2014-01-11                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}resource` ADD COLUMN `cookieHash` varchar(400) null,
ADD COLUMN `passwordChangeDate` date DEFAULT NULL;

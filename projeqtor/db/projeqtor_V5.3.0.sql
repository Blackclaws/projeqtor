-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.3.0                                       //
-- // Date : 2016-02-01                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}restricttype` ADD `idProfile` int(12) unsigned DEFAULT NULL;

CREATE INDEX restricttypeProfile ON `${prefix}restricttype` (idProfile,className,idType);
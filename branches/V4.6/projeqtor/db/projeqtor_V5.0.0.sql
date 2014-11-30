-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.0.0                                       //
-- // Date : 2014-11-30                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}ticket` CHANGE description description text,
CHANGE result result text;

ALTER TABLE `${prefix}history` CHANGE oldValue oldValue text,
CHANGE newValue newValue text;
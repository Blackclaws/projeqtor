-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.0.0                                       //
-- // Date : 2014-11-30                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}history` CHANGE oldValue oldValue text,
CHANGE newValue newValue text;

ALTER TABLE `${prefix}action` CHANGE description description text,
CHANGE result result text;

ALTER TABLE `${prefix}activity` CHANGE  description description text,
CHANGE result result text;

ALTER TABLE `${prefix}milestone` CHANGE description description text,
CHANGE result result text;

ALTER TABLE `${prefix}project` CHANGE  description description text;

ALTER TABLE `${prefix}ticket` CHANGE description description text,
CHANGE result result text;





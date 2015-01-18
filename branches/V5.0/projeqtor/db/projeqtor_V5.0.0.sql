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

RENAME TABLE `${prefix}attachement` to `${prefix}attachment`;

UPDATE `${prefix}parameter` SET parameterCode='paramAttachmentDirectory' WHERE parameterCode='paramAttachementDirectory';
UPDATE `${prefix}parameter` SET parameterCode='paramAttachmentMaxSize' WHERE parameterCode='paramAttachementMaxSize';
UPDATE `${prefix}parameter` SET parameterCode='displayAttachment' WHERE parameterCode='displayAttachement';

CREATE INDEX workelementActivity ON `${prefix}workelement` (idActivity);

UPDATE `${prefix}columnselector` SET formatter="thumbName22" WHERE field in ('nameResource', 'nameUser', 'nameContact', 'nameResourceSelect');

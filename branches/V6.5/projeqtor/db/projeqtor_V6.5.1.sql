-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.5.1 specific for postgresql               //
-- // Date : 2017-12-12                                     //
-- ///////////////////////////////////////////////////////////

UPDATE `${prefix}report` SET `sortOrder`=283 WHERE `id`=4;
UPDATE `${prefix}report` SET `sortOrder`=284 WHERE `id`=60;

UPDATE `${prefix}menu` set `level`='Project' where `id` in (181, 182);

UPDATE `${prefix}reportparameter` set `defaultValue`=null where `idReport` in (76, 77) and `name`='idResource';

-- Consistency 

delete from `${prefix}planningelement` where refType='Activity' and refId not in (select id from `${prefix}activity`);
delete from `${prefix}planningelement` where refType='Meeting' and refId not in (select id from `${prefix}meeting`);
delete from `${prefix}planningelement` where refType='Milestone' and refId not in (select id from `${prefix}milestone`);
delete from `${prefix}planningelement` where refType='PeriodicMeeting' and refId not in (select id from `${prefix}periodicmeeting`);
delete from `${prefix}planningelement` where refType='Project' and refId not in (select id from `${prefix}project`);
delete from `${prefix}planningelement` where refType='TestSession' and refId not in (select id from `${prefix}testsession`);

delete from `${prefix}workelement` where refType='Ticket' and refId not in (select id from `${prefix}ticket`);
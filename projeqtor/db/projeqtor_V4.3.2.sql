-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.3.2                                //
-- // Date : 2014-06-27                                     //
-- ///////////////////////////////////////////////////////////
delete from `${prefix}planningelement` 
where refType = 'Activity' and not exists (select 'x' from `${prefix}activity` where id=refId);

delete from `${prefix}planningelement` 
where refType = 'Milestone' and not exists (select 'x' from `${prefix}milestone` where id=refId);

update `${prefix}report` set sortOrder=282
where id=52;
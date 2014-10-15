-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.5.0                                       //
-- // Date : 2014-08-14                                     //
-- ///////////////////////////////////////////////////////////

UPDATE `${prefix}accessprofile` SET name='accessProfileRestrictedReader' WHERE name='accessProfileRestrictiedReader';
UPDATE `${prefix}accessprofile` SET name='accessProfileRestrictedCreator' WHERE name='accessProfileRestricedCreator';

INSERT INTO `${prefix}dependable` (id, `name`, `scope`, `idDefaultDependable`, `idle`) VALUES 
(7, 'Meeting', 'PE', 1, 0);

UPDATE `${prefix}planningmode` SET mandatoryStartDate=1, mandatoryEndDate=1 WHERE code='HALF';

INSERT INTO `${prefix}accessscope` (`id`, `name`, `accessCode`, `sortOrder`, `idle`) VALUES
(5, 'accessScopeResp', 'RES', 250, 0);
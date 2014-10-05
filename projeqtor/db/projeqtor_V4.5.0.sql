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
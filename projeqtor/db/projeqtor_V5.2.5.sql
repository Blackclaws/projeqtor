-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.2.5                                       //
-- // Date : 2016-03-02                                     //
-- ///////////////////////////////////////////////////////////

DELETE FROM `${prefix}affectation` WHERE idProject NOT IN (SELECT id FROM `${prefix}project`);

UPDATE `${prefix}affectation` SET startDate=NULL WHERE startDate='0000-00-00';
UPDATE `${prefix}affectation` SET endDate=NULL WHERE endDate='0000-00-00';
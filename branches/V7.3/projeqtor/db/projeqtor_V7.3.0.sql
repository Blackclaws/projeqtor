-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.3.0                                       //
-- // Date : 2018-06-18                                     //
-- ///////////////////////////////////////////////////////////

UPDATE `${prefix}menu` SET sortOrder=425 WHERE id=58;

ALTER TABLE `${prefix}report`
ADD `filterClass` varchar(100) DEFAULT NULL;

UPDATE `${prefix}report` set `filterClass`='Ticket' WHERE id in (9,10,11,12,13,14,15,16,17,18,73,74,80,83);

-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.5.1 specific for postgresql               //
-- // Date : 2017-12-12                                     //
-- ///////////////////////////////////////////////////////////

UPDATE `${prefix}report` SET `sortOrder`=283 WHERE `id`=4;
UPDATE `${prefix}report` SET `sortOrder`=284 WHERE `id`=60;

UPDATE `${prefix}menu` set `level`='Project' where `id` in (181, 182);
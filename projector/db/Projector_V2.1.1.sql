
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.1.1                                      //
-- // Date : 2012-04-05                                     //
-- ///////////////////////////////////////////////////////////
--
--

UPDATE `${prefix}assignment` SET realWork=0 where realWork is null;
UPDATE `${prefix}assignment` SET leftWork=0 where leftWork is null;
UPDATE `${prefix}assignment` SET plannedWork=realWork+leftWork;

UPDATE `${prefix}planningelement` SET realWork=0 where realWork is null;
UPDATE `${prefix}planningelement` SET leftWork=0 where leftWork is null;
UPDATE `${prefix}planningelement` SET plannedWork=realWork+leftWork;

ALTER TABLE `${prefix}ticket` CHANGE `plannedWork` `plannedWork` DECIMAL(9,5) UNSIGNED,
CHANGE `realWork` `realWork` DECIMAL(9,5) UNSIGNED;
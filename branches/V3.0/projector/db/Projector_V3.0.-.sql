
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.0.0                               //
-- // Date : 2012-09-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
RENAME TABLE `${prefix}user` TO `${prefix}resource`;

--ALTER TABLE `${prefix}report` CHANGE `order``sortOrder` int(5);
ALTER TABLE `${prefix}reportparameter` CHANGE `order``sortOrder` int(5);
ALTER TABLE `${prefix}reportcategory` CHANGE `order``sortOrder` int(5);
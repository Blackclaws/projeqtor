
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.4.0                                      //
-- // Date : 2013-05-06                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'realWorkOnlyForResponsible', 'NO');

ALTER TABLE `${prefix}type` ADD COLUMN `description` varchar(4000);

ALTER TABLE `${prefix}expensedetailtype` ADD COLUMN `description` varchar(4000);

ALTER TABLE `${prefix}contexttype` ADD COLUMN `description` varchar(4000);

ALTER TABLE `${prefix}mail` CHANGE mailBody mailBody text;

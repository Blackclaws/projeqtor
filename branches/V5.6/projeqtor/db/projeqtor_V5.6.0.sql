-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.6.0                        //
-- // Date : 2016-07-28                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}product` ADD `idUser` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}version` ADD `idUser` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}action` ADD `idContact` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}dependency` ADD `comment` varchar(4000)DEFAULT NULL;

UPDATE `${prefix}product` set idUser=
(select min(idUser) from `${prefix}history` where (refType='Product' or refType='Component') and refId=`${prefix}product`.id and operationDate=
(select min(operationDate) from `${prefix}history` where (refType='Product' or refType='Component') and refId=`${prefix}product`.id));

UPDATE `${prefix}version` set idUser=
(select min(idUser) from `${prefix}history` where (refType='Version' or refType='ProductVersion' or refType='ComponentVersion') and refId=`${prefix}version`.id and operationDate=
(select min(operationDate) from `${prefix}history` where (refType='Version' or refType='ProductVersion' or refType='ComponentVersion') and refId=`${prefix}version`.id));

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `orientation`) VALUES
(59, 'reportBurndownChart', 2, 'burndownChart.php', 284, 'L');
INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(59, 'idProject', 'projectList', 10, 'currentProject'),
(59, 'format', 'periodScale', 20, 'day');
INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,59,1),
(2,59,1),
(3,59,1);
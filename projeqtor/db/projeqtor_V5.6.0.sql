-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.6.0                        //
-- // Date : 2016-07-28                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}product` ADD `idUser` int(12) UNSIGNED DEFAULT NULL;
ALTER TABLE `${prefix}version` ADD `idUser` int(12) UNSIGNED DEFAULT NULL;

UPDATE `${prefix}product` set idUser=
(select min(idUser) from `${prefix}history` where (refType='Product' or refType='Component') and refId=`${prefix}product`.id and operationDate=
(select min(operationDate) from `${prefix}history` where (refType='Product' or refType='Component') and refId=`${prefix}product`.id));

UPDATE `${prefix}version` set idUser=
(select min(idUser) from `${prefix}history` where (refType='Version' or refType='ProductVersion' or refType='ComponentVersion') and refId=`${prefix}version`.id and operationDate=
(select min(operationDate) from `${prefix}history` where (refType='Version' or refType='ProductVersion' or refType='ComponentVersion') and refId=`${prefix}version`.id));

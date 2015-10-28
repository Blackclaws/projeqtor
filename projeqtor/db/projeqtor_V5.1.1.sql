-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.1.1                                       //
-- // Date : 2015-10-27                                     //
-- ///////////////////////////////////////////////////////////

DELETE FROM `${prefix}plannedwork` WHERE idProject not in (select id from `${prefix}project`);

DELETE FROM `${prefix}columnselector` WHERE objectClass in ('Project','Quotation','Command','Bill');
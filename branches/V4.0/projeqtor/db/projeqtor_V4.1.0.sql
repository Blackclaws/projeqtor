-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.1.0                                       //
-- // Date : 2013-11-14                                     //
-- ///////////////////////////////////////////////////////////
--
--

DELETE FROM `${prefix}columnselector` WHERE attribute='idTicketType' and hidden='1';

UPDATE `${prefix}columnselector` set attribute='idTicketType', field='nameTicketType'
WHERE attribute='idticketType';
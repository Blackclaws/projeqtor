
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.1.3                                      //
-- // Date : 2013-02-04                                     //
-- ///////////////////////////////////////////////////////////
--
-- // Specific part for database MySql on Unix 
-- // Move to temp : Windows would raise an error as workperiod exists ...
RENAME TABLE `${prefix}workPeriod` TO `${prefix}workperiodtemp`;
RENAME TABLE `${prefix}workperiodtemp` TO `${prefix}workperiod`;


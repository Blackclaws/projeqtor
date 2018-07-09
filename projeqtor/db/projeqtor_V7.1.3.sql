-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.1.3                                       //
-- // Date : 2018-06-10                                     //
-- ///////////////////////////////////////////////////////////
--
--

UPDATE `${prefix}dependency` set predecessorRefType='Project' where predecessorRefType in ('Construction','Replan','Fixed');
UPDATE `${prefix}dependency` set successorRefType='Project' where successorRefType in ('Construction','Replan','Fixed');

-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.1.0                               //
-- // Date : 2012-12-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}requirement` ADD COLUMN `locked` int(1) unsigned default '0',
ADD COLUMN `idLocker` int(12) unsigned,
ADD COLUMN `lockedDate` datetime;

ALTER TABLE  `${prefix}habilitationother` 
CHANGE scope scope varchar(20) DEFAULT NULL;

INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'requirement', 1),
(2, 'requirement', 2),
(3, 'requirement', 1),
(4, 'requirement', 2),
(6, 'requirement', 2),
(7, 'requirement', 2),
(5, 'requirement', 2);  

-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.4.2                                      //
-- // Date : 2012-07-30                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}originable` (`id`, `name`, `idle`) VALUES
(14, 'Requirement', 0),
(15, 'TestSession', 0),
(16, 'TestCase', 0);

ALTER TABLE `${prefix}requirement` ADD COLUMN `idRunStatus` int(12) unsigned default null;
ALTER TABLE `${prefix}testsession` ADD COLUMN `idRunStatus` int(12) unsigned default null;

INSERT INTO `${prefix}runstatus` (id, name, color, sortOrder, idle) VALUES
(5, 'empty', '#FF00A5', 500, 0);

-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.6.0                                      //
-- // Date : 2010-02-21                                     //
-- ///////////////////////////////////////////////////////////
--
--
ALTER TABLE `${prefix}work` CHANGE `work` `work` DECIMAL( 5, 2 ) UNSIGNED NULL DEFAULT NULL;

CREATE TABLE `${prefix}list` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `list` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}list` (`id`, `list`, `name`, `code`, `sortOrder`, `idle`) VALUES
(1, 'yesNo', 'displayYes', 'YES', 20, 0),
(2, 'yesNo', 'displayNo', 'NO', 10, 0);

INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'combo', 1),
(2, 'combo', 2),
(3, 'combo', 1),
(4, 'combo', 2),
(6, 'combo', 2),
(7, 'combo', 2),
(5, 'combo', 2);


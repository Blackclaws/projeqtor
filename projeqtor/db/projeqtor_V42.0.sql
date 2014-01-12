-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.2.0                                       //
-- // Date : 2014-01-11                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}calendardefinition` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}calendardefinition` (id, name, sortOrder, idle) VALUES
(1, 'default', 10, 0);

ALTER TABLE `${prefix}resource` ADD COLUMN `cookieHash` varchar(400) null,
ADD COLUMN `passwordChangeDate` date DEFAULT NULL;


-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.6.0                                      //
-- // Date : 2012-09-06                                     //
-- ///////////////////////////////////////////////////////////
--
--

ALTER TABLE `${prefix}note` ADD COLUMN `idPrivacy` int(12) unsigned default 1,
ADD COLUMN `idTeam` int(12) unsigned default 1;

UPDATE TABLE `${prefix}note` SET idTeam = (select idTeam from ${prefix}user USR where USR.id=idUser);

ALTER TABLE `${prefix}attachement` ADD COLUMN `idPrivacy` int(12) unsigned default 1,
ADD COLUMN `idTeam` int(12) unsigned default 1;

UPDATE TABLE `${prefix}note` SET idTeam = (select idTeam from ${prefix}user USR where USR.id=idUser);

CREATE TABLE `${prefix}privacy` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `${prefix}privacy` (`id`, `name`, `color`, `sortOrder`, `idle`) VALUES
(1,'public','#003399',100,0),
(2,'team','#99FF99',200,0),
(3,'private','#FF9966',300,0);

CREATE TABLE `${prefix}predefinedtext` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) default NULL,
  `name` varchar(100) default NULL,
  `text` varchar(4000) default NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


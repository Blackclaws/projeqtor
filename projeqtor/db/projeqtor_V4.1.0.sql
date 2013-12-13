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

DELETE FROM `${prefix}columnselector` WHERE attribute='requestRefreshProject';

DELETE FROM `${prefix}workelement` where (refType, refId) in 
(select refType, refId from (select * from `${prefix}workelement` w) ww group by refType, refId having count(*) > 1)
and plannedWork is null and realWork is null;

CREATE TABLE `${prefix}quality` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `icon` varchar(100),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}quality` (`id`, `name`, `color`, `sortOrder`, `idle`, `icon`) VALUES
(1,'conform','#32CD32',100,0,'smileyGreen.png'),
(2,'some remarks','#ffd700',200,0,'smileyYellow.png'),
(3,'not conform','#FF0000',300,0,'smileyRed.png');

CREATE TABLE `${prefix}trend` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `icon` varchar(100),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}trend` (`id`, `name`, `color`, `sortOrder`, `idle`, `icon`) VALUES
(1,'increasing','#32CD32',100,0,'trendUp.png'),
(2,'even','#ffd700',200,0,'trendEven.png'),
(3,'decreasing','#FF0000',300,0,'trendDown.png');

ALTER TABLE `${prefix}project` ADD COLUMN `idQuality` int(12) unsigned,
ADD COLUMN `idTrend` int(12) unsigned,
ADD COLUMN `idSponsor` int(12) unsigned;

ALTER TABLE `${prefix}health` ADD COLUMN `icon` varchar(100);
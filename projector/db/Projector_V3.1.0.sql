
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

INSERT INTO `${prefix}habilitationother` (id,idProfile,scope,rightAccess) VALUES 
(1,1,'workValid','4'),
(2,2,'workValid','2'),
(3,3,'workValid','3'),
(4,4,'workValid','2'),
(5,6,'workValid','1'),
(6,7,'workValid','1'),
(7,5,'workValid','1');

CREATE TABLE `${prefix}workPeriod` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned,
  `periodRange` varchar(10),
  `periodValue` varchar(10),
  `submitted` int(1) unsigned default '0',
  `submittedDate` datetime,
  `validated` int(1) unsigned default '0',
  `validatedDate` datetime,
  `idLocker` int(12) unsigned,
  `comment` varchar(4000),
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX weekResource ON `${prefix}week` (idResource);
CREATE INDEX weekWeek ON `${prefix}week` (week);
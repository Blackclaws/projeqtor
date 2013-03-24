
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.2.0                                      //
-- // Date : 2012-12-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
CREATE TABLE `${prefix}today` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `staticSection` varchar(100) DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX todayUSer ON `${prefix}today` (idUser);

CREATE TABLE `${prefix}todayParameter` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `parameterName` varchar(100) DEFAULT NULL,
  `parameterValue` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX todayParameterUser ON `${prefix}todayParameter` (idUser);
CREATE INDEX todayParameterReport ON `${prefix}todayParameter` (idReport);

INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','Projects',null,1,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','AssignedTasks',null,2,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','ResponsibleTasks',null,2,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','IssuerRequestorTasks',null,2,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','ProjectsTasks',null,2,0 FROM `${prefix}resource` where isUser=1 and idle=0;

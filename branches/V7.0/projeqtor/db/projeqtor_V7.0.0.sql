-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.0.0                                       //
-- // Date : 2017-12-22                                     //
-- ///////////////////////////////////////////////////////////

-- begin add gmartin /handle email Template
 
CREATE TABLE `${prefix}emailtemplate` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `template` mediumtext DEFAULT NULL,
  `idMailable` int(12) DEFAULT NULL,
  `idType` int(12) UNSIGNED DEFAULT NULL,
  `idle` int(1) UNSIGNED DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
  
CREATE INDEX `emailtemplateMailable` ON `${prefix}emailtemplate` (`idMailable`);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(305,'menuEmailTemplate', 88, 'object', 585, 'ReadWriteEnvironment', 0, 'Automation');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 305, 1);

ALTER TABLE `${prefix}statusmail`
ADD `idEmailTemplate` int(12) UNSIGNED DEFAULT NULL;

-- end add gmartin 


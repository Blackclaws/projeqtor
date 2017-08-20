-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.4.0 specific for postgresql               //
-- // Date : 2017-04-21                                     //
-- ///////////////////////////////////////////////////////////


INSERT INTO `${prefix}event` (`id`,`name`,`idle`, `sortOrder`) VALUES 
(10,'affectationAdd',0,51),
(11,'affectationChange',0,52);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'paramMailTitleAffectationAdd', '[${dbName}] New allocation of resource ${responsible} has been created on Project ${project}'), 
(null,null, 'paramMailTitleAffectationChange', '[${dbName}] Allocation of resource ${responsible} has been changed on Project ${project}');

ALTER TABLE `${prefix}report` ADD `hasView` int(1) DEFAULT 1,
ADD `hasPrint` int(1) DEFAULT 1,
ADD `hasPdf` int(1) DEFAULT 1,
ADD `hasToday` int(1) DEFAULT 1,
ADD `hasFavorite` int(1) DEFAULT 1,
ADD `hasWord` int(1) DEFAULT 0,
ADD `hasExcel` int(1) DEFAULT 0;

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'mailerTestTitle', '[${dbName}] test email sent at ${date}'), 
(null,null, 'mailerTestMessage', 'This is a test email sent from ${dbName} at ${date}.<br/>Receiving this email means that counfiguration is correct.');

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`, `multiple`) VALUES 
(4, 'showAdminProj', 'boolean', 60, 0, 0, 0);

--ADD qCazelles - Version compatibility
CREATE TABLE `${prefix}versioncompatibility` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idVersionA` int(12) NOT NULL,
  `idVersionB` int(12) NOT NULL,
  `creationDate` date NOT NULL,
  `idUser` int(12) NOT NULL,
  `idle` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
--END ADD qCazelles - Version compatibility

--ADD qCazelles - Dynamic filter - Ticket #78
ALTER TABLE `${prefix}filter` ADD COLUMN `isDynamic` int(1) DEFAULT '0';
ALTER TABLE `${prefix}filtercriteria` ADD COLUMN `isDynamic` int(1) DEFAULT '0';
ALTER TABLE `${prefix}filtercriteria` ADD COLUMN `orOperator` int(1) DEFAULT '0';
--END ADD qCazelles - Dynamic filter - Ticket #78
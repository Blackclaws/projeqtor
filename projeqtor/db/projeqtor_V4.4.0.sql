-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.4.0                                       //
-- // Date : 2014-07-16                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}resource` ADD COLUMN `apiKey` varchar(400) DEFAULT NULL;

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) VALUES 
(53,'reportProductTestDetail',8,'productTestDetail.php',825,0);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`) VALUES
(53,'idProject','projectList',10,0,null),
(53,'idProduct','productList',20,0,null),
(53,'idVersion','versionList',30,0,null);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES
(1,53,1),
(2,53,1),
(3,53,1),
(4,53,0),
(5,53,0),
(6,53,0),
(7,53,0);

INSERT INTO `${prefix}mailable` (`id`,`name`, `idle`) VALUES 
(23,'Product', '0'),
(24,'Version', '0');
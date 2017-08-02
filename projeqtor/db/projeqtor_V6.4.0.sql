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
(null,null, 'paramMailTitleAffectationAdd', '[${dbName}] New affectation has been created on ${item} #${id} : "${name}"'), 
(null,null, 'paramMailTitleAffectationChange', '[${dbName}] An affectation has been modified on ${item} #${id} : "${name}"');

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
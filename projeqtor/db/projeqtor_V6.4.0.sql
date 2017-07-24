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

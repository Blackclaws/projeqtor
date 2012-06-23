
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.4.0                                      //
-- // Date : 2012-06-17                                     //
-- ///////////////////////////////////////////////////////////
--
--
UPDATE `${prefix}menu` set sortOrder=sortOrder+100
where sortOrder>=250 and sortOrder<=399;

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(107,'menuRequirementType',79,'object',954,NULL,0),
(108,'menuTestCaseType',79,'object',955,NULL,0),
(109,'menuTestSessionType',79,'object',956,NULL,0),
(110, 'menuRequirementTest',0,'menu',300,NULL,0),
(111, 'menuRequirement',110,'object',310,'project',0),
(112, 'menuTestCase',110,'object',320,'project',0),
(113, 'menuTestSession',110,'object',330,'project',0),
(114, 'menuRiskLevel',36,'object',761,NULL,0),
(115, 'menuFeasibility',36,'object',762,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 107, 1),
(2, 107, 0),
(3, 107, 0),
(4, 107, 0),
(5, 107, 0),
(6, 107, 0),
(7, 107, 0),
(1, 108, 1),
(2, 108, 0),
(3, 108, 0),
(4, 108, 0),
(5, 108, 0),
(6, 108, 0),
(7, 108, 0),
(1, 109, 1),
(2, 109, 0),
(3, 109, 0),
(4, 109, 0),
(5, 109, 0),
(6, 109, 0),
(7, 109, 0),
(1, 111, 1),
(2, 111, 1),
(3, 111, 1),
(4, 111, 1),
(5, 111, 1),
(6, 111, 1),
(7, 111, 1),
(1, 112, 1),
(2, 112, 1),
(3, 112, 1),
(4, 112, 1),
(5, 112, 1),
(6, 112, 1),
(7, 112, 1),
(1, 113, 1),
(2, 113, 1),
(3, 113, 1),
(4, 113, 1),
(5, 113, 1),
(6, 113, 1),
(7, 113, 1),
(1, 114, 1),
(2, 114, 0),
(3, 114, 0),
(4, 114, 0),
(5, 114, 0),
(6, 114, 0),
(7, 114, 0),
(1, 115, 1),
(2, 115, 0),
(3, 115, 0),
(4, 115, 0),
(5, 115, 0),
(6, 115, 0),
(7, 115, 0);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1, 111, 8),
(2, 111, 2),
(3, 111, 7),
(4, 111, 7),
(6, 111, 2),
(7, 111, 2),
(5, 111, 9),
(1, 112, 8),
(2, 112, 2),
(3, 112, 7),
(4, 112, 7),
(6, 112, 2),
(7, 112, 2),
(5, 112, 9),
(1, 113, 8),
(2, 113, 2),
(3, 113, 7),
(4, 113, 7),
(6, 113, 2),
(7, 113, 2),
(5, 113, 9);

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idle`, `color`, idWorkflow, code) VALUES
('Requirement', 'Functional', 10, 0, NULL, 1, 'FUNC'),
('Requirement', 'Technical', 20, 0, NULL, 1, 'TECH'),
('Requirement', 'Security', 30, 0, NULL, 1, 'SECU'),
('Requirement', 'Regulatory', 40, 0, NULL, 1, 'REGL'),
('TestCase', 'Requirement test', 10, 0, NULL, 1, 'REQU'),
('TestCase', 'Non regression', 30, 0, NULL, 1, 'NR'),
('TestCase', 'Unit test', 20, 0, NULL, 1 , 'UT'),
('TestSession', 'Evolution test session', 10, 0, NULL, 1, 'EVO'),
('TestSession', 'Development test session', 20, 0, NULL, 1, 'DEV'),
('TestSession', 'Non regression test session', 30, 0, NULL, 1 , 'NR'),
('TestSession', 'Unitary case test session', 40, 0, NULL, 1 , 'UT');

CREATE TABLE `${prefix}risklevel` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `${prefix}risklevel` (id, name, color, sortOrder, idle) VALUES
(1, 'Very Low', '#00FF00', 100, 0),
(2, 'Low', '#00AAAA', 200,0),
(3, 'Average', '#AAAAAA', 300,0),
(4, 'High', '#AAAA00', 400,0),
(5, 'Very High', '#FF0000', 500,0);

CREATE TABLE `${prefix}feasibility` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `${prefix}feasibility` (id, name, color, sortOrder, idle) VALUES
(1, 'Yes', '#00FF00', 100, 0),
(2, 'Investigate', '#AAAA00', 200,0),
(3, 'No', '#FF0000', 300,0);

CREATE TABLE `${prefix}runstatus` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `${prefix}runstatus` (id, name, color, sortOrder, idle) VALUES
(1, 'planned', '#00AAAA', 100, 0),
(2, 'passed', '#00FF00', 200,0),
(3, 'failed', '#FF0000', 300,0),
(4, 'blocked', '#AAAA00', 400,0);

CREATE TABLE `${prefix}requirement` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `idRequirementType`  int(12) unsigned DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idRequirement` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `idTargetVersion` int(12) unsigned DEFAULT NULL,
  `plannedWork` decimal(14,5) UNSIGNED DEFAULT '0',
  `idUrgency` int(12) unsigned DEFAULT NULL,
  `idCriticality` int(12) unsigned DEFAULT NULL,
  `idFeasibility` int(12) unsigned DEFAULT NULL,
  `idRiskLevel` int(12) unsigned DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `testCoverage` int(5) default 0,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `${prefix}requirement` ADD INDEX requirementProject (idProject),
ADD INDEX requirementProduct (idProduct),
ADD INDEX requirementVersion (idVersion),
ADD INDEX requirementType (idRequirementType),
ADD INDEX requirementUser (idUser),
ADD INDEX requirementRequirement (idRequirement),
ADD INDEX requirementStatus (idStatus),
ADD INDEX requirementResource (idResource),
ADD INDEX requirementTargetVersion (idTargetVersion),
ADD INDEX requirementUrgency (idUrgency),
ADD INDEX requirementCriticallity (idCriticallity),
ADD INDEX requirementFeasibility (idFeasibility),
ADD INDEX requiremenRiskLevel (idRiskLevel);

CREATE TABLE `${prefix}testcase` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `idTestCaseType`  int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idContext1` int(12) unsigned DEFAULT NULL,
  `idContext2` int(12) unsigned DEFAULT NULL,
  `idContext3` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idTestCase` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `idPriority` int(12) unsigned DEFAULT NULL,
  `prerequisite` varchar(4000) DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `sessionCount` int(5) default 0,
  `runCount` int(5) default 0,
  `lastRunDate` date DEFAULT NULL,
  `idRunStatus` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `${prefix}testcase` ADD INDEX testcaseProject (idProject),
ADD INDEX testcaseProduct (idProduct),
ADD INDEX testcaseVersion (idVersion),
ADD INDEX testcaseType (idTestCaseType),
ADD INDEX testcaseUser (idUser),
ADD INDEX testcaseTestCase (idTestCase),
ADD INDEX testcaseStatus (idStatus),
ADD INDEX testcaseResource (idResource),
ADD INDEX testcasePriority (idPriority),
ADD INDEX testcaseRunStatus (idRunStatus);

CREATE TABLE `${prefix}testsession` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `idTestSessionType`  int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `countPassed` int(5) default 0,
  `countFailed` int(5) default 0,
  `countTotal` int(5) default 0,
  `countIssues` int(5) default 0,
  `runCount` int(5) default 0,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `${prefix}testsession` ADD INDEX testsessionProject (idProject),
ADD INDEX testsessionProduct (idProduct),
ADD INDEX testsessionVersion (idVersion),
ADD INDEX testsessionType (idTestSessionType),
ADD INDEX testsessionUser (idUser),
ADD INDEX testsessionStatus (idStatus),
ADD INDEX testsessionResource (idResource);

INSERT INTO `${prefix}referencable` (`id`, `name`, `idle`) VALUES
(13, 'Requirement', 0),
(14, 'TestCase', 0),
(15, 'TestSession', 0);

ALTER TABLE `${prefix}link` ADD COLUMN `idDefaultLinkable`  int(12) unsigned DEFAULT NULL; 
INSERT INTO `${prefix}linkable` (`id`,`name`,`idle`, idDefaultLinkable) VALUES
(11,'Requirement',0,12),
(12,'TestCase',0,11),;

CREATE TABLE `${prefix}testcaserun` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idTestCase` int(12) unsigned DEFAULT NULL,
  `idTestSession` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,

--INSERT INTO `${prefix}report`(`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) 
--VALUES (40,'reportWorkPerActivity',1,'workPerActivity.php',170,0);

--INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `idle`, `defaultValue`) VALUES
--(104,40,'idProject','projectList',10,0,'currentProject');

--INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES
--(1,40,1),
--(2,40,1),
--(3,40,1),
--(4,40,0),
--(5,40,0),
--(6,40,0),
--(7,40,0);


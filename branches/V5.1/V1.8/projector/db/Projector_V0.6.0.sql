
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR EXPORT                                      //
-- //-------------------------------------------------------//
-- // Version : V0.5.0                                      //
-- // Date : 2009-10-18                                     //
-- ///////////////////////////////////////////////////////////

--
-- Structure de la TABLE `${prefix}assignment`
--
CREATE TABLE `${prefix}assignment` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  `refType`  varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `rate` int(3) UNSIGNED DEFAULT 100, 
  `assignedWork` NUMERIC(6,2) UNSIGNED,
  `realWork` NUMERIC(6,2) UNSIGNED,
  `leftWork` NUMERIC(6,2) UNSIGNED,
  `plannedWork` NUMERIC(6,2) UNSIGNED,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Remove unused Task table
--
DROP TABLE `${prefix}task` ;
 
--
-- Structure de la TABLE `${prefix}planningelement`
--
ALTER TABLE `${prefix}planningelement` CHANGE initialWork initialWork NUMERIC(6,2) UNSIGNED,
 CHANGE validatedWork validatedWork NUMERIC(6,2) UNSIGNED,
 CHANGE plannedWork plannedWork NUMERIC(6,2) UNSIGNED,
 CHANGE realWork realWork NUMERIC(6,2) UNSIGNED,
 ADD leftWork NUMERIC(6,2) UNSIGNED,
 ADD assignedWork NUMERIC(6,2) UNSIGNED;

--
-- Add a type of activity : Task
--
INSERT INTO `${prefix}type` (`id`, `scope`, `name`, `sortOrder`, `idle`, `color`) VALUES
(26, 'Activity', 'Task', 01, 0, NULL);

--
-- tructure de la TABLE project
--
ALTER TABLE `${prefix}project` ADD idUser int(12) UNSIGNED;

--
-- Add indexes to forreign keys
--
ALTER TABLE `${prefix}accessright` ADD INDEX accessrightProfile (idProfile),
  ADD INDEX accessrightMenu (idMenu);

ALTER TABLE `${prefix}action` ADD INDEX actionProject (idProject),
  ADD INDEX actionUser (idUser),
  ADD INDEX actionResource (idResource),
  ADD INDEX actionStatus (idStatus);
  
ALTER TABLE `${prefix}activity` ADD INDEX activityProject (idProject),
  ADD INDEX activityUser (idUser),
  ADD INDEX activityResource (idResource),
  ADD INDEX activityStatus (idStatus),
  ADD INDEX activityType (idActivityType),
  ADD INDEX activityActivity (idActivity); 
  
ALTER TABLE `${prefix}affectation` ADD INDEX affectationProject (idProject),
  ADD INDEX affectationResource (idResource);   
  
ALTER TABLE `${prefix}assignment` ADD INDEX assignmentProject (idProject),
  ADD INDEX assignmentResource (idResource),
  ADD INDEX assignmentRef (refType, refId);

ALTER TABLE `${prefix}attachement` ADD INDEX attachementUser (idUser),
  ADD INDEX attachementRef (refType, refId);        

ALTER TABLE `${prefix}habilitation` ADD INDEX habilitationProfile (idProfile),
  ADD INDEX habilitationMenu (idMenu);  
  
ALTER TABLE `${prefix}history` ADD INDEX historyUser (idUser),
  ADD INDEX historyRef (refType, refId); 

ALTER TABLE `${prefix}issue` ADD INDEX issueProject (idProject),
  ADD INDEX issueUser (idUser),
  ADD INDEX issueResource (idResource),
  ADD INDEX issueStatus (idStatus),
  ADD INDEX issueType (idIssueType);  
  
ALTER TABLE `${prefix}link` ADD INDEX linkRef1 (ref1Type, ref1Id),
  ADD INDEX linkRef2 (ref2Type, ref2Id);
  
ALTER TABLE `${prefix}menu` ADD INDEX menuMenu (idMenu);

ALTER TABLE `${prefix}message` ADD INDEX messageProject (idProject),
  ADD INDEX messageUser (idUser),
  ADD INDEX messageType (idMessageType),
  ADD INDEX messageProfile (idProfile);           
  
ALTER TABLE `${prefix}milestone` ADD INDEX milestoneProject (idProject),
  ADD INDEX milestoneUser (idUser),
  ADD INDEX milestoneResource (idResource),
  ADD INDEX milestoneStatus (idStatus),
  ADD INDEX milestoneType (idMilestoneType),
  ADD INDEX milestoneActivity (idActivity);
  
ALTER TABLE `${prefix}note` ADD INDEX noteUser (idUser),
  ADD INDEX noteRef (refType, refId);        

ALTER TABLE `${prefix}parameter` ADD INDEX parameterProject (idProject),
  ADD INDEX parameterUser (idUser);
  
ALTER TABLE `${prefix}planningelement` ADD INDEX planningelementProject (idProject),
  ADD INDEX planningelementWbsSortable (wbsSortable);  

ALTER TABLE `${prefix}project` ADD INDEX projectProject (idProject),
  ADD INDEX projectClient (idClient);

ALTER TABLE `${prefix}risk` ADD INDEX riskProject (idProject),
  ADD INDEX riskUser (idUser),
  ADD INDEX riskResource (idResource),
  ADD INDEX riskStatus (idStatus),
  ADD INDEX riskType (idRiskType);  

ALTER TABLE `${prefix}ticket` ADD INDEX ticketProject (idProject),
  ADD INDEX ticketUser (idUser),
  ADD INDEX ticketResource (idResource),
  ADD INDEX ticketStatus (idStatus),
  ADD INDEX ticketType (idTicketType),
  ADD INDEX ticketActivity (idActivity); 
  
--
-- Structure de la TABLE `${prefix}work`
--
CREATE TABLE `${prefix}work` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned NOT NULL,
  `idProject` int(12) unsigned NOT NULL,
  `refType`  varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idAssignment` int(12) unsigned default NULL,
  `work` NUMERIC(3,2) UNSIGNED,
  `workDate` date DEFAULT NULL,
  `day`  varchar(8),
  `week` varchar(6),
  `month` varchar(6),
  `year` varchar(4),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}work` ADD INDEX workDay (day),
  ADD INDEX workWeek (week),
  ADD INDEX workMonth (month),
  ADD INDEX workYear (year),
  ADD INDEX workRef (refType, refId),
  ADD INDEX workResource (idResource),
  ADD INDEX workAssignment (idAssignment);        

UPDATE `${prefix}menu` SET idle=0 where id=8;
UPDATE `${prefix}habilitation` SET allowAccess=1 where idMenu=8;

  
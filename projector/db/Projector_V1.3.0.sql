
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V1.3.0                           //
-- // Date : 2010-10-07                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `order`) VALUES
(8, 'reportWorkPlan', 2, 'workPlan.php', 6);

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `defaultValue`) VALUES 
(11, 8, 'idProject', 'projectList', 10, 'currentProject');

ALTER TABLE `${prefix}action` ADD INDEX actionType (idActionType);

ALTER TABLE `${prefix}decision` ADD INDEX decisionProject (idProject),
ADD INDEX decisionType (idDecisionType),
ADD INDEX decisionUser (idUser),
ADD INDEX decisionResource (idResource),
ADD INDEX decisionStatus (idStatus);

ALTER TABLE `${prefix}filter` ADD INDEX filterUser (idUser);

ALTER TABLE `${prefix}filtercriteria` ADD INDEX filtercriteriaFilter (idFilter);

ALTER TABLE `${prefix}issue` ADD INDEX issuePriority (idPriority);

ALTER TABLE `${prefix}mail` ADD INDEX mailProject (idProject),
ADD INDEX mailUser (idUser),
ADD INDEX mailRef (refType, refId),
ADD INDEX mailStatus (idStatus);

ALTER TABLE `${prefix}meeting` ADD INDEX meetingProject (idProject),
ADD INDEX meetingType (idMeetingType),
ADD INDEX meetingUser (idUser),
ADD INDEX meetingResource (idResource),
ADD INDEX meetingStatus (idStatus);

ALTER TABLE `${prefix}planningelement` ADD INDEX planningelementPlanningMode (idPlanningMode);

ALTER TABLE `${prefix}project` ADD INDEX projectUser (idUser);

ALTER TABLE `${prefix}question` ADD INDEX questionProject (idProject),
ADD INDEX questionType (idQuestionType),
ADD INDEX questionUser (idUser),
ADD INDEX questionResource (idResource),
ADD INDEX questionStatus (idStatus);

ALTER TABLE `${prefix}report` ADD INDEX reportCategory (idReportCategory);

ALTER TABLE `${prefix}reportParameter` ADD INDEX reportparameterReport (idReport);

ALTER TABLE `${prefix}risk` ADD INDEX riskSeverity (idSeverity),
ADD INDEX riskLikelihood (idLikelihood),
ADD INDEX riskCriticality (idCriticality);

ALTER TABLE `${prefix}statusmail` ADD INDEX statusmailStatus (idStatus),
ADD INDEX statusmailMailable (idMailable);

ALTER TABLE `${prefix}ticket` ADD INDEX ticketUrgency (idUrgency),
ADD INDEX ticketPriority (idPriority),
ADD INDEX ticketCriticality (idCriticality);

ALTER TABLE `${prefix}type` ADD INDEX typeScope (scope);

ALTER TABLE `${prefix}user` ADD INDEX userProfile (idProfile),
ADD INDEX userTeam (idTeam);

ALTER TABLE `${prefix}workflowstatus` ADD INDEX workflowstatusProfile (idProfile),
ADD INDEX workflowstatusWorkflow (idWorkflow),
ADD INDEX workflowstatusStatusFrom (idStatusFrom),
ADD INDEX workflowstatusStatusTo (idStatusTo);

INSERT INTO `${prefix}reportcategory` (`id`, `name`, `order`) VALUES
(3, 'reportCategoryTicket', 30);

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `order`) VALUES
(9, 'ticketYearlyReport', 3, 'ticketYearlyReport.php', 10);

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `defaultValue`) VALUES 
(12, 9, 'idProject', 'projectList', 10, 'currentProject'),
(13, 9, 'year', 'year', 20, 'currentYear'),
(14, 9, 'idTicketType', 'ticketType', 30, null),
(15, 9, 'issuer', 'userList', 40, null),
(16, 9, 'responsible', 'resourceList', 50, null);


-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.0.0                                       //
-- // Date : 2014-11-30                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}history` CHANGE `oldValue` `oldValue` text,
 CHANGE `newValue` `newValue` text;

ALTER TABLE `${prefix}action` CHANGE `description` `description` text,
 CHANGE `result` `result` text;

ALTER TABLE `${prefix}activity` CHANGE `description` `description` text,
 CHANGE `result` `result` text;

ALTER TABLE `${prefix}milestone` CHANGE `description` `description` text,
 CHANGE `result` `result` text;

ALTER TABLE `${prefix}project` CHANGE  `description` `description` text;

ALTER TABLE `${prefix}ticket` CHANGE `description` `description` text,
 CHANGE `result` `result` text;

RENAME TABLE `${prefix}attachement` TO `${prefix}attachment`;

UPDATE `${prefix}parameter` SET parameterCode='paramAttachmentDirectory' WHERE parameterCode='paramAttachementDirectory';
UPDATE `${prefix}parameter` SET parameterCode='paramAttachmentMaxSize' WHERE parameterCode='paramAttachementMaxSize';
UPDATE `${prefix}parameter` SET parameterCode='displayAttachment' WHERE parameterCode='displayAttachement';

CREATE INDEX workelementActivity ON `${prefix}workelement` (idActivity);

UPDATE `${prefix}columnselector` SET formatter='thumbName22' WHERE field in ('nameResource', 'nameUser', 'nameContact', 'nameResourceSelect');

CREATE TABLE `${prefix}menuselector` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}affectation` ADD `idProfile` int(12) unsigned;
UPDATE `${prefix}affectation` SET idProfile=(select idProfile from `${prefix}resource` R where R.id=idResource); 

ALTER TABLE `${prefix}menu` ADD `menuClass` varchar(400);
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial Meeting ' WHERE name='menuToday';
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial Meeting ' WHERE name='menuProject';
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial Meeting ' WHERE name='menuDocument';
UPDATE `${prefix}menu` SET menuClass='Work Risk Meeting ' WHERE name='menuWork';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuTicket';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuTicketSimple';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuActivity';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuMilestone';
UPDATE `${prefix}menu` SET menuClass='Work Risk Meeting ' WHERE name='menuAction';
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial ' WHERE name='menuFollowup';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuImputation';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuPlanning';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuPortfolioPlanning';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuResourcePlanning';
UPDATE `${prefix}menu` SET menuClass='Work ' WHERE name='menuDiary';
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial ' WHERE name='menuReports';
UPDATE `${prefix}menu` SET menuClass='Work RequirementTest ' WHERE name='menuRequirementTest';
UPDATE `${prefix}menu` SET menuClass='RequirementTest ' WHERE name='menuRequirement';
UPDATE `${prefix}menu` SET menuClass='RequirementTest ' WHERE name='menuTestCase';
UPDATE `${prefix}menu` SET menuClass='RequirementTest ' WHERE name='menuTestSession';
UPDATE `${prefix}menu` SET menuClass='Work Financial ' WHERE name='menuFinancial';
UPDATE `${prefix}menu` SET menuClass='Work Financial ' WHERE name='menuIndividualExpense';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuProjectExpense';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuQuotation';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuCommand';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuTerm';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuBill';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuPayment';
UPDATE `${prefix}menu` SET menuClass='Financial ' WHERE name='menuActivityPrice';
UPDATE `${prefix}menu` SET menuClass='Risk ' WHERE name='menuRiskManagementPlan';
UPDATE `${prefix}menu` SET menuClass='Risk ' WHERE name='menuRisk';
UPDATE `${prefix}menu` SET menuClass='Risk ' WHERE name='menuOpportunity';
UPDATE `${prefix}menu` SET menuClass='Risk ' WHERE name='menuIssue';
UPDATE `${prefix}menu` SET menuClass='Work Meeting ' WHERE name='menuReview';
UPDATE `${prefix}menu` SET menuClass='Work Meeting ' WHERE name='menuMeeting';
UPDATE `${prefix}menu` SET menuClass='Meeting ' WHERE name='menuPeriodicMeeting';
UPDATE `${prefix}menu` SET menuClass='Meeting ' WHERE name='menuDecision';
UPDATE `${prefix}menu` SET menuClass='Meeting ' WHERE name='menuQuestion';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuTool';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuRequestor';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuMail';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuAlert';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuMessage';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuImportData';
UPDATE `${prefix}menu` SET menuClass='Work Financial EnvironmentalParameter ' WHERE name='menuEnvironmentalParameter';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter ' WHERE name='menuProduct';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter ' WHERE name='menuVersion';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter ' WHERE name='menuAffectation';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter ' WHERE name='menuContext';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter HabilitationParameter ' WHERE name='menuUser';
UPDATE `${prefix}menu` SET menuClass='Work EnvironmentalParameter ' WHERE name='menuResource';
UPDATE `${prefix}menu` SET menuClass='Financial EnvironmentalParameter ' WHERE name='menuContact';
UPDATE `${prefix}menu` SET menuClass='Financial EnvironmentalParameter ' WHERE name='menuClient';
UPDATE `${prefix}menu` SET menuClass='Financial EnvironmentalParameter ' WHERE name='menuRecipient';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter ' WHERE name='menuTeam';
UPDATE `${prefix}menu` SET menuClass='EnvironmentalParameter ' WHERE name='menuDocumentDirectory';
UPDATE `${prefix}menu` SET menuClass='Work EnvironmentalParameter ' WHERE name='menuCalendar';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuAutomation';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuWorkflow';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuStatusMail';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuTicketDelay';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuIndicatorDefinition';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuPredefinedNote';
UPDATE `${prefix}menu` SET menuClass='Automation ' WHERE name='menuChecklistDefinition';
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial Meeting Admin Automation EnvironmentalParameter ListOfValues Type HabilitationParameter ' WHERE name='menuParameter';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuListOfValues';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuRole';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuStatus';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuQuality';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuHealth';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuOverallProgress';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuTrend';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuLikelihood';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuCriticality';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuSeverity';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuUrgency';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuPriority';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuRiskLevel';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuFeasibility';
UPDATE `${prefix}menu` SET menuClass='ListOfValues ' WHERE name='menuEfficiency';
UPDATE `${prefix}menu` SET menuClass='' WHERE name='menuType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuProjectType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuTicketType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuActivityType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuMilestoneType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuQuotationType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuCommandType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuIndividualExpenseType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuProjectExpenseType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuExpenseDetailType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuBillType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuPaymentType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuRiskType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuInvoiceType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuOpportunityType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuActionType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuIssueType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuMeetingType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuDecisionType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuQuestionType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuMessageType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuDocumentType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuContextType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuRequirementType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuTestCaseType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuTestSessionType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuClientType';
UPDATE `${prefix}menu` SET menuClass='Type ' WHERE name='menuHabilitationParameter';
UPDATE `${prefix}menu` SET menuClass='HabilitationParameter ' WHERE name='menuProfile';
UPDATE `${prefix}menu` SET menuClass='HabilitationParameter ' WHERE name='menuAccessProfile';
UPDATE `${prefix}menu` SET menuClass='HabilitationParameter ' WHERE name='menuHabilitation';
UPDATE `${prefix}menu` SET menuClass='HabilitationParameter ' WHERE name='menuHabilitationReport';
UPDATE `${prefix}menu` SET menuClass='HabilitationParameter ' WHERE name='menuAccessRight';
UPDATE `${prefix}menu` SET menuClass='HabilitationParameter ' WHERE name='menuHabilitationOther';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuAdmin';
UPDATE `${prefix}menu` SET menuClass='Admin ' WHERE name='menuAudit';
UPDATE `${prefix}menu` SET menuClass='Admin EnvironmentalParameter HabilitationParameter ' WHERE name='menuGlobalParameter';
UPDATE `${prefix}menu` SET menuClass='' WHERE name='menuProjectParameter';
UPDATE `${prefix}menu` SET menuClass='Work Risk RequirementTest Financial Meeting Admin Automation EnvironmentalParameter ListOfValues Type HabilitationParameter ' WHERE name='menuUserParameter';

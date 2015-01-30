-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.0.0                                       //
-- // Date : 2014-11-30                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}history` CHANGE oldValue oldValue text,
CHANGE newValue newValue text;

ALTER TABLE `${prefix}action` CHANGE description description text,
CHANGE result result text;

ALTER TABLE `${prefix}activity` CHANGE  description description text,
CHANGE result result text;

ALTER TABLE `${prefix}milestone` CHANGE description description text,
CHANGE result result text;

ALTER TABLE `${prefix}project` CHANGE  description description text;

ALTER TABLE `${prefix}ticket` CHANGE description description text,
CHANGE result result text;

RENAME TABLE `${prefix}attachement` to `${prefix}attachment`;

UPDATE `${prefix}parameter` SET parameterCode='paramAttachmentDirectory' WHERE parameterCode='paramAttachementDirectory';
UPDATE `${prefix}parameter` SET parameterCode='paramAttachmentMaxSize' WHERE parameterCode='paramAttachementMaxSize';
UPDATE `${prefix}parameter` SET parameterCode='displayAttachment' WHERE parameterCode='displayAttachement';

CREATE INDEX workelementActivity ON `${prefix}workelement` (idActivity);

UPDATE `${prefix}columnselector` SET formatter="thumbName22" WHERE field in ('nameResource', 'nameUser', 'nameContact', 'nameResourceSelect');

CREATE TABLE `${prefix}menuselector` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}menu` ADD menuClass varchar(400);
UPDATE `${prefix}menu` SET menuClass='work risks tests financial meetings ' WHERE name='menuToday';
UPDATE `${prefix}menu` SET menuClass='work risks tests financial meetings ' WHERE name='menuProject';
UPDATE `${prefix}menu` SET menuClass='work risks tests financial meetings ' WHERE name='menuDocument';
UPDATE `${prefix}menu` SET menuClass='work risks meetings ' WHERE name='menuWork';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuTicket';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuTicketSimple';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuActivity';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuMilestone';
UPDATE `${prefix}menu` SET menuClass='work risks meetings ' WHERE name='menuAction';
UPDATE `${prefix}menu` SET menuClass='work risks tests financial ' WHERE name='menuFollowup';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuImputation';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuPlanning';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuPortfolioPlanning';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuResourcePlanning';
UPDATE `${prefix}menu` SET menuClass='work ' WHERE name='menuDiary';
UPDATE `${prefix}menu` SET menuClass='work risks tests financial ' WHERE name='menuReports';
UPDATE `${prefix}menu` SET menuClass='work tests ' WHERE name='menuRequirementTest';
UPDATE `${prefix}menu` SET menuClass='tests ' WHERE name='menuRequirement';
UPDATE `${prefix}menu` SET menuClass='tests ' WHERE name='menuTestCase';
UPDATE `${prefix}menu` SET menuClass='tests ' WHERE name='menuTestSession';
UPDATE `${prefix}menu` SET menuClass='work financial ' WHERE name='menuFinancial';
UPDATE `${prefix}menu` SET menuClass='work financial ' WHERE name='menuIndividualExpense';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuProjectExpense';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuQuotation';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuCommand';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuTerm';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuBill';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuPayment';
UPDATE `${prefix}menu` SET menuClass='financial ' WHERE name='menuActivityPrice';
UPDATE `${prefix}menu` SET menuClass='risks ' WHERE name='menuRiskManagementPlan';
UPDATE `${prefix}menu` SET menuClass='risks ' WHERE name='menuRisk';
UPDATE `${prefix}menu` SET menuClass='risks ' WHERE name='menuOpportunity';
UPDATE `${prefix}menu` SET menuClass='risks ' WHERE name='menuIssue';
UPDATE `${prefix}menu` SET menuClass='work meetings ' WHERE name='menuReview';
UPDATE `${prefix}menu` SET menuClass='work meetings ' WHERE name='menuMeeting';
UPDATE `${prefix}menu` SET menuClass='meetings ' WHERE name='menuPeriodicMeeting';
UPDATE `${prefix}menu` SET menuClass='meetings ' WHERE name='menuDecision';
UPDATE `${prefix}menu` SET menuClass='meetings ' WHERE name='menuQuestion';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuTool';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuRequestor';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuMail';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuAlert';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuMessage';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuImportData';
UPDATE `${prefix}menu` SET menuClass='work financial environment ' WHERE name='menuEnvironmentalParameter';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuProduct';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuVersion';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuAffectation';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuContext';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuUser';
UPDATE `${prefix}menu` SET menuClass='work environment ' WHERE name='menuResource';
UPDATE `${prefix}menu` SET menuClass='financial environment ' WHERE name='menuContact';
UPDATE `${prefix}menu` SET menuClass='financial environment ' WHERE name='menuClient';
UPDATE `${prefix}menu` SET menuClass='financial environment ' WHERE name='menuRecipient';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuTeam';
UPDATE `${prefix}menu` SET menuClass='environment ' WHERE name='menuDocumentDirectory';
UPDATE `${prefix}menu` SET menuClass='work environment ' WHERE name='menuCalendar';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuAutomation';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuWorkflow';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuStatusMail';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuTicketDelay';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuIndicatorDefinition';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuPredefinedNote';
UPDATE `${prefix}menu` SET menuClass='automations ' WHERE name='menuChecklistDefinition';
UPDATE `${prefix}menu` SET menuClass='work risks tests financial meetings administration automations environment lists types security ' WHERE name='menuParameter';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuListOfValues';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuRole';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuStatus';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuQuality';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuHealth';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuOverallProgress';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuTrend';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuLikelihood';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuCriticality';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuSeverity';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuUrgency';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuPriority';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuRiskLevel';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuFeasibility';
UPDATE `${prefix}menu` SET menuClass='lists ' WHERE name='menuEfficiency';
UPDATE `${prefix}menu` SET menuClass='' WHERE name='menuType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuProjectType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuTicketType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuActivityType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuMilestoneType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuQuotationType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuCommandType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuIndividualExpenseType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuProjectExpenseType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuExpenseDetailType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuBillType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuPaymentType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuRiskType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuInvoiceType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuOpportunityType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuActionType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuIssueType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuMeetingType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuDecisionType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuQuestionType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuMessageType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuDocumentType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuContextType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuRequirementType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuTestCaseType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuTestSessionType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuClientType';
UPDATE `${prefix}menu` SET menuClass='types ' WHERE name='menuHabilitationParameter';
UPDATE `${prefix}menu` SET menuClass='security ' WHERE name='menuProfile';
UPDATE `${prefix}menu` SET menuClass='security ' WHERE name='menuAccessProfile';
UPDATE `${prefix}menu` SET menuClass='security ' WHERE name='menuHabilitation';
UPDATE `${prefix}menu` SET menuClass='security ' WHERE name='menuHabilitationReport';
UPDATE `${prefix}menu` SET menuClass='security ' WHERE name='menuAccessRight';
UPDATE `${prefix}menu` SET menuClass='security ' WHERE name='menuHabilitationOther';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuAdmin';
UPDATE `${prefix}menu` SET menuClass='administration ' WHERE name='menuAudit';
UPDATE `${prefix}menu` SET menuClass='administration environment security ' WHERE name='menuGlobalParameter';
UPDATE `${prefix}menu` SET menuClass='' WHERE name='menuProjectParameter';
UPDATE `${prefix}menu` SET menuClass='work risks tests financial meetings administration automations environment lists types security ' WHERE name='menuUserParameter';


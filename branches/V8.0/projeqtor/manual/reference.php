<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

$section=array();
$sectionName=array();
$topics=array();
$tags=array();
$page=array();
$slideRoot='img';
$slideExt='.png';

// Copy and paste
$slide[0]='Welcome '; $slideName[0]='Welcome'; $slidePage['Welcome']='0'; $slideTags[0]='welcome home'; $slideTopics[0]='';
$slide[1]='Functional'; $slideName[1]='Functional '; $slidePage['Functional1']='1'; $slideTags[1]='functional'; $slideTopics[1]='Ticket Activity Milestone Action Planning Workload Cost Report';
$slide[2]='Functional'; $slideName[2]='Functional (2)'; $slidePage['Functional2']='2'; $slideTags[2]='functional'; $slideTopics[2]='Expense Bill Risk Action Issue Meeting Decision Question Message Import ';
$slide[3]='Functional'; $slideName[3]='Functional (3)'; $slidePage['Functional3']='3'; $slideTags[3]='functional'; $slideTopics[3]='Client User Resource AccessRight Calendar';
$slide[4]='Functional'; $slideName[4]='Functional (4)'; $slidePage['Functional4']='4'; $slideTags[4]='functional'; $slideTopics[4]='Document Requirement Test Parameter';
$slide[5]='Functional'; $slideName[5]='Functional (5)'; $slidePage['Functional5']='5'; $slideTags[5]='functional'; $slideTopics[5]='AccessProfile GuiFilter';
$slide[6]='Technical'; $slideName[6]='Technical'; $slidePage['Technical1']='6'; $slideTags[6]='technical gui interface ajax browser'; $slideTopics[6]='GuiGenerality';
$slide[7]='Technical'; $slideName[7]='Technical (2)'; $slidePage['Technical2']='7'; $slideTags[7]='install setup deploy'; $slideTopics[7]='Installation';
$slide[8]='Technical'; $slideName[8]='Technical (3)'; $slidePage['Technical3']='8'; $slideTags[8]='parameter'; $slideTopics[8]='Parameters1';
$slide[9]='Installation'; $slideName[9]='Installation'; $slidePage['Installation']='9'; $slideTags[9]='install setup deploy php mysql http server zip'; $slideTopics[9]='Configuration Parameters1 NewVersion Connection';
$slide[10]='Configuration'; $slideName[10]='Configuration'; $slidePage['Configuration']='10'; $slideTags[10]='install setup config parameter'; $slideTopics[10]='Installation Parameters1 NewVersion Connection';
$slide[11]='Parameters'; $slideName[11]='Parameters'; $slidePage['Parameters1']='11'; $slideTags[11]='config parameter install setup'; $slideTopics[11]='Installation Configuration NewVersion';
$slide[12]='Parameters'; $slideName[12]='Parameters (2)'; $slidePage['Parameters2']='12'; $slideTags[12]='config parameter install setup'; $slideTopics[12]='Installation Configuration NewVersion';
$slide[13]='Parameters'; $slideName[13]='Parameters (3)'; $slidePage['Parameters3']='13'; $slideTags[13]='config parameter install setup'; $slideTopics[13]='Installation Configuration NewVersion';
$slide[14]='Parameters'; $slideName[14]='Parameters (4)'; $slidePage['Parameters4']='14'; $slideTags[14]='config parameter install setup'; $slideTopics[14]='Installation Configuration NewVersion';
$slide[15]='Parameters'; $slideName[15]='Parameters (5)'; $slidePage['Parameters5']='15'; $slideTags[15]='config parameter install setup'; $slideTopics[15]='Installation Configuration NewVersion';
$slide[16]='NewVersion'; $slideName[16]='Install new version'; $slidePage['NewVersion']='16'; $slideTags[16]='install setup deploy php mysql http server zip new version release update'; $slideTopics[16]='Installation Configuration Parameters1';
$slide[17]='Connection'; $slideName[17]='Connection'; $slidePage['Connection']='17'; $slideTags[17]='connect login'; $slideTopics[17]='GuiGenerality Installation Configuration';
$slide[18]='GUI'; $slideName[18]='User interface'; $slidePage['GuiGenerality']='18'; $slideTags[18]='gui interface'; $slideTopics[18]='Themes GuiToolbar GuiMenu GuiQuickMenu GuiList GuiFilter GuiDetail GuiCombo GuiAlert GuiProject';
$slide[19]='GUI'; $slideName[19]='Toolbars'; $slidePage['GuiToolbar']='19'; $slideTags[19]='gui interface toolbar show hide switch help manual hyperlink logo external-shortcuts shortcuts'; $slideTopics[19]='Themes GuiGenerality GuiMenu GuiQuickMenu GuiList GuiFilter GuiDetail GuiCombo GuiAlert GuiProject';
$slide[20]='GUI'; $slideName[20]='Menu'; $slidePage['GuiMenu']='20'; $slideTags[20]='gui interface menu project combo'; $slideTopics[20]='Themes GuiGenerality GuiToolbar GuiQuickMenu GuiList GuiFilter GuiDetail GuiCombo GuiAlert GuiProject';
$slide[21]='GUI'; $slideName[21]='Quick Menu'; $slidePage['GuiQuickMenu']='21'; $slideTags[21]='gui interface menu project combo'; $slideTopics[21]='Themes GuiGenerality GuiToolbar GuiMenu GuiList GuiFilter GuiDetail GuiCombo GuiAlert GuiProject';
$slide[22]='GUI'; $slideName[22]='List'; $slidePage['GuiList']='22'; $slideTags[22]='gui interface list column'; $slideTopics[22]='Themes GuiGenerality GuiToolbar GuiMenu GuiQuickMenu GuiFilter GuiDetail GuiCombo GuiAlert GuiProject';
$slide[23]='GUI'; $slideName[23]='Filter'; $slidePage['GuiFilter']='23'; $slideTags[23]='gui interface filter complex'; $slideTopics[23]='Themes GuiGenerality GuiToolbar GuiMenu GuiQuickMenu GuiList GuiDetail GuiCombo GuiAlert GuiProject';
$slide[24]='GUI'; $slideName[24]='ListParameter'; $slidePage['GuiListParameters']='24'; $slideTags[24]='gui interface list order selection width'; $slideTopics[24]='Themes GuiGenerality GuiToolbar GuiMenu GuiQuickMenu GuiList GuiDetail GuiCombo GuiAlert GuiProject';
$slide[25]='GUI'; $slideName[25]='Detail'; $slidePage['GuiDetail']='25'; $slideTags[25]='gui interface detail item save print'; $slideTopics[25]='Themes GuiGenerality GuiToolbar GuiMenu GuiQuickMenu GuiList GuiFilter GuiCombo GuiAlert GuiProject';
$slide[26]='GUI'; $slideName[26]='Combo detail'; $slidePage['GuiCombo']='26'; $slideTags[26]='gui interface detail item save print combo list'; $slideTopics[26]='Themes GuiGenerality GuiToolbar GuiMenu GuiQuickMenu GuiList GuiFilter GuiDetail  GuiAlert GuiProject';
$slide[27]='GUI'; $slideName[27]='Alert'; $slidePage['GuiAlert']='27'; $slideTags[27]='gui interface detail item save print combo list alert info warning'; $slideTopics[27]='Themes GuiGenerality GuiToolbar GuiMenu GuiQuickMenu GuiList GuiFilter GuiDetail GuiCombo GuiProject';
$slide[28]='Themes'; $slideName[28]='Themes'; $slidePage['Themes']='28'; $slideTags[28]='theme color'; $slideTopics[28]='GuiGenerality ThemesTemplates';
$slide[29]='Themes'; $slideName[29]='Themes templates'; $slidePage['ThemesTemplates']='29'; $slideTags[29]='theme color example'; $slideTopics[29]='GuiGenerality Themes';
$slide[30]='Multilingual'; $slideName[30]='Multilingual'; $slidePage['Multilingual']='30'; $slideTags[30]='english french german translat multiling'; $slideTopics[30]='GuiGenerality Configuration Parameters1';
$slide[31]='Creation'; $slideName[31]='Creation'; $slidePage['Creation']='31'; $slideTags[31]='creation'; $slideTopics[31]='GuiGenerality Update Delete Copy';
$slide[32]='Update'; $slideName[32]='Update'; $slidePage['Update']='32'; $slideTags[32]='update'; $slideTopics[32]='GuiGenerality Creation Delete copy';
$slide[33]='Delete'; $slideName[33]='Delete'; $slidePage['Delete']='33'; $slideTags[33]='delete'; $slideTopics[33]='GuiGenerality Creation Update Copy';
$slide[34]='Copy'; $slideName[34]='Copy'; $slidePage['Copy']='34'; $slideTags[34]='copy'; $slideTopics[34]='GuiGenerality Creation Update Delete';
$slide[35]='SendMail'; $slideName[35]='Send mail'; $slidePage['SendMail']='35'; $slideTags[35]='mail email receivers'; $slideTopics[35]='GuiGenerality Mail AutomaticEmailing StatusMail IndicatorDefinition';
$slide[36]='MultipleUpdate'; $slideName[36]='Multiple Update'; $slidePage['MultipleUpdate']='36'; $slideTags[36]='multiple update several grouped'; $slideTopics[36]='GuiGenerality Update';
$slide[37]='Checklist'; $slideName[37]='Checklist'; $slidePage['Checklist']='37'; $slideTags[37]='checklist quality'; $slideTopics[37]='ChecklistDefinition';
$slide[38]='Export'; $slideName[38]='Export'; $slidePage['Export']='38'; $slideTags[38]='export csv'; $slideTopics[38]='Import';
$slide[39]='Today'; $slideName[39]='Today'; $slidePage['Today']='39'; $slideTags[39]='today summary todo message'; $slideTopics[39]='Message Project Ticket Activity Milestone Risk Action Issue';
$slide[40]='Today'; $slideName[40]='Today parameters'; $slidePage['TodayParameters']='40'; $slideTags[40]='today summary todo message'; $slideTopics[40]='Message Project Ticket Activity Milestone Risk Action Issue Report';
$slide[41]='Project'; $slideName[41]='Project'; $slidePage['Project']='41'; $slideTags[41]='project planning sub-project'; $slideTopics[41]='ProjectFields ProjectProgress ProjectAffectation ProjectDependencies GuiGenerality Creation Update Delete Planning';
$slide[42]='Project'; $slideName[42]='Project fields'; $slidePage['ProjectFields']='42'; $slideTags[42]='project planning sub-project hyperlink external-shortcuts shortcuts'; $slideTopics[42]='Project ProjectAffectation ProjectProgress ProjectDependencies GuiGenerality Creation Update Delete Planning Affectation Customer';
$slide[43]='Project'; $slideName[43]='Project affectations and versions'; $slidePage['ProjectAffectation']='43'; $slideTags[43]='project planning affectation version'; $slideTopics[43]='Project ProjectFields ProjectProgress ProjectDependencies GuiGenerality Creation Update Delete Planning';
$slide[44]='Project'; $slideName[44]='Project progress'; $slidePage['ProjectProgress']='44'; $slideTags[44]='project planning'; $slideTopics[44]='Project ProjectFields ProjectDependencies GuiGenerality Creation Update Delete Planning';
$slide[45]='Project'; $slideName[45]='Project dependencies'; $slidePage['ProjectDependencies']='45'; $slideTags[45]='project planning'; $slideTopics[45]='Project ProjectFields ProjectProgress ProjectAffectation GuiGenerality Creation Update Delete Planning';
$slide[46]='Document'; $slideName[46]='Document'; $slidePage['Document']='46'; $slideTags[46]='document directory file'; $slideTopics[46]='DocumentFields DocumentVersions DocumentDirectory DocumentApprovers Product Project';
$slide[47]='Document'; $slideName[47]='Document fields'; $slidePage['DocumentFields']='47'; $slideTags[47]='document directory file'; $slideTopics[47]='Document DocumentVersions DocumentDirectory DocumentApprovers Product Project LinkedElements';
$slide[48]='Document'; $slideName[48]='Document versions'; $slidePage['DocumentVersions']='48'; $slideTags[48]='document directory file version'; $slideTopics[48]='Document DocumentFields DocumentDirectory DocumentApprovers Product Project';
$slide[49]='Document'; $slideName[49]='Document approvers'; $slidePage['DocumentApprovers']='49'; $slideTags[49]='document directory file version approvers approve'; $slideTopics[49]='Document DocumentFields DocumentDirectory DocumentVersion Product Project';
$slide[50]='Ticket'; $slideName[50]='Ticket'; $slidePage['Ticket']='50'; $slideTags[50]='ticket bug task track'; $slideTopics[50]='TicketFields TicketSimple GuiGenerality Creation Update Delete TicketType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[51]='Ticket'; $slideName[51]='Ticket fields'; $slidePage['TicketFields']='51'; $slideTags[51]='ticket bug task track'; $slideTopics[51]='Ticket TicketSimple GuiGenerality Creation Update Delete TicketType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[52]='Ticket'; $slideName[52]='Ticket fields'; $slidePage['TicketFields2']='52'; $slideTags[52]='ticket bug task track work timer'; $slideTopics[52]='Ticket TicketSimple GuiGenerality Creation Update Delete TicketType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[53]='TicketSimple'; $slideName[53]='Simple Ticket'; $slidePage['TicketSimple']='53'; $slideTags[53]='ticket bug task track simple'; $slideTopics[53]='TicketSimpleFields Ticket GuiGenerality Creation Update Delete TicketType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[54]='TicketSimple'; $slideName[54]='Simple Ticket fields'; $slidePage['TicketSimpleFields']='54'; $slideTags[54]='ticket bug task track simple'; $slideTopics[54]='TicketSimple Ticket GuiGenerality Creation Update Delete TicketType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[55]='TicketSimple'; $slideName[55]='Simple Ticket fields'; $slidePage['TicketSimpleFields2']='55'; $slideTags[55]='ticket bug task track simple'; $slideTopics[55]='TicketSimple Ticket GuiGenerality Creation Update Delete TicketType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[56]='Activity'; $slideName[56]='Activity'; $slidePage['Activity']='56'; $slideTags[56]='activity task planning'; $slideTopics[56]='ActivityFields ActivityAssignment ActivityProgress ActivityDependencies GuiGenerality Creation Update Delete ActivityType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[57]='Activity'; $slideName[57]='Activity fields'; $slidePage['ActivityFields']='57'; $slideTags[57]='activity task planning'; $slideTopics[57]='Activity ActivityAssignement ActivityProgress ActivityDependencies GuiGenerality Creation Update Delete ActivityType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory Planning';
$slide[58]='Activity'; $slideName[58]='Activity assignment'; $slidePage['ActivityAssignement']='58'; $slideTags[58]='activity task planning assignment'; $slideTopics[58]='Activity ActivityFields ActivityProgress ActivityDependencies GuiGenerality Creation Update Delete ActivityType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[59]='Activity'; $slideName[59]='Activity progress'; $slidePage['ActivityProgress']='59'; $slideTags[59]='activity task planning progress'; $slideTopics[59]='Activity ActivityFields ActivityAssignment ActivityDependencies GuiGenerality Creation Update Delete ActivityType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[60]='Activity'; $slideName[60]='Activity dependency'; $slidePage['ActivityDependencies']='60'; $slideTags[60]='activity task planning'; $slideTopics[60]='Activity ActivityFields ActivityAssignment ActivityProgress GuiGenerality Creation Update Delete ActivityType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[61]='Milestone'; $slideName[61]='Milestone'; $slidePage['Milestone']='61'; $slideTags[61]='milestone flag '; $slideTopics[61]='MilestoneFields MilestoneProgress MilestoneDependencies GuiGenerality Creation Update Delete MilestoneType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[62]='Milestone'; $slideName[62]='Milestone fields'; $slidePage['MilestoneFields']='62'; $slideTags[62]='milestone flag '; $slideTopics[62]='Milestone MilestoneProgress MilestoneDependencies GuiGenerality Creation Update Delete MilestoneType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory Planning';
$slide[63]='Milestone'; $slideName[63]='Milestone progress'; $slidePage['MilestoneProgress']='63'; $slideTags[63]='milestone flag '; $slideTopics[63]='Milestone MilestoneFields MilestoneDependencies GuiGenerality Creation Update Delete MilestoneType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[64]='Milestone'; $slideName[64]='Milestone dependencies'; $slidePage['MilestoneDependencies']='64'; $slideTags[64]='milestone flag '; $slideTopics[64]='Milestone MilestoneFields MilestoneProgress GuiGenerality Creation Update Delete MilestoneType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[65]='Action'; $slideName[65]='Action'; $slidePage['Action']='65'; $slideTags[65]='risk action issue'; $slideTopics[65]='ActionFields Risk Issue GuiGenerality Creation Update Delete ActionType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[66]='Action'; $slideName[66]='Action fields'; $slidePage['ActionFields']='66'; $slideTags[66]='risk action issue'; $slideTopics[66]='Action Risk Issue GuiGenerality Creation Update Delete ActionType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[67]='Imputation'; $slideName[67]='Real work allocation'; $slidePage['Imputation']='67'; $slideTags[67]='imputation work follow-up allocation'; $slideTopics[67]='Activity ActivityAssignement Planning Resource Project Affectation';
$slide[68]='Planning'; $slideName[68]='Planning'; $slidePage['Planning1']='68'; $slideTags[68]='planning work plan date calculation gantt'; $slideTopics[68]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[69]='Planning'; $slideName[69]='Planning (2)'; $slidePage['Planning2']='69'; $slideTags[69]='planning work plan date calculation gantt'; $slideTopics[69]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[70]='Planning'; $slideName[70]='Planning (3)'; $slidePage['Planning3']='70'; $slideTags[70]='planning work plan date calculation gantt'; $slideTopics[70]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[71]='Planning'; $slideName[71]='Planning (4)'; $slidePage['Planning4']='71'; $slideTags[71]='planning work plan date calculation gantt'; $slideTopics[71]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[72]='Planning'; $slideName[72]='Planning (5)'; $slidePage['Planning5']='72'; $slideTags[72]='planning work plan date calculation gantt'; $slideTopics[72]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[73]='PortfolioPlanning'; $slideName[73]='Projects portfolio'; $slidePage['PortfolioPlanning']='73'; $slideTags[73]='planning gantt portfolio'; $slideTopics[73]='Planning';
$slide[74]='ResourcePlanning'; $slideName[74]='Resource Planning'; $slidePage['ResourcePlanning']='74'; $slideTags[74]='planning work plan date calculation gantt resource'; $slideTopics[74]='ActivityAssignement ActivityProgress ActivityDependencies Planning';
$slide[75]='Diary'; $slideName[75]='Diary'; $slidePage['Diary']='75'; $slideTags[75]='planning diary calendar'; $slideTopics[75]='Planning';
$slide[76]='Report'; $slideName[76]='Report'; $slidePage['Report']='76'; $slideTags[76]='parameter report print '; $slideTopics[76]='';
$slide[77]='Requirement'; $slideName[77]='Requirement'; $slidePage['Requirement']='77'; $slideTags[77]='requirement'; $slideTopics[77]='RequirementFields TestCase TestSession GuiGenerality Creation Update Delete RequirementType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[78]='Requirement'; $slideName[78]='Requirement fields'; $slidePage['RequirementFields']='78'; $slideTags[78]='requirement'; $slideTopics[78]='Requirement TestCase TestSession GuiGenerality Creation Update Delete RequirementType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[79]='Requirement'; $slideName[79]='Requirement fields'; $slidePage['RequirementFields2']='79'; $slideTags[79]='requirement'; $slideTopics[79]='Requirement TestCase TestSession GuiGenerality Creation Update Delete RequirementType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[80]='TestCase'; $slideName[80]='Test case'; $slidePage['TestCase']='80'; $slideTags[80]='test case'; $slideTopics[80]='TestCaseFields Requirement TestSession GuiGenerality Creation Update Delete TestCaseType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[81]='TestCase'; $slideName[81]='Test case fields'; $slidePage['TestCaseFields']='81'; $slideTags[81]='test case'; $slideTopics[81]='TestCase Requirement TestSession GuiGenerality Creation Update Delete TestCaseType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[82]='TestCase'; $slideName[82]='Test case fields'; $slidePage['TestCaseFields2']='82'; $slideTags[82]='test case'; $slideTopics[82]='TestCase Requirement TestSession GuiGenerality Creation Update Delete TestCaseType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[83]='TestSession'; $slideName[83]='Test session'; $slidePage['TestSession']='83'; $slideTags[83]='test session'; $slideTopics[83]='TestSessionFields Requirement TestCase GuiGenerality Creation Update Delete TestCaseType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[84]='TestSession'; $slideName[84]='Test session fields'; $slidePage['TestSessionFields']='84'; $slideTags[84]='test session'; $slideTopics[84]='TestSession Requirement TestCase GuiGenerality Creation Update Delete TestCaseType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[85]='TestSession'; $slideName[85]='Test session fields'; $slidePage['TestSessionFields2']='85'; $slideTags[85]='test session'; $slideTopics[85]='TestSession Requirement TestCase GuiGenerality Creation Update Delete TestCaseType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[86]='Quotation'; $slideName[86]='Quotation'; $slidePage['Quotation']='86'; $slideTags[86]='quotation proposal estimate'; $slideTopics[86]='Order Creation Update Delete';
$slide[87]='Quotation'; $slideName[87]='Quotation fields'; $slidePage['QuotationFields']='87'; $slideTags[87]='quotation proposal estimate'; $slideTopics[87]='Order Creation Update Delete';
$slide[88]='Command'; $slideName[88]='Order'; $slidePage['Command']='88'; $slideTags[88]='order bill command'; $slideTopics[88]='Activity Quotation';
$slide[89]='Command'; $slideName[89]='Order fields'; $slidePage['CommandFields']='89'; $slideTags[89]='order bill command'; $slideTopics[89]='Activity Quotation';
$slide[90]='IndividualExpense'; $slideName[90]='Individual expense'; $slidePage['IndividualExpense']='90'; $slideTags[90]='expense cost travel '; $slideTopics[90]='IndividualExpenseFields IndividualExpenseDetails ProjectExpense';
$slide[91]='IndividualExpense'; $slideName[91]='Individual expense fields'; $slidePage['IndividualExpenseFields']='91'; $slideTags[91]='expense cost travel '; $slideTopics[91]='IndividualExpense IndividualExpenseDetails ProjectExpense';
$slide[92]='IndividualExpense'; $slideName[92]='Individual expense details'; $slidePage['IndividualExpenseDetails']='92'; $slideTags[92]='expense cost travel detail'; $slideTopics[92]='IndividualExpenseFields IndividualExpense ProjectExpense';
$slide[93]='ProjectExpense'; $slideName[93]='Project expense'; $slidePage['ProjectExpense']='93'; $slideTags[93]='expense'; $slideTopics[93]='ProjectExpenseFields IndividualExpense';
$slide[94]='ProjectExpense'; $slideName[94]='Project expense fields'; $slidePage['ProjectExpenseFields']='94'; $slideTags[94]='expense'; $slideTopics[94]='ProjectExpense IndividualExpense';
$slide[95]='Term'; $slideName[95]='Term'; $slidePage['Term']='95'; $slideTags[95]='term trigger bill fixed price'; $slideTopics[95]='TermFileds Bill';
$slide[96]='Term'; $slideName[96]='Term fields'; $slidePage['TermFields']='96'; $slideTags[96]='term trigger bill fixed price'; $slideTopics[96]='Term Bill';
$slide[97]='Bill'; $slideName[97]='Bill'; $slidePage['Bill']='97'; $slideTags[97]='bill billing'; $slideTopics[97]='Term Bill ActivityPrice BillingType BillType';
$slide[98]='Bill'; $slideName[98]='Bill fields'; $slidePage['BillFields']='98'; $slideTags[98]='bill billing'; $slideTopics[98]='Term Bill ActivityPrice BillingType BillType Recipient Contact';
$slide[99]='Bill'; $slideName[99]='Bill lines'; $slidePage['BillLines']='99'; $slideTags[99]='bill billing'; $slideTopics[99]='Term Bill ActivityPrice BillingType BillType';
$slide[100]='ActivityPrice'; $slideName[100]='Activity price'; $slidePage['ActivityPrice']='100'; $slideTags[100]='activity price bill billing'; $slideTopics[100]='Activity ActivityType BillingType';
$slide[101]='Risk'; $slideName[101]='Risk'; $slidePage['Risk']='101'; $slideTags[101]='risk action issue opportunity'; $slideTopics[101]='RiskFields Action Issue Opportunity GuiGenerality Creation Update Delete RiskType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[102]='Risk'; $slideName[102]='Risk fields'; $slidePage['RiskFields']='102'; $slideTags[102]='risk action issue opportunity'; $slideTopics[102]='Risk Action Issue Opportunity GuiGenerality Creation Update Delete RiskType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[103]='Opportunity'; $slideName[103]='Opportunity'; $slidePage['Opportunity']='103'; $slideTags[103]='opportunity risk action issue'; $slideTopics[103]='OpportunityFields Risk Action Issue GuiGenerality Creation Update Delete RiskType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[104]='Opportunity'; $slideName[104]='Opportunity fields'; $slidePage['OpportunityFields']='104'; $slideTags[104]='opportunity risk action issue'; $slideTopics[104]='Opportunity Risk Action Issue GuiGenerality Creation Update Delete RiskType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[105]='Issue'; $slideName[105]='Issue'; $slidePage['Issue']='105'; $slideTags[105]='risk action issue'; $slideTopics[105]='IssueFields IssueDependencies Risk Action GuiGenerality Creation Update Delete IssueType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[106]='Issue'; $slideName[106]='Issue fields'; $slidePage['IssueFields']='106'; $slideTags[106]='risk action issue'; $slideTopics[106]='Issue IssueDependencies Risk Action GuiGenerality Creation Update Delete IssueType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[107]='Meeting'; $slideName[107]='Meeting'; $slidePage['Meeting']='107'; $slideTags[107]='meeting workshop steering committee invitation attendees'; $slideTopics[107]='MeetingFields MeetingDependencies Question Decision GuiGenerality Creation Update Delete MeetingType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[108]='Meeting'; $slideName[108]='Meeting fields'; $slidePage['MeetingFields']='108'; $slideTags[108]='meeting workshop steering committee'; $slideTopics[108]='Meeting MeetingDependencies Question Decision GuiGenerality Creation Update Delete MeetingType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[109]='PeriodicMeeting'; $slideName[109]='Periodic meeting'; $slidePage['PeriodicMeeting']='109'; $slideTags[109]='meeting workshop steering committee invitation attendees periodic'; $slideTopics[109]='PeriodicMeetingFields Meeting MeetingType';
$slide[110]='PeriodicMeeting'; $slideName[110]='Periodic meeting fields'; $slidePage['PeriodicMeetingFields']='110'; $slideTags[110]='meeting workshop steering committee periodic'; $slideTopics[110]='PeriodicMeeting Meeting MeetingType';
$slide[111]='Decision'; $slideName[111]='Decision'; $slidePage['Decision']='111'; $slideTags[111]='decision'; $slideTopics[111]='DecisionFields DecisionDependencies Meeting GuiGenerality Creation Update Delete DecisionType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[112]='Decision'; $slideName[112]='Decision fields'; $slidePage['DecisionFields']='112'; $slideTags[112]='decision'; $slideTopics[112]='Decision DecisionDependencies Meeting GuiGenerality Creation Update Delete DecisionType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[113]='Question'; $slideName[113]='Question'; $slidePage['Question']='113'; $slideTags[113]='question answer'; $slideTopics[113]='QuestionFields QuestionDependencies Meeting GuiGenerality Creation Update Delete QuestionType Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[114]='Question'; $slideName[114]='Question fields'; $slidePage['QuestionFields']='114'; $slideTags[114]='question answer'; $slideTopics[114]='Question QuestionDependencies Meeting GuiGenerality Creation Update Delete QuestionType Status AutomaticEmailing Workflow LinkedElements Attachments Notes ChangeHistory';
$slide[115]='Mail'; $slideName[115]='Emails'; $slidePage['Mail']='115'; $slideTags[115]='email mail'; $slideTopics[115]='AutomaticEmailing SendMail';
$slide[116]='Alert'; $slideName[116]='Alerts'; $slidePage['Alert']='116'; $slideTags[116]='alert warning information indicator'; $slideTopics[116]='GuiAlert IndicatorDefinition';
$slide[117]='Message'; $slideName[117]='Message'; $slidePage['Message']='117'; $slideTags[117]='message alert'; $slideTopics[117]='User Project Profile Today';
$slide[118]='Import'; $slideName[118]='Import'; $slidePage['Import']='118'; $slideTags[118]='import load csv xlsx'; $slideTopics[118]='AutomaticImport Export';
$slide[119]='Import'; $slideName[119]='Import Run'; $slidePage['ImportRun']='119'; $slideTags[119]='import load'; $slideTopics[119]='AutomaticImport Ticket Activity Milestone Risk Action Issue Meeting Decision Question Project Resource';
$slide[120]='AutomaticImport'; $slideName[120]='Automatic Import'; $slidePage['AutomaticImport']='120'; $slideTags[120]='automatic automated import cron'; $slideTopics[120]='Import GlobalParameter';
$slide[121]='Affectation'; $slideName[121]='Affectation'; $slidePage['Affectation']='121'; $slideTags[121]='affectation resource contact user project'; $slideTopics[121]='GuiGenerality Resource Contact User Project';
$slide[122]='User'; $slideName[122]='User'; $slidePage['User']='122'; $slideTags[122]='contact resource user login password'; $slideTopics[122]='GuiGenerality Contact Resource UserAffectation';
$slide[123]='User'; $slideName[123]='User affectations'; $slidePage['UserAffectation']='123'; $slideTags[123]='contact resource user login password affectation'; $slideTopics[123]='GuiGenerality Contact Resource User';
$slide[124]='Resource'; $slideName[124]='Resource description'; $slidePage['Resource']='124'; $slideTags[124]='resource capacity affectation'; $slideTopics[124]='ResourceCost GuiGenerality User Contact Team Planning Affectation';
$slide[125]='Resource'; $slideName[125]='Resource function cost & affectation'; $slidePage['ResourceCost']='125'; $slideTags[125]='resource capacity affectation cost'; $slideTopics[125]='GuiGenerality User Contact Team Planning Affectation Resource';
$slide[126]='Contact'; $slideName[126]='Contact'; $slidePage['Contact']='126'; $slideTags[126]='contact customer requestor'; $slideTopics[126]='Client User GuiGenerality Creation Update Delete AutomaticEmailing ContactAffectation';
$slide[127]='Contact'; $slideName[127]='Contact affectations'; $slidePage['ContactAffectation']='127'; $slideTags[127]='contact customer requestor affectation'; $slideTopics[127]='Client User GuiGenerality Creation Update Delete AutomaticEmailing Contact';
$slide[128]='Client'; $slideName[128]='Customer'; $slidePage['Client']='128'; $slideTags[128]='client customer contact'; $slideTopics[128]='Contact Project GuiGenerality Creation Update Delete';
$slide[129]='Recipient'; $slideName[129]='Recipient'; $slidePage['Recipient']='129'; $slideTags[129]='recipient bill'; $slideTopics[129]='Bill';
$slide[130]='Team'; $slideName[130]='Team'; $slidePage['Team']='130'; $slideTags[130]='team resource affectation'; $slideTopics[130]='GuiGenerality Resource';
$slide[131]='Product'; $slideName[131]='Product'; $slidePage['Product']='131'; $slideTags[131]='product version'; $slideTopics[131]='Version Project Customer Contact';
$slide[132]='Version'; $slideName[132]='Version'; $slidePage['Version']='132'; $slideTags[132]='product version'; $slideTopics[132]='Product Project Customer Contact';
$slide[133]='Context'; $slideName[133]='Context'; $slidePage['Context']='133'; $slideTags[133]='context environment os browser'; $slideTopics[133]='Ticket TranslatableName';
$slide[134]='Calendar'; $slideName[134]='Calendar'; $slidePage['Calendar']='134'; $slideTags[134]='calendar off open closed day'; $slideTopics[134]='GuiGenerality Planning';
$slide[135]='Calendar'; $slideName[135]='Calendar description'; $slidePage['CalendarDescription']='135'; $slideTags[135]='calendar off open closed day'; $slideTopics[135]='GuiGenerality Planning';
$slide[136]='DocumentDirectory'; $slideName[136]='Document directory'; $slidePage['DocumentDirectory']='136'; $slideTags[136]='document directory folder place'; $slideTopics[136]='Document';
$slide[137]='Role'; $slideName[137]='Function'; $slidePage['Role']='137'; $slideTags[137]='function resource cost'; $slideTopics[137]='GuiGenerality Resource';
$slide[138]='Status'; $slideName[138]='Status'; $slidePage['Status']='138'; $slideTags[138]='status workflow lifecycle'; $slideTopics[138]='Workflow Ticket Activity Milestone Risk Action Issue Meeting Decision Question GuiGenerality';
$slide[139]='Quality'; $slideName[139]='Quality level'; $slidePage['Quality']='139'; $slideTags[139]='quality'; $slideTopics[139]='Project Today';
$slide[140]='HealthStatus'; $slideName[140]='Health Status'; $slidePage['HealthStatus']='140'; $slideTags[140]='health'; $slideTopics[140]='Project Today';
$slide[141]='OverallProgress'; $slideName[141]='Overall Progress'; $slidePage['OverallProgress']='141'; $slideTags[141]='progress'; $slideTopics[141]='Project Today';
$slide[142]='Trend'; $slideName[142]='Trend'; $slidePage['Trend']='142'; $slideTags[142]='trend'; $slideTopics[142]='Project Today';
$slide[143]='Likelihood'; $slideName[143]='Likelihood'; $slidePage['Likelihood']='143'; $slideTags[143]='likelihood probability'; $slideTopics[143]='GuiGenerality criticality severity risk';
$slide[144]='Criticality'; $slideName[144]='Criticality'; $slidePage['Criticality']='144'; $slideTags[144]='criticality'; $slideTopics[144]='GuiGenerality risk ticket likelihood severity priority urgency';
$slide[145]='Severity'; $slideName[145]='Severity'; $slidePage['Severity']='145'; $slideTags[145]='severity'; $slideTopics[145]='GuiGenerality risk criticality likelihood';
$slide[146]='Urgency'; $slideName[146]='Urgency'; $slidePage['Urgency']='146'; $slideTags[146]='urgency priority'; $slideTopics[146]='GuiGenerality ticket priority criticality';
$slide[147]='Priority'; $slideName[147]='Priority'; $slidePage['Priority']='147'; $slideTags[147]='priority urgency'; $slideTopics[147]='GuiGenerality urgency criticality ticket';
$slide[148]='RiskLevel'; $slideName[148]='Risk level'; $slidePage['RiskLevel']='148'; $slideTags[148]='risk level'; $slideTopics[148]='GuiGenerality';
$slide[149]='Feasibility'; $slideName[149]='Feasibility'; $slidePage['Feasibility']='149'; $slideTags[149]='feasibility'; $slideTopics[149]='GuiGenerality';
$slide[150]='Efficiency'; $slideName[150]='Efficiency'; $slidePage['Efficiency']='150'; $slideTags[150]='efficiency'; $slideTopics[150]='GuiGenerality Action';
$slide[151]='PredefinedNote'; $slideName[151]='Predefined note'; $slidePage['PredefinedNote']='151'; $slideTags[151]='predefined note text'; $slideTopics[151]='Notes';
$slide[152]='Workflow'; $slideName[152]='Workflow description'; $slidePage['Workflow']='152'; $slideTags[152]='workflow status'; $slideTopics[152]='Status Ticket Activity Milestone Risk Action Issue Meeting Decision Question GuiGenerality';
$slide[153]='Workflow'; $slideName[153]='Workflow table'; $slidePage['WorkflowTable']='153'; $slideTags[153]='workflow status'; $slideTopics[153]='Status Ticket Activity Milestone Risk Action Issue Meeting Decision Question GuiGenerality';
$slide[154]='StatusMail'; $slideName[154]='Mail on events'; $slidePage['StatusMail']='154'; $slideTags[154]='mail emailing status'; $slideTopics[154]='GuiGenerality Mail Status AutomaticEmailing ReplyToEmails SendMail';
$slide[155]='ReplyToEmail'; $slideName[155]='Reply to emails'; $slidePage['ReplyToEmail']='155'; $slideTags[155]='mail emailing reply'; $slideTopics[155]='GuiGenerality MailAutomaticEmailing';
$slide[156]='TicketDelay'; $slideName[156]='Delay for tickets'; $slidePage['TicketDelay']='156'; $slideTags[156]='delay ticket'; $slideTopics[156]='GuiGenerality Ticket';
$slide[157]='IndicatorDefinition'; $slideName[157]='Indicator'; $slidePage['IndicatorDefinition']='157'; $slideTags[157]='delay indicator alert warning'; $slideTopics[157]='Status Ticket Activity Milestone Risk Action Issue Meeting Decision Question GuiGenerality SendMail';
$slide[158]='ChecklistDefinition'; $slideName[158]='Checklist definition'; $slidePage['ChecklistDefinition']='158'; $slideTags[158]='checklist quality'; $slideTopics[158]='Checklist';
$slide[159]='ProjectType'; $slideName[159]='Project type'; $slidePage['ProjectType']='159'; $slideTags[159]='project type template administrative operational billing'; $slideTopics[159]='Project Bill';
$slide[160]='TicketType'; $slideName[160]='Ticket type'; $slidePage['TicketType']='160'; $slideTags[160]='type ticket'; $slideTopics[160]='Ticket GuiGenerality';
$slide[161]='ActivityType'; $slideName[161]='Activity type'; $slidePage['ActivityType']='161'; $slideTags[161]='activity type'; $slideTopics[161]='Activity GuiGenerality';
$slide[162]='MilestoneType'; $slideName[162]='Milestone type'; $slidePage['MilestoneType']='162'; $slideTags[162]='milestone type'; $slideTopics[162]='Milestone GuiGenerality';
$slide[163]='QuotationType'; $slideName[163]='Quotation type'; $slidePage['MilestoneType']='163'; $slideTags[163]='quotation type'; $slideTopics[163]='Order Bill GuiGenerality';
$slide[164]='CommandType'; $slideName[164]='Order type'; $slidePage['CommandType']='164'; $slideTags[164]='order type'; $slideTopics[164]='Quotation Bill GuiGenerality';
$slide[165]='IndividualExpenseType'; $slideName[165]='Individual expense type'; $slidePage['IndividualExpenseType']='165'; $slideTags[165]='expense type'; $slideTopics[165]='IndividualExpense GuiGenerality';
$slide[166]='ProjectExpenseType'; $slideName[166]='Project expensetype'; $slidePage['ProjectExpenseType']='166'; $slideTags[166]='expense type'; $slideTopics[166]='ProjectExpense GuiGenerality';
$slide[167]='ExpenseDetailType'; $slideName[167]='Expense detail type'; $slidePage['ExpenseDetailType']='167'; $slideTags[167]='expense type'; $slideTopics[167]='IndividualExpense ProjectExpense GuiGenerality';
$slide[168]='BillType'; $slideName[168]='Bill type'; $slidePage['BillType']='168'; $slideTags[168]='bill type'; $slideTopics[168]='Bill GuiGenerality Creation Update Delete';
$slide[169]='RiskType'; $slideName[169]='Risk type'; $slidePage['RiskType']='169'; $slideTags[169]='risk type'; $slideTopics[169]='Risk GuiGenerality Creation Update Delete';
$slide[170]='RiskType'; $slideName[170]='Opportunity type'; $slidePage['Opportunity Type']='170'; $slideTags[170]='opportunity type'; $slideTopics[170]='Opportunity GuiGenerality Creation Update Delete';
$slide[171]='ActionType'; $slideName[171]='Action type'; $slidePage['ActionType']='171'; $slideTags[171]='action type'; $slideTopics[171]='Action GuiGenerality Creation Update Delete';
$slide[172]='IssueType'; $slideName[172]='Issue type'; $slidePage['IssueType']='172'; $slideTags[172]='issue type'; $slideTopics[172]='Issue GuiGenerality Creation Update Delete';
$slide[173]='MeetingType'; $slideName[173]='Meeting type'; $slidePage['MeetingType']='173'; $slideTags[173]='meeting type'; $slideTopics[173]='Meeting GuiGenerality Creation Update Delete';
$slide[174]='DecisionType'; $slideName[174]='Decision type'; $slidePage['DecisionType']='174'; $slideTags[174]='decision type'; $slideTopics[174]='Decision GuiGenerality Creation Update Delete';
$slide[175]='QuestionType'; $slideName[175]='Question type'; $slidePage['QuestionType']='175'; $slideTags[175]='question type'; $slideTopics[175]='Question GuiGenerality Creation Update Delete';
$slide[176]='MessageType'; $slideName[176]='Message type'; $slidePage['MessageType']='176'; $slideTags[176]='message type'; $slideTopics[176]='Message GuiGenerality Creation Update Delete';
$slide[177]='DocumentType'; $slideName[177]='Document type'; $slidePage['DocumentType']='177'; $slideTags[177]='document type'; $slideTopics[177]='Document GuiGenerality Creation Update Delete';
$slide[178]='ContextType'; $slideName[178]='Context type'; $slidePage['ContextType']='178'; $slideTags[178]='context type'; $slideTopics[178]='Context GuiGenerality Creation Update Delete';
$slide[179]='RequirementType'; $slideName[179]='Requirement type'; $slidePage['RequirementType']='179'; $slideTags[179]='requirement type'; $slideTopics[179]='Requirement GuiGenerality Creation Update Delete';
$slide[180]='TestCaseType'; $slideName[180]='Test case type'; $slidePage['TestCaseType']='180'; $slideTags[180]='test case type'; $slideTopics[180]='TestCase GuiGenerality Creation Update Delete';
$slide[181]='TestSessionType'; $slideName[181]='Test session type'; $slidePage['TestSessionType']='181'; $slideTags[181]='test session type'; $slideTopics[181]='TestSession GuiGenerality Creation Update Delete';
$slide[182]='ClientType'; $slideName[182]='customer type'; $slidePage['ClientType']='182'; $slideTags[182]='customer type'; $slideTopics[182]='Client GuiGenerality Creation Update Delete';
$slide[183]='Profile'; $slideName[183]='Profile'; $slidePage['Profile']='183'; $slideTags[183]='connection profile'; $slideTopics[183]='TranslatableName User';
$slide[184]='AccessProfile'; $slideName[184]='Access mode'; $slidePage['AccessProfile']='184'; $slideTags[184]='access mode read write update delete'; $slideTopics[184]='TranslatableName User Resource Profile';
$slide[185]='Habilitation'; $slideName[185]='Access to forms'; $slidePage['Habilitation']='185'; $slideTags[185]='ticket bug task track habilitation'; $slideTopics[185]='Profile AccessRight';
$slide[186]='HabilitationReport'; $slideName[186]='Access to reports'; $slidePage['HabilitationReport']='186'; $slideTags[186]='access report rights'; $slideTopics[186]='Profile';
$slide[187]='AccessRight'; $slideName[187]='Access mode to data'; $slidePage['AccessMode']='187'; $slideTags[187]='access screen form rights'; $slideTopics[187]='Profile Habilitation';
$slide[188]='HabilitationOther'; $slideName[188]='Specific access mode'; $slidePage['HabilitationOther']='188'; $slideTags[188]='access specific'; $slideTopics[188]='User Profile GuiCombo';
$slide[189]='HabilitationOther'; $slideName[189]='Specific access mode'; $slidePage['HabilitationOther2']='189'; $slideTags[189]='access specific'; $slideTopics[189]='User Profile GuiCombo';
$slide[190]='Administration'; $slideName[190]='Administration'; $slidePage['Administration']='190'; $slideTags[190]='administration cron maintenance purge'; $slideTopics[190]='';
$slide[191]='Audit'; $slideName[191]='Audit connections'; $slidePage['Audit']='191'; $slideTags[191]='connections who_is_online'; $slideTopics[191]='';
$slide[192]='GlobalParameter'; $slideName[192]='Global parameters'; $slidePage['GlobalParameter']='192'; $slideTags[192]='parameters work hour day unit planning responsible'; $slideTopics[192]='';
$slide[193]='GlobalParameter'; $slideName[193]='Global parameters'; $slidePage['GlobalParameter2']='193'; $slideTags[193]='parameters user password ldap'; $slideTopics[193]='';
$slide[194]='GlobalParameter'; $slideName[194]='Global parameters'; $slidePage['GlobalParameter3']='194'; $slideTags[194]='parameters format reference localization internationalizatin language'; $slideTopics[194]='';
$slide[195]='GlobalParameter'; $slideName[195]='Global parameters'; $slidePage['GlobalParameter4']='195'; $slideTags[195]='parameters icons theme files directories billing'; $slideTopics[195]='';
$slide[196]='GlobalParameter'; $slideName[196]='Global parameters'; $slidePage['GlobalParameter5']='196'; $slideTags[196]='parameters cron email'; $slideTopics[196]='';
$slide[197]='GlobalParameter'; $slideName[197]='Global parameters'; $slidePage['GlobalParameter6']='197'; $slideTags[197]='parameters email'; $slideTopics[197]='';
$slide[198]='GlobalParameter'; $slideName[198]='Global parameters'; $slidePage['GlobalParameter7']='198'; $slideTags[198]='parameters email'; $slideTopics[198]='';
$slide[199]='UserParameter'; $slideName[199]='User parameters'; $slidePage['UserParameter']='199'; $slideTags[199]='parameters'; $slideTopics[199]='';
$slide[200]='TranslatableName'; $slideName[200]='Translatable name'; $slidePage['translatableName']='200'; $slideTags[200]='translatable translation name profile'; $slideTopics[200]='AccessProfile ConnectionProfile ';
$slide[201]='AutomaticEmailing'; $slideName[201]='Automatic emailing'; $slidePage['AutomaticEmailing']='201'; $slideTags[201]='automatic email mail'; $slideTopics[201]='Mail SendMail Status GuiGenerality Creation Update Delete';
$slide[202]='API'; $slideName[202]='api'; $slidePage['api']='202'; $slideTags[202]='api'; $slideTopics[202]='';
$slide[203]='API'; $slideName[203]='call api'; $slidePage['apiUrl']='203'; $slideTags[203]='api url GET POST PUT DELETE'; $slideTopics[203]='';
$slide[204]='API'; $slideName[204]='api example'; $slidePage['apiCode1']='204'; $slideTags[204]='api example code'; $slideTopics[204]='';
$slide[205]='API'; $slideName[205]='api example'; $slidePage['apiCode2']='205'; $slideTags[205]='api example code'; $slideTopics[205]='';
$slide[206]='LinkedElements'; $slideName[206]='Linked elements'; $slidePage['LinkedElements']='206'; $slideTags[206]='link linked'; $slideTopics[206]='';
$slide[207]='Attachments'; $slideName[207]='Attachments'; $slidePage['Attachments']='207'; $slideTags[207]='attach file link privacy'; $slideTopics[207]='Ticket Activity Milestone Risk Issue Meeting Decision Question Parameters4 UserParameters';
$slide[208]='Notes'; $slideName[208]='Notes'; $slidePage['Notes']='208'; $slideTags[208]='note comment privacy predefined'; $slideTopics[208]='Ticket Activity Milestone Risk Action Issue Meeting Decision Question UserParameters';
$slide[209]='ChangeHistory'; $slideName[209]='Change history'; $slidePage['ChangeHistory']='209'; $slideTags[209]='change history track update'; $slideTopics[209]='UserParameters';
$slide[210]='Backup'; $slideName[210]='Backup / Restore'; $slidePage['Backup']='210'; $slideTags[210]='backup restore'; $slideTopics[210]='';
$slide[211]='Shortcuts'; $slideName[211]='Shortcuts'; $slidePage['Shortcuts']='211'; $slideTags[211]='shortcut key'; $slideTopics[211]='';
$slide[212]='LastWords'; $slideName[212]='Last words'; $slidePage['LastWords']='212'; $slideTags[212]='murphy hofstader history version'; $slideTopics[212]='';

if (! isset($includeManual)) {
  foreach ($slide as $id=>$name) {
    echo 'slide[' . $id . ']=' . $name . '<br/>';
  }
}

$prec='';
foreach ($slide as $id=>$name) {
  if (substr($name,0,2)=='X ') {
    unset($slide[$id]);
    unset($slideName[$id]);
    unset($slidePage[$id]);
    unset($slideTags[$id]);
    unset($slideTopics[$id]);
  } else {
    if ($name!=$prec) {
      $section[$id]=$name;
      $sectionName[$name]=$slideName[$id];
      $prec=$name;
    }
  }
}
$tags=array();
foreach ($slideTags as $id=>$name) {
 $split=explode(" ",$name);
 foreach ($split as $tag) {
   if (trim($tag) and !array_key_exists($tag, $tags)) {
     $tags[$tag]=array();
   }
   $tags[$tag][]=$id;
 }
}
ksort($tags);
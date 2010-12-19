<?php
$section=array();
$sectionName=array();
$topics=array();
$tags=array();
$page=array();
$slideRoot='img';
$slideExt='.png';

$slide[0]='Welcome '; $slideName[0]='Welcome'; $slidePage['Welcome']='0'; $slideTags[0]=''; $slideTopics[0]='Planning Risk Ticket';
$slide[1]='Functional'; $slideName[1]='Functional '; $slidePage['Functional1']='1'; $slideTags[1]='functional'; $slideTopics[1]='Ticket Activity Milestone Planning Report';
$slide[2]='Functional'; $slideName[2]='Functional'; $slidePage['Functional2']='2'; $slideTags[2]='functional'; $slideTopics[2]='Risk Action Issue Meeting Decision Question Message Import Client User Resource AccessRight';
$slide[3]='Functional'; $slideName[3]='Functional'; $slidePage['Functional3']='3'; $slideTags[3]='functional'; $slideTopics[3]='AccessProfile GuiFilter';
$slide[4]='Technical'; $slideName[4]='Technical'; $slidePage['Technical1']='4'; $slideTags[4]='technical gui interface ajax browser'; $slideTopics[4]='GuiGenerality';
$slide[5]='Technical'; $slideName[5]='Technical'; $slidePage['Technical2']='5'; $slideTags[5]='install setup deploy'; $slideTopics[5]='Installation';
$slide[6]='Technical'; $slideName[6]='Technical'; $slidePage['Technical3']='6'; $slideTags[6]='param'; $slideTopics[6]='Parameters1';
$slide[7]='Installation'; $slideName[7]='Installation'; $slidePage['Installation']='7'; $slideTags[7]='install setup deploy php mysql http server zip'; $slideTopics[7]='Configuration Parameters1 NewVersion Connection';
$slide[8]='Configuration'; $slideName[8]='Configuration'; $slidePage['Configuration']='8'; $slideTags[8]='install setup config param'; $slideTopics[8]='Installation Parameters1 NewVersion Connection';
$slide[9]='Parameters'; $slideName[9]='Parameters'; $slidePage['Parameters1']='9'; $slideTags[9]='config param'; $slideTopics[9]='Installation Configuration NewVersion';
$slide[10]='Parameters'; $slideName[10]='Parameters'; $slidePage['Parameters2']='10'; $slideTags[10]='config param'; $slideTopics[10]='Installation Configuration NewVersion';
$slide[11]='Parameters'; $slideName[11]='Parameters'; $slidePage['Parameters3']='11'; $slideTags[11]='config param'; $slideTopics[11]='Installation Configuration NewVersion';
$slide[12]='Parameters'; $slideName[12]='Parameters'; $slidePage['Parameters4']='12'; $slideTags[12]='config param'; $slideTopics[12]='Installation Configuration NewVersion';
$slide[13]='NewVersion'; $slideName[13]='Install New Version'; $slidePage['NewVersion']='13'; $slideTags[13]='install setup deploy php mysql http server zip new version release update'; $slideTopics[13]='Installation Configuration Parameters1';
$slide[14]='Connection'; $slideName[14]='Connection'; $slidePage['Connection']='14'; $slideTags[14]='connect login'; $slideTopics[14]='GuiGenerality Installation Configuration';
$slide[15]='GUI'; $slideName[15]='User Interface'; $slidePage['GuiGenerality']='15'; $slideTags[15]='gui interface'; $slideTopics[15]='Themes GuiToolbar GuiMenu GuiList GuiFilter GuiDetail';
$slide[16]='GUI'; $slideName[16]='Toolbars'; $slidePage['GuiToolbar']='16'; $slideTags[16]='gui interface toolbar show hide switch help manual'; $slideTopics[16]='Themes GuiGenerality GuiMenu GuiList GuiFilter GuiDetail';
$slide[17]='GUI'; $slideName[17]='Menu'; $slidePage['GuiMenu']='17'; $slideTags[17]='gui interface menu'; $slideTopics[17]='Themes GuiGenerality GuiToolbar GuiList GuiFilter GuiDetail';
$slide[18]='GUI'; $slideName[18]='List'; $slidePage['GuiList']='18'; $slideTags[18]='gui interface list column'; $slideTopics[18]='Themes GuiGenerality GuiToolbar GuiMenu GuiFilter GuiDetail';
$slide[19]='GUI'; $slideName[19]='Filter'; $slidePage['GuiFilter']='19'; $slideTags[19]='gui interface filter complex'; $slideTopics[19]='Themes GuiGenerality GuiToolbar GuiMenu GuiList GuiDetail';
$slide[20]='GUI'; $slideName[20]='Detail'; $slidePage['GuiDetail']='20'; $slideTags[20]='gui interface detail item save print'; $slideTopics[20]='Themes GuiGenerality GuiToolbar GuiMenu GuiList GuiFilter';
$slide[21]='Themes'; $slideName[21]='Themes'; $slidePage['Themes']='21'; $slideTags[21]='theme color'; $slideTopics[21]='GuiGenerality ThemesTemplates';
$slide[22]='Themes'; $slideName[22]='Themes templates'; $slidePage['ThemesTemplates']='22'; $slideTags[22]='theme color example'; $slideTopics[22]='GuiGenerality Themes';
$slide[23]='Multilingual'; $slideName[23]='Multilingual'; $slidePage['Multilingual']='23'; $slideTags[23]='english french german translat multiling'; $slideTopics[23]='GuiGenerality Configuration Parameters1';
$slide[24]='Creation'; $slideName[24]='Creation'; $slidePage['Creation']='24'; $slideTags[24]='creation'; $slideTopics[24]='GuiGenerality Update Delete';
$slide[25]='Update'; $slideName[25]='Update'; $slidePage['Update']='25'; $slideTags[25]='update'; $slideTopics[25]='GuiGenerality Creation Delete';
$slide[26]='Delete'; $slideName[26]='Delete'; $slidePage['Delete']='26'; $slideTags[26]='delete'; $slideTopics[26]='GuiGenerality Creation Update';
$slide[27]='Ticket'; $slideName[27]='Ticket'; $slidePage['Ticket']='27'; $slideTags[27]='ticket bug task track'; $slideTopics[27]='TicketFields GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[28]='Ticket'; $slideName[28]='Ticket fields'; $slidePage['TicketFields']='28'; $slideTags[28]='ticket bug task track'; $slideTopics[28]='Ticket GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory';
$slide[29]='Activity'; $slideName[29]='Activity'; $slidePage['Activity']='29'; $slideTags[29]='activity task planning'; $slideTopics[29]='ActivityFields ActivityAssignment ActivityProgress ActivityDependencies GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[30]='Activity'; $slideName[30]='Activity fields'; $slidePage['ActivityFields']='30'; $slideTags[30]='activity task planning'; $slideTopics[30]='Activity ActivityAssignement ActivityProgress ActivityDependencies GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[31]='Activity'; $slideName[31]='Activity Assignment'; $slidePage['ActivityAssignement']='31'; $slideTags[31]='activity task planning assignment'; $slideTopics[31]='Activity ActivityFields ActivityProgress ActivityDependencies GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[32]='Activity'; $slideName[32]='Activity Progress'; $slidePage['ActivityProgress']='32'; $slideTags[32]='activity task planning progress'; $slideTopics[32]='Activity ActivityFields ActivityAssignment ActivityDependencies  GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[33]='Activity'; $slideName[33]='Activity Dependency'; $slidePage['ActivityDependencies']='33'; $slideTags[33]='activity task planning'; $slideTopics[33]='Activity ActivityFields ActivityAssignment ActivityProgress GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[34]='Milestone'; $slideName[34]='Milestone'; $slidePage['Milestone']='34'; $slideTags[34]='milstone flag '; $slideTopics[34]='MilestoneFields MilestoneProgress MilestoneDependencies GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[35]='Milestone'; $slideName[35]='Milestone fields'; $slidePage['MilestoneFields']='35'; $slideTags[35]='milestone flag '; $slideTopics[35]='Milestone MilestoneProgress MilestoneDependencies GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[36]='Milestone'; $slideName[36]='Milestone progress'; $slidePage['MilestoneProgress']='36'; $slideTags[36]='milestone flag '; $slideTopics[36]='Milestone MilestoneFields MilestoneDependenciesGuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[37]='Milestone'; $slideName[37]='Milestone dependencies'; $slidePage['MilestoneDependencies']='37'; $slideTags[37]='milestone flag '; $slideTopics[37]='Milestone MilestoneFields MilestoneProgress GuiGenerality Creation Update Delete Type Status AutomaticEmailing Workflow Attachments Notes ChangeHistory Planning';
$slide[38]='Imputation'; $slideName[38]='Real work allocation'; $slidePage['Imputation']='38'; $slideTags[38]='imputation work follow-up allocation'; $slideTopics[38]='Activity ActivityAssignement Planning Resource Project Affectation';
$slide[39]='Planning'; $slideName[39]='Planning'; $slidePage['Planning']='39'; $slideTags[39]='planning work plan date'; $slideTopics[39]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[40]='Planning'; $slideName[40]='Planning'; $slidePage['Planning']='40'; $slideTags[40]=''; $slideTopics[40]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[41]='Planning'; $slideName[41]='Planning'; $slidePage['Planning']='41'; $slideTags[41]=''; $slideTopics[41]='ActivityAssignement ActivityProgress ActivityDependencies';
$slide[42]='X Report'; $slideName[42]='Report'; $slidePage['Report']='42'; $slideTags[42]=''; $slideTopics[42]='';
$slide[43]='X Risk'; $slideName[43]='Risk'; $slidePage['Risk']='43'; $slideTags[43]=''; $slideTopics[43]='';
$slide[44]='X Action'; $slideName[44]='Action'; $slidePage['Action']='44'; $slideTags[44]=''; $slideTopics[44]='';
$slide[45]='X Issue'; $slideName[45]='Issue'; $slidePage['Issue']='45'; $slideTags[45]=''; $slideTopics[45]='';
$slide[46]='X Meeting'; $slideName[46]='Meeting'; $slidePage['Meeting']='46'; $slideTags[46]=''; $slideTopics[46]='';
$slide[47]='X Decision'; $slideName[47]='Decision'; $slidePage['Decision']='47'; $slideTags[47]=''; $slideTopics[47]='';
$slide[48]='X Question'; $slideName[48]='Question'; $slidePage['Question']='48'; $slideTags[48]=''; $slideTopics[48]='';
$slide[49]='X Emails'; $slideName[49]='Emails'; $slidePage['Emails']='49'; $slideTags[49]=''; $slideTopics[49]='';
$slide[50]='X Message'; $slideName[50]='Message'; $slidePage['Message']='50'; $slideTags[50]=''; $slideTopics[50]='user project';
$slide[51]='Import'; $slideName[51]='Import'; $slidePage['Import']='51'; $slideTags[51]=''; $slideTopics[51]='Ticket Activity Milestone Risk Action Issue Meeting Decision Question Project Resource';
$slide[52]='X Client'; $slideName[52]='Client'; $slidePage['Client']='52'; $slideTags[52]=''; $slideTopics[52]='';
$slide[53]='X Contact'; $slideName[53]='Contact'; $slidePage['Contact']='53'; $slideTags[53]=''; $slideTopics[53]='';
$slide[54]='X Project'; $slideName[54]='Project'; $slidePage['Project']='54'; $slideTags[54]=''; $slideTopics[54]='';
$slide[55]='X User'; $slideName[55]='User'; $slidePage['User']='55'; $slideTags[55]=''; $slideTopics[55]='';
$slide[56]='X Team'; $slideName[56]='Team'; $slidePage['Team']='56'; $slideTags[56]=''; $slideTopics[56]='';
$slide[57]='X Resource'; $slideName[57]='Resource'; $slidePage['Resource']='57'; $slideTags[57]=''; $slideTopics[57]='';
$slide[58]='X Affectation'; $slideName[58]='Affectation'; $slidePage['Affectation']='58'; $slideTags[58]=''; $slideTopics[58]='';
$slide[59]='X Status'; $slideName[59]='Status'; $slidePage['Status']='59'; $slideTags[59]=''; $slideTopics[59]='Workflow Ticket Activity Milestone Risk Action Issue Meeting Decision Question';
$slide[60]='X Importance'; $slideName[60]='Severity, Likelihood, Criticallity, Urgency, Priority'; $slidePage['Importance']='60'; $slideTags[60]=''; $slideTopics[60]='';
$slide[61]='X Workflow'; $slideName[61]='Workflow'; $slidePage['Workflow']='61'; $slideTags[61]=''; $slideTopics[61]='Status Ticket Activity Milestone Risk Action Issue Meeting Decision Question';
$slide[62]='X AutomaticEmailing'; $slideName[62]='Automatic Emailing'; $slidePage['AutomaticEmailing']='62'; $slideTags[62]=''; $slideTopics[62]='';
$slide[63]='X Type'; $slideName[63]='Type'; $slidePage['Type']='63'; $slideTags[63]=''; $slideTopics[63]='Ticket Activity Milestone Risk Action Issue Meeting Decision Question';
$slide[64]='X ConnectionProfile'; $slideName[64]='Connection Profile'; $slidePage['ConnectionProfile']='64'; $slideTags[64]=''; $slideTopics[64]='';
$slide[65]='X AccessProfile'; $slideName[65]='Access Profile'; $slidePage['AccessProfile']='65'; $slideTags[65]=''; $slideTopics[65]='';
$slide[66]='X AccessToScreens'; $slideName[66]='Access to forms'; $slidePage['AccessToScreens']='66'; $slideTags[66]=''; $slideTopics[66]='';
$slide[67]='X AccessToReports'; $slideName[67]='Access to reports'; $slidePage['AccessToReports']='67'; $slideTags[67]=''; $slideTopics[67]='';
$slide[68]='X AccessMode'; $slideName[68]='Access mode to data'; $slidePage['AccessMode']='68'; $slideTags[68]=''; $slideTopics[68]='';
$slide[69]='X SpecificAccessMode'; $slideName[69]='Specific access mode'; $slidePage['SpecificAccessMode']='69'; $slideTags[69]=''; $slideTopics[69]='';
$slide[70]='X UserParameters'; $slideName[70]='User parameters'; $slidePage['UserParameters']='70'; $slideTags[70]=''; $slideTopics[70]='';
$slide[71]='Attachments'; $slideName[71]='Attachments'; $slidePage['Attachments']='71'; $slideTags[71]='attach file link'; $slideTopics[71]='Ticket Activity Milestone Risk Issue Meeting Decision Question Parameters4 UserParameters';
$slide[72]='Notes'; $slideName[72]='Notes'; $slidePage['Notes']='72'; $slideTags[72]='note comment'; $slideTopics[72]='Ticket Activity Milestone Risk Action Issue Meeting Decision Question UserParameters';
$slide[73]='ChangeHistory'; $slideName[73]='Change History'; $slidePage['ChangeHistory']='73'; $slideTags[73]='change history track update'; $slideTopics[73]='UserParameters';
$slide[74]='X Today'; $slideName[74]='Today'; $slidePage['Today']='74'; $slideTags[74]='today summary todo'; $slideTopics[74]='Message Project Ticket Activity Milestone Risk Action Issue';
$slide[75]='Shortcuts'; $slideName[75]='Shortcuts'; $slidePage['Shortcuts']='75'; $slideTags[75]='shortcut key'; $slideTopics[75]='';
$slide[76]='LastWords'; $slideName[76]='Last words'; $slidePage['LastWords']='76'; $slideTags[76]='end murphy hofstader history'; $slideTopics[76]='';

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
